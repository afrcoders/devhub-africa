<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * API Response Formatting middleware.
 * Ensures consistent JSON response format across all API endpoints.
 */
class ApiResponseFormatting
{
    public function handle(Request $request, Closure $next): Response
    {
        // Set proper API response headers
        $response = $next($request);

        // Ensure JSON content type
        if (!$response->headers->has('Content-Type')) {
            $response->header('Content-Type', 'application/json');
        }

        // Add API version header
        $response->header('X-API-Version', '1.0');

        return $response;
    }
}
