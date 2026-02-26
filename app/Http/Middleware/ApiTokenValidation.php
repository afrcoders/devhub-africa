<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Validates Bearer tokens for internal API requests.
 * Checks that a valid Bearer token is present and valid.
 */
class ApiTokenValidation
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'Missing or invalid Bearer token.',
                'code' => 401,
            ], 401);
        }

        // Validate token format and existence
        if (!$this->isValidToken($token)) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'Invalid or expired token.',
                'code' => 401,
            ], 401);
        }

        // Store token info in request for later use
        $request->attributes->set('api_token', $token);

        return $next($request);
    }

    /**
     * Validate token format and check against service tokens.
     *
     * @param string $token
     * @return bool
     */
    private function isValidToken(string $token): bool
    {
        // Token format check: should start with specific prefix
        if (!preg_match('/^token_|sk_|internal_/', $token)) {
            return false;
        }

        // Check token against configured service tokens
        $validTokens = [
            config('api.tokens.noccea'),
            config('api.tokens.kortex'),
            config('api.tokens.internal'),
        ];

        return in_array($token, array_filter($validTokens));
    }
}
