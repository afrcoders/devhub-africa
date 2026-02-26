<?php

namespace App\Http\Controllers\Africoders\Id\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\NotDisposableEmail;
use App\Services\EmailVerificationService;
use App\Services\JWTService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Cookie;

class LoginController extends Controller
{
    protected $emailVerificationService;

    public function __construct(
        EmailVerificationService $emailVerificationService
    ) {
        $this->emailVerificationService = $emailVerificationService;
    }

    /**
     * Show unified auth page (login/register combined).
     */
    public function showUnifiedAuth(Request $request)
    {
        if (auth()->check()) {
            // Check for return URL if user is already logged in
            $returnUrl = $request->input('return');

            if ($returnUrl && filter_var($returnUrl, FILTER_VALIDATE_URL)) {
                // Only allow returns to our trusted domains
                $parsedUrl = parse_url($returnUrl);
                $isAllowed = false;

                if (isset($parsedUrl['host'])) {
                    $trustedDomains = config('domains.trusted_domains', []);
                    foreach ($trustedDomains as $domain) {
                        if (str_ends_with($parsedUrl['host'], $domain)) {
                            $isAllowed = true;
                            break;
                        }
                    }
                }

                if ($isAllowed) {
                    // Check if target domain is same as current
                    $currentHost = $request->getHost();
                    $returnHost = $parsedUrl['host'];

                    if ($this->isSameDomain($currentHost, $returnHost)) {
                        // Same domain - can set cookie directly and redirect
                        $user = auth()->user();
                        $jwtToken = JWTService::generateToken($user, config('auth.jwt_expiration', 3600));

                        $tokenCookie = Cookie::create('auth_token')
                            ->withValue($jwtToken)
                            ->withExpires(time() + config('auth.jwt_expiration', 3600))
                            ->withPath('/')
                            ->withHttpOnly(true)
                            ->withSecure(config('app.env') === 'production')
                            ->withSameSite('Lax');

                        return redirect($returnUrl)->withCookie($tokenCookie);
                    } else {
                        // Different domain - use nonce exchange
                        return $this->redirectWithNonce(auth()->user(), $returnUrl);
                    }
                }
            }
            return redirect()->route('id.dashboard');
        }
        return view('africoders.id.auth.unified-auth');
    }

    /**
     * Handle unified auth (login or register).
     */
    public function unifiedAuth(Request $request)
    {
        $authType = $request->input('auth_type', 'login');

        if ($authType === 'register') {
            return redirect()->route('register');
        } else {
            return $this->handleUnifiedLogin($request);
        }
    }

    /**
     * Check if user exists (AJAX).
     */
    public function checkUser(Request $request)
    {
        $email = $request->input('email');

        $user = User::where('email', $email)
            ->orWhere('username', $email)
            ->first();

        return response()->json([
            'exists' => $user !== null,
        ]);
    }

