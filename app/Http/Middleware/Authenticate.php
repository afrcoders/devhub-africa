<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use App\Services\JWTService;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, \Closure $next, ...$guards)
    {
        // First, try to authenticate from session (normal case)
        if (!auth()->check()) {
            // If no session, try JWT token
            $token = $request->cookie('auth_token');
            if ($token) {
                $decoded = JWTService::verifyToken($token);
                if ($decoded && isset($decoded->user_id)) {
                    $user = \App\Models\User::find($decoded->user_id);
                    if ($user && $user->is_active) {
                        // Authenticate the user
                        auth()->setUser($user);
                        // Now auth()->check() should return true
                    }
                }
            }
        }

        // Now call parent which will check auth()->check() and redirect if needed
        return parent::handle($request, $next, ...$guards);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        @file_put_contents('/tmp/authenticate_middleware.log', date('Y-m-d H:i:s') . " - {$request->getHost()}{$request->path()} - user=" . (auth()->user() ? auth()->user()->id : 'none') . "\n", FILE_APPEND);

        if ($request->expectsJson()) {
            return null;
        }

        // Build the return URL for cross-domain authentication
        $returnUrl = $request->url();

        return route('id.auth.unified') . '?return=' . urlencode($returnUrl);
    }
}

