<?php

namespace App\Http\Middleware;

use App\Models\LogoutNonce;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class HandleLogoutNonce
{
    /**
     * Handle an incoming request.
     *
     * This middleware intercepts requests containing a logout_nonce parameter,
     * clears the JWT auth cookie, and redirects to the original return URL.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if logout_nonce parameter exists
        $nonce = $request->query('logout_nonce');

        if (!$nonce) {
            return $next($request);
        }

        \Log::info('HandleLogoutNonce: Processing logout nonce', [
            'nonce' => substr($nonce, 0, 10) . '...',
            'request_url' => $request->url(),
            'path' => $request->path(),
        ]);

        // Look up the nonce in the database
        $logoutNonce = LogoutNonce::where('nonce', $nonce)->first();

        if (!$logoutNonce || !$logoutNonce->isValid()) {
            \Log::warning('HandleLogoutNonce: Invalid or expired logout nonce', [
                'nonce' => substr($nonce, 0, 10) . '...',
                'found' => $logoutNonce ? 'yes' : 'no',
                'valid' => $logoutNonce ? ($logoutNonce->isValid() ? 'yes' : 'no') : 'N/A',
            ]);

            // Invalid nonce, just continue
            return $next($request);
        }

        \Log::info('HandleLogoutNonce: Valid logout nonce found', [
            'nonce_id' => $logoutNonce->id,
            'user_id' => $logoutNonce->user_id,
        ]);

        // Mark nonce as used
        $logoutNonce->markAsUsed();

        // Clean up old/used logout nonces (older than 10 minutes or already used)
        LogoutNonce::where(function ($query) {
            $query->where('expires_at', '<', now()->subMinutes(10))
                  ->orWhereNotNull('used_at');
        })->delete();

        // Delete this nonce after use
        $logoutNonce->delete();

        // Get the return URL
        $returnUrl = $logoutNonce->return_url;

        // Remove the logout_nonce parameter from the return URL if it's there
        if ($returnUrl) {
            $returnUrl = preg_replace('/[?&]logout_nonce=[^&]*/', '', $returnUrl);
        } else {
            // Fallback: use the current request path but without the logout nonce parameter
            $returnUrl = $request->url();
            $returnUrl = preg_replace('/[?&]logout_nonce=[^&]*/', '', $returnUrl);
        }

        \Log::info('HandleLogoutNonce: Logout nonce processed, redirecting', [
            'user_id' => $logoutNonce->user_id,
            'return_url' => $returnUrl,
        ]);

        // Create response to redirect
        $response = redirect($returnUrl);

        // Clear the auth_token cookie with proper domain
        $cookieDomain = $this->getCookieDomain();
        $response->withCookie(Cookie::forget('auth_token', '/', $cookieDomain));

        return $response;
    }

    /**
     * Get the cookie domain for auth_token.
     * Returns shared domain for *.africoders subdomains, null for other domains.
     */
    private function getCookieDomain(): ?string
    {
        $host = request()->getHost();

        // Check if it's an africoders subdomain
        if (str_ends_with($host, '.africoders.test')) {
            return '.africoders.test';
        }

        if (str_ends_with($host, '.africoders.com')) {
            return '.africoders.com';
        }

        // For kortextools, use explicit domain
        if ($host === 'kortextools.test' || str_ends_with($host, '.kortextools.test')) {
            return '.kortextools.test';
        }

        if ($host === 'kortextools.com' || str_ends_with($host, '.kortextools.com')) {
            return '.kortextools.com';
        }

        // For noccea domains
        if (str_ends_with($host, '.noccea.test')) {
            return '.noccea.test';
        }

        if (str_ends_with($host, '.noccea.com')) {
            return '.noccea.com';
        }

        // For other domains, don't share cookies
        return null;
    }
}