    /**
     * Handle login from unified form.
     */
    private function handleUnifiedLogin(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Try to find user by email or username
        $user = User::where('email', $validated['email'])
            ->orWhere('username', $validated['email'])
            ->first();

        // Check if user exists and password is correct
        if (!$user) {
            \App\Models\AuditLog::create([
                'action' => 'login_failed',
                'details' => 'User not found: ' . $validated['email'],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return back()
                ->withInput()
                ->withErrors(['email' => 'No account found with that email or username']);
        }

        if (!Hash::check($validated['password'], $user->password)) {
            \App\Models\AuditLog::create([
                'user_id' => $user->id,
                'action' => 'login_failed',
                'details' => 'Invalid password for: ' . $validated['email'],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return back()
                ->withInput()
                ->withErrors(['password' => 'Invalid password']);
        }

        // Check if user is active
        if (!$user->is_active) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'Your account is disabled. Please contact support.']);
        }

        // Log in the user
        auth()->login($user, $request->boolean('remember'));

        // Refresh user to get latest data from database
        $user = auth()->user()->fresh();
        auth()->setUser($user);

        // Debug: Check session after login
        \Log::info('After auth()->login() in login()', [
            'user_id' => $user->id,
            'session_id' => session()->getId(),
            'session_data' => session()->all(),
            'auth_check' => auth()->check(),
        ]);

        // Update last login
        $user->update(['last_login' => now()]);

        // Generate JWT token for cross-domain authentication
        $jwtToken = JWTService::generateToken($user, config('auth.jwt_expiration', 3600));

        // Log action
        \App\Models\AuditLog::create([
            'user_id' => $user->id,
            'action' => 'login_success',
            'details' => 'User logged in',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Check for return URL
        $returnUrl = $request->input('return');
        $host = $request->getHost();

        if ($returnUrl && filter_var($returnUrl, FILTER_VALIDATE_URL)) {
            // Only allow returns to our trusted domains
            $trustedDomains = config('domains.trusted_domains', []);
            $parsedUrl = parse_url($returnUrl);
            $isAllowed = false;

            if (isset($parsedUrl['host'])) {
                foreach ($trustedDomains as $domain) {
                    if (str_ends_with($parsedUrl['host'], $domain)) {
                        $isAllowed = true;
                        break;
                    }
                }
            }

            if ($isAllowed) {
                $returnHost = $parsedUrl['host'];

                // Check if same base domain (*.africoders)
                if ($this->isSameBaseDomain($host, $returnHost)) {
                    // Same base domain - use native session (already logged in), just redirect
                    // No JWT cookie needed - session is shared via SESSION_DOMAIN
                    return redirect($returnUrl);
                } else {
                    // Different base domain - use JWT + nonce exchange
                    return $this->redirectWithNonce($user, $returnUrl);
                }
            }
        }

        // Default - no JWT cookie needed, session handles it, redirect to dashboard
        return redirect()->route('id.dashboard');
    }

    /**
     * Show login form.
     */
    public function showLogin()
    {
        if (auth()->check()) {
            return redirect()->route('id.dashboard');
        }
        return view('africoders.id.auth.login');
    }

    /**
     * Handle login.
     */
    public function login(Request $request)
    {
        // Handle user existence check (AJAX) - check for missing password field
        $isJsonRequest = $request->expectsJson() ||
                        $request->header('Content-Type') === 'application/json' ||
                        str_contains($request->header('Content-Type') ?? '', 'application/json');

        if ($isJsonRequest && !$request->has('password')) {
            $email = $request->json('email') ?: $request->input('email');
            if (!$email) {
                return response()->json(['userExists' => false], 400);
            }

            $user = User::where('email', $email)
                ->orWhere('username', $email)
                ->first();

            return response()->json([
                'userExists' => !!$user,
                'fullName' => $user?->full_name,
                'username' => $user?->username,
            ]);
        }

        // Handle password authentication
        $validated = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Try to find user by email or username
        $user = User::where('email', $validated['email'])
            ->orWhere('username', $validated['email'])
            ->first();

        // Check if user exists and password is correct
        if (!$user) {
            \App\Models\AuditLog::create([
                'action' => 'login_failed',
                'details' => 'User not found: ' . $validated['email'],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return back()
                ->withInput()
                ->withErrors(['email' => 'No account found with that email or username']);
        }

        if (!Hash::check($validated['password'], $user->password)) {
            \App\Models\AuditLog::create([
                'user_id' => $user->id,
                'action' => 'login_failed',
                'details' => 'Invalid password for: ' . $validated['email'],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return back()
                ->withInput()
                ->withErrors(['password' => 'Invalid password']);
        }

        // Check if user is active
        if (!$user->is_active) {
            return back()
                ->withInput()
                ->withErrors(['email' => 'Your account is disabled. Please contact support.']);
        }

        // Log in the user
        auth()->login($user, $request->boolean('remember'));

        // Refresh user to get latest data from database
        $user = auth()->user()->fresh();
        auth()->setUser($user);

        // Update last login
        $user->update(['last_login' => now()]);

        // Create session and get token
        $sessionToken = $this->sessionManagerService->createSession($user);

        // Log action
        \App\Models\AuditLog::create([
            'user_id' => $user->id,
            'action' => 'login_success',
            'details' => 'User logged in',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('id.dashboard');
    }

    /**
     * Show email verification page.
     */
    public function showEmailVerification()
    {
        if (!auth()->check()) {
            return redirect()->route('id.auth.unified');
        }

        if (auth()->user()->hasVerifiedEmail()) {
            return redirect()->route('id.dashboard');
        }

        return view('africoders.id.auth.verify-email');
    }

    /**
     * Verify email token.
     */
    public function verifyEmail(Request $request)
    {
        $token = $request->query('token');

        if (!$token) {
            return redirect()->route('id.verify-email')
                ->withErrors(['error' => 'Verification token is missing']);
        }

        $user = $this->emailVerificationService->verifyToken($token);

        if (!$user) {
            return redirect()->route('id.verify-email')
                ->withErrors(['error' => 'Invalid or expired verification token']);
        }

        // Log the state after verification
        \Log::info('Email verification', [
            'user_id' => $user->id,
            'email_verified' => $user->email_verified,
            'email_verified_at' => $user->email_verified_at,
        ]);

        // Refresh user to ensure we have the latest email_verified status from database
        $user = $user->fresh();

        \Log::info('Email verification after fresh', [
            'user_id' => $user->id,
            'email_verified' => $user->email_verified,
            'email_verified_at' => $user->email_verified_at,
        ]);

        // If user is logged in, update the session with refreshed user
        if (auth()->check()) {
            if (auth()->id() === $user->id) {
                auth()->setUser($user);
            }
        } else {
            // If user is not logged in, log them in as this user
            auth()->login($user, remember: true);
        }

        \Log::info('Email verification final state', [
            'user_id' => auth()->id(),
            'auth_email_verified' => auth()->user()->email_verified,
        ]);

        return redirect()->route('id.dashboard')->with('success', 'Email verified successfully!');
    }

    /**
     * Resend verification email.
     */
    public function resendVerification(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('id.auth.unified');
        }

        $user = auth()->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('id.dashboard');
        }

        $token = $this->emailVerificationService->resendVerificationEmail($user);

        \App\Models\AuditLog::create([
            'user_id' => $user->id,
            'action' => 'resend_verification',
            'details' => 'User requested verification email resend',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        session(['verification_sent' => 'Verification email sent. Please check your inbox.']);
        return back();
    }

    /**
     * Show change password form.
     */
    public function showChangePassword()
    {
        if (!auth()->check()) {
            return redirect()->route('id.auth.unified');
        }
        return view('africoders.id.auth.change-password');
    }

    /**
     * Handle change password.
     */
    public function changePassword(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('id.auth.unified');
        }

        $validated = $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'min:6'],
        ]);

        $user = auth()->user();

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        try {
            $user->update([
                'password' => Hash::make($validated['new_password']),
                'password_changed_at' => now(),
            ]);

            // Logout from all devices for security
            $user->logoutAllSessions();

            // Log action
            \App\Models\AuditLog::create([
                'user_id' => $user->id,
                'action' => 'password_changed',
                'details' => 'User changed password - all sessions ended for security',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('id.auth.unified')->with('success', 'Password changed successfully. Please log in with your new password.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Password change failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Check if two hosts are in the same domain group
     */
    private function isSameDomain(string $host1, string $host2): bool
    {
        // Extract base domain
        $domain1 = $this->getBaseDomain($host1);
        $domain2 = $this->getBaseDomain($host2);

        return $domain1 === $domain2;
    }

    /**
     * Get the base domain from a host
     * e.g., "admin.africoders.test" -> "africoders.test"
     */
    private function getBaseDomain(string $host): string
    {
        // Remove port if present
        $host = explode(':', $host)[0];

        // Match known patterns
        if (preg_match('/(.+\.)?(africoders\.(?:test|com))$/', $host, $m)) {
            return $m[2];
        } elseif (preg_match('/(.+\.)?(noccea\.(?:test|com))$/', $host, $m)) {
            return $m[2];
        } elseif (preg_match('/(.+\.)?(kortextools\.(?:test|com))$/', $host, $m)) {
            return $m[2];
        }

        return $host;
    }

    /**
     * Check if two hosts share the same base domain (*.africoders.test)
     */
    private function isSameBaseDomain(string $host1, string $host2): bool
    {
        $base1 = $this->getBaseDomain($host1);
        $base2 = $this->getBaseDomain($host2);

        return $base1 === $base2;
    }

    /**
     * Get the cookie domain for shared authentication.
     * Returns .africoders.test for *.africoders.test subdomains, null for other domains.
     */
    private function getCookieDomain(): ?string
    {
        $host = request()->getHost();

        // Check if it's an africoders subdomain
        if (str_ends_with($host, '.africoders.test') || $host === 'africoders.test') {
            return '.africoders.test';
        }

        if (str_ends_with($host, '.africoders.com') || $host === 'africoders.com') {
            return '.africoders.com';
        }

        // For other domains (kortextools, noccea), don't share cookies
        return null;
    }

    /**
     * Redirect to target domain with nonce for authentication
     */
    private function redirectWithNonce(User $user, string $returnUrl)
    {
        // Clean up expired nonces (older than 10 minutes)
        \App\Models\AuthNonce::where('expires_at', '<', now()->subMinutes(5))->delete();

        // Generate a unique nonce
        $nonce = \Illuminate\Support\Str::random(64);

        // Store nonce in database
        $authNonce = \App\Models\AuthNonce::create([
            'user_id' => $user->id,
            'nonce' => $nonce,
            'return_url' => $returnUrl,
            'expires_at' => now()->addMinutes(5), // Nonce expires in 5 minutes
        ]);

        \Log::info('Nonce created for cross-domain auth', [
            'user_id' => $user->id,
            'nonce_id' => $authNonce->id,
            'nonce_first_10' => substr($nonce, 0, 10),
            'return_url' => $returnUrl,
        ]);

        // Add nonce to return URL
        $separator = str_contains($returnUrl, '?') ? '&' : '?';
        $redirectUrl = $returnUrl . $separator . 'auth_nonce=' . $nonce;

        \Log::info('Redirecting with nonce', ['redirect_url' => $redirectUrl]);

        return redirect($redirectUrl);
    }

    /**
     * Exchange nonce for JWT token (called from other domains)
     */
    public function exchangeNonce(Request $request)
    {
        $nonce = $request->input('nonce');

        \Log::info('Nonce exchange attempt', ['nonce' => substr($nonce ?? '', 0, 10)]);

        if (!$nonce) {
            return response()->json(['error' => 'Nonce is required'], 400);
        }

        // Find and validate nonce
        $authNonce = \App\Models\AuthNonce::where('nonce', $nonce)->first();

        \Log::info('Nonce lookup result', ['found' => $authNonce ? true : false]);

        if (!$authNonce) {
            return response()->json(['error' => 'Invalid nonce'], 404);
        }

        if (!$authNonce->isValid()) {
            \Log::warning('Nonce invalid', ['nonce_id' => $authNonce->id, 'used_at' => $authNonce->used_at, 'expires_at' => $authNonce->expires_at]);
            return response()->json(['error' => 'Nonce has expired or been used'], 401);
        }

        // Mark nonce as used
        $authNonce->markAsUsed();

        // Generate JWT token
        $user = $authNonce->user;
        $jwtToken = JWTService::generateToken($user, config('auth.jwt_expiration', 3600));

        \Log::info('Nonce exchanged successfully', ['user_id' => $user->id, 'nonce_id' => $authNonce->id]);

        return response()->json([
            'token' => $jwtToken,
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'username' => $user->username,
                'full_name' => $user->full_name,
            ],
        ]);
    }
}
