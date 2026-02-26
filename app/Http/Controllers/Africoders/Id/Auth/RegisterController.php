<?php

namespace App\Http\Controllers\Africoders\Id\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\NotDisposableEmail;
use App\Services\EmailVerificationService;
use App\Services\SessionManagerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    protected $emailVerificationService;
    protected $sessionManagerService;

    public function __construct(
        EmailVerificationService $emailVerificationService,
        SessionManagerService $sessionManagerService
    ) {
        $this->emailVerificationService = $emailVerificationService;
        $this->sessionManagerService = $sessionManagerService;
    }

    /**
     * Show sign-up form.
     */
    public function showSignup(Request $request)
    {
        if (auth()->check()) {
            return redirect()->route('id.dashboard');
        }
        return view('africoders.id.auth.signup', [
            'email' => $request->query('email', ''),
        ]);
    }

    /**
     * Handle sign-up.
     */
    public function signup(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'regex:/^[a-zA-Z0-9_]{3,20}$/', 'unique:users'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:6'],
            'agree_to_terms' => ['required', 'accepted'],
            'g-recaptcha-response' => ['required'],
        ]);

        // Verify reCAPTCHA
        $recaptchaResponse = $request->input('g-recaptcha-response');
        $response = \Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $recaptchaResponse,
        ]);

        $result = $response->json();

        if (!$result['success'] || ($result['score'] ?? 1) < 0.5) {
            return back()
                ->withInput()
                ->withErrors(['g-recaptcha-response' => 'reCAPTCHA verification failed. Please try again.']);
        }

        try {
            $user = User::create([
                'full_name' => $validated['full_name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'member',
                'trust_level' => 'unverified',
            ]);

            // Create verification record
            $user->verifications()->create([
                'type' => 'identity',
                'status' => 'not_submitted',
            ]);

            // Generate and send email verification
            $token = $this->emailVerificationService->generateToken($user);
            $user->notify(new \App\Notifications\EmailVerificationNotification($token, $user));

            // Log action
            \App\Models\AuditLog::create([
                'user_id' => $user->id,
                'action' => 'signup',
                'details' => 'User registered',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            session(['signup_success' => 'Account created! Please verify your email to continue.']);
            return redirect()->route('id.auth.unified');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Registration failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Handle unified registration from unified form.
     */
    public function handleUnifiedRegister(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'regex:/^[a-zA-Z0-9_]{3,20}$/', 'unique:users'],
            'email' => ['required', 'email', 'unique:users', new NotDisposableEmail()],
            'password' => ['required', 'min:6'],
            'agree_to_terms' => ['required', 'accepted'],
            'g-recaptcha-response' => ['required'],
        ]);

        // Verify reCAPTCHA
        $recaptchaResponse = $request->input('g-recaptcha-response');
        $response = \Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $recaptchaResponse,
        ]);

        $result = $response->json();

        if (!$result['success'] || ($result['score'] ?? 1) < 0.5) {
            return back()
                ->withInput()
                ->withErrors(['g-recaptcha-response' => 'reCAPTCHA verification failed. Please try again.']);
        }

        try {
            $user = User::create([
                'full_name' => $validated['full_name'],
                'username' => $validated['username'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'member',
                'trust_level' => 'unverified',
            ]);

            // Create verification record
            $user->verifications()->create([
                'type' => 'identity',
                'status' => 'not_submitted',
            ]);

            // Generate and send email verification
            $token = $this->emailVerificationService->generateToken($user);
            $user->notify(new \App\Notifications\EmailVerificationNotification($token, $user));

            // Log action
            \App\Models\AuditLog::create([
                'user_id' => $user->id,
                'action' => 'signup',
                'details' => 'User registered',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Auto-login the user
            auth()->login($user);

            // Refresh user from database
            $user = auth()->user()->fresh();
            auth()->setUser($user);

            // Create session
            $this->sessionManagerService->createSession($user);

            return redirect()->route('id.dashboard')->with('success', 'Account created! Please verify your email to continue.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Registration failed: ' . $e->getMessage()]);
        }
    }
}
