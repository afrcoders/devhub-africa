<?php

namespace App\Http\Controllers\Africoders\Id\Auth;

use App\Http\Controllers\Controller;
use App\Models\Session;
use App\Services\JWTService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class LogoutController extends Controller
{
    protected $jwtService;

    public function __construct(JWTService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    /**
     * Handle logout request (both GET and POST).
     */
    public function logout(Request $request)
    {
        $returnUrl = $request->input('return');

        // Get the current user before logout
        $user = auth()->user();

        if ($user) {
            // Get current session token from cookie
            $currentSessionToken = $request->cookie('africoders_session');

            if ($currentSessionToken) {
                // Mark the current session as expired
                Session::where('session_token', $currentSessionToken)
                       ->where('user_id', $user->id)
                       ->update([
                           'expires_at' => now()
                       ]);
            }

            // Logout from Laravel session
            auth()->logout();
        }

        // Clear the session cookies
        $cookie = Cookie::forget('africoders_session');
        $sessionCookie = Cookie::forget(config('session.cookie'));

        // Determine redirect destination
        $redirectUrl = $this->getRedirectUrl($returnUrl);

        // If returning to a different BASE domain, create a logout nonce for that domain to clear its cookies
        if ($returnUrl && filter_var($returnUrl, FILTER_VALIDATE_URL)) {
            $parsedUrl = parse_url($returnUrl);
            $returnHost = $parsedUrl['host'] ?? null;
            $currentHost = $request->getHost();

            // Check if different base domain (not just subdomain)
            if ($returnHost && !$this->isSameBaseDomain($currentHost, $returnHost)) {
                // Different base domain - create logout nonce to clear JWT on that domain
                $userId = $user ? $user->id : 0;

                // Clean up expired logout nonces (older than 10 minutes)
                \App\Models\LogoutNonce::where('expires_at', '<', now()->subMinutes(5))->delete();

                $logoutNonce = \App\Models\LogoutNonce::create([
                    'user_id' => $userId,
                    'nonce' => \Illuminate\Support\Str::random(64),
                    'return_url' => $redirectUrl,
                    'expires_at' => now()->addMinutes(5),
                ]);

                \Log::info('Logout nonce created for cross-domain logout', [
                    'user_id' => $userId,
                    'user_logged_in' => $user ? 'yes' : 'no',
                    'nonce_id' => $logoutNonce->id,
                    'target_domain' => $returnHost,
                    'original_return_url' => $redirectUrl,
                ]);

                // Construct proper logout URL with protocol
                $protocol = $request->secure() ? 'https://' : 'http://';
                $logoutUrl = $protocol . $returnHost . '?logout_nonce=' . $logoutNonce->nonce;

                \Log::info('Redirecting to logout nonce URL', [
                    'logout_url' => $logoutUrl,
                ]);

                return redirect($logoutUrl)
                    ->withCookie($cookie)
                    ->withCookie($sessionCookie);
            }
        }

        // Same base domain - session is already cleared, just redirect
        return redirect($redirectUrl)
            ->withCookie($cookie)
            ->withCookie($sessionCookie);
    }

    /**
     * Logout from all sessions.
     */
    public function logoutAll(Request $request)
    {
        $user = auth()->user();

        if ($user) {
            // Expire all user sessions
            Session::where('user_id', $user->id)
                   ->where('expires_at', '>', now())
                   ->update([
                       'expires_at' => now()
                   ]);

            // Logout from current session
            auth()->logout();
        }

        // Clear cookies
        $cookie = Cookie::forget('africoders_session');
        $sessionCookie = Cookie::forget(config('session.cookie'));
        // Clear JWT auth token cookie with proper domain (dynamic from config)
        $domain = config('domains.africoders.id', 'id.africoders.test');
        $cookieDomain = '.' . substr($domain, strpos($domain, 'africoders'));
        $authTokenCookie = Cookie::forget('auth_token', '/', $cookieDomain);

        $returnUrl = $request->input('return');
        $redirectUrl = $this->getRedirectUrl($returnUrl);

        return redirect($redirectUrl)
            ->withCookie($cookie)
            ->withCookie($sessionCookie)
            ->withCookie($authTokenCookie)
            ->with('success', 'You have been logged out from all devices.');
    }

    /**
     * Get the redirect URL after logout.
     */
    private function getRedirectUrl(?string $returnUrl): string
    {
        // If return URL is provided and valid, use it
        if ($returnUrl && filter_var($returnUrl, FILTER_VALIDATE_URL)) {
            $parsedUrl = parse_url($returnUrl);

            if (isset($parsedUrl['host'])) {
                $trustedDomains = config('domains.trusted_domains', []);

                foreach ($trustedDomains as $domain) {
                    if (str_ends_with($parsedUrl['host'], $domain)) {
                        return $returnUrl;
                    }
                }
            }
        }

        // Default redirect to unified auth page
        return route('id.auth.unified');
    }

    /**
     * Check if two hosts are in the same domain group.
     */
    private function isSameDomain(string $host1, string $host2): bool
    {
        $base1 = $this->getBaseDomain($host1);
        $base2 = $this->getBaseDomain($host2);

        return $base1 === $base2;
    }

    /**
     * Extract the base domain from a host/URL.
     */
    private function getBaseDomain($url): string
    {
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            $url = parse_url($url, PHP_URL_HOST);
        }

        // Remove www. prefix if present
        $url = preg_replace('/^www\./', '', $url);

        // Extract the base domain (e.g., africoders.test from api.africoders.test)
        $parts = explode('.', $url);

        if (count($parts) >= 2) {
            // Get last two parts (domain.tld)
            return implode('.', array_slice($parts, -2));
        }

        return $url;
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
}
