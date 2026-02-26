<?php

namespace App\Http\Middleware;

use App\Services\JWTService;
use Closure;
use Illuminate\Http\Request;

class ValidateJWTToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $host = $request->getHost();

        // Skip JWT validation for *.africoders.test domains - they use native session
        if (str_ends_with($host, '.africoders.test') || $host === 'africoders.test') {
            return $next($request);
        }

        if (str_ends_with($host, '.africoders.com') || $host === 'africoders.com') {
            return $next($request);
        }

        // Skip JWT validation if this is a logout nonce request
        // (HandleLogoutNonce middleware already processed it and cleared the cookie)
        if ($request->query('logout_nonce')) {
            return $next($request);
        }

        // For other domains (kortextools, noccea), check JWT token
        $token = $request->cookie('auth_token');

        @file_put_contents('/tmp/jwt_middleware.log', date('Y-m-d H:i:s') . " - {$request->getHost()}{$request->path()} - token=" . ($token ? substr($token, 0, 20) : 'none') . "\n", FILE_APPEND);

        if ($token) {
            // Verify and decode the JWT token
            $decoded = JWTService::verifyToken($token);

            @file_put_contents('/tmp/jwt_middleware.log', "   decoded=" . ($decoded ? 'yes' : 'no') . "\n", FILE_APPEND);

            if ($decoded && isset($decoded->user_id)) {
                // Get the user from the token
                $user = \App\Models\User::find($decoded->user_id);

                @file_put_contents('/tmp/jwt_middleware.log', "   user_found=" . ($user ? 'yes' : 'no') . " active=" . ($user && $user->is_active ? 'yes' : 'no') . "\n", FILE_APPEND);

                if ($user && $user->is_active) {
                    // Set the user in the auth guard
                    auth()->setUser($user);

                    // Also store in session so it persists (for session guard)
                    session(['authenticated_user_id' => $user->id]);

                    @file_put_contents('/tmp/jwt_middleware.log', "   AUTH SET for user {$user->id}\n", FILE_APPEND);
                }
            }
        }

        return $next($request);
    }
}
