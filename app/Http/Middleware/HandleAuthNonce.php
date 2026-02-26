<?php

namespace App\Http\Middleware;

use App\Models\AuthNonce;
use App\Services\JWTService;
use Closure;
use Illuminate\Http\Request;

class HandleAuthNonce
{
    /**
     * Handle an incoming request.
     *
     * This middleware intercepts requests containing an auth_nonce parameter,
     * exchanges it for a JWT token, sets the auth cookie, and redirects to the
     * original return URL.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if auth_nonce parameter exists
        $nonce = $request->query('auth_nonce');

        if (!$nonce) {
            return $next($request);
        }

        \Log::info('HandleAuthNonce: Processing nonce', [
            'nonce' => substr($nonce, 0, 10) . '...',
            'request_url' => $request->url(),
            'path' => $request->path(),
        ]);

        // Look up the nonce in the database
        $authNonce = AuthNonce::where('nonce', $nonce)->first();

        if (!$authNonce || !$authNonce->isValid()) {
            \Log::warning('HandleAuthNonce: Invalid or expired nonce', [
                'nonce' => substr($nonce, 0, 10) . '...',
                'found' => $authNonce ? 'yes' : 'no',
                'valid' => $authNonce ? ($authNonce->isValid() ? 'yes' : 'no') : 'N/A',
            ]);

            // Invalid nonce, just continue without auth
            return $next($request);
        }

        // Get the user associated with this nonce
        $user = $authNonce->user;

        if (!$user) {
            \Log::error('HandleAuthNonce: Nonce found but user not found', [
                'nonce_id' => $authNonce->id,
                'user_id' => $authNonce->user_id,
            ]);

            return $next($request);
        }

        // Generate JWT token - pass the user object and expiration seconds
        $token = JWTService::generateToken($user, config('auth.jwt_expiration', 3600));

        \Log::info('HandleAuthNonce: JWT token generated', [
            'user_id' => $user->id,
            'email' => $user->email,
            'token_length' => strlen($token),
        ]);

        // Mark nonce as used
        $authNonce->markAsUsed();

        // Get the return URL from the nonce record, or use the request path
        $returnUrl = $authNonce->return_url;

        // Remove the nonce parameter from the return URL if it's there
        if ($returnUrl) {
            $returnUrl = preg_replace('/[?&]auth_nonce=[^&]*/', '', $returnUrl);
        } else {
            // Fallback: use the current request path but without the nonce parameter
            $returnUrl = $request->url();
            $returnUrl = preg_replace('/[?&]auth_nonce=[^&]*/', '', $returnUrl);
        }

        \Log::info('HandleAuthNonce: Nonce exchange successful, redirecting', [
            'user_id' => $user->id,
            'return_url' => $returnUrl,
            'original_return_url' => $authNonce->return_url,
        ]);

        // Create response to redirect
        $response = redirect($returnUrl);

        // Set the auth_token cookie on the response
        // Calculate expiration (1 hour)
        $expiresIn = 3600;

        // Determine cookie domain - use shared domain for *.africoders subdomains
        $cookieDomain = $this->getCookieDomain();

        $response->cookie('auth_token', $token, $expiresIn, '/', $cookieDomain, true, true);

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
