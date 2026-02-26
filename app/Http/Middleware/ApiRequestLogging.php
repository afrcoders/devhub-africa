<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * API Request Logging middleware.
 * Logs all API requests for audit, debugging, and monitoring.
 */
class ApiRequestLogging
{
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);
        $requestId = uniqid('req_');

        // Add request ID to request
        $request->attributes->set('request_id', $requestId);

        // Log incoming request
        \Log::channel('api')->info('API Request', [
            'request_id' => $requestId,
            'method' => $request->method(),
            'path' => $request->path(),
            'ip' => $request->ip(),
            'service_id' => $request->header('X-Service-Id'),
            'timestamp' => now()->toIso8601String(),
        ]);

        $response = $next($request);

        // Log response
        $duration = round((microtime(true) - $startTime) * 1000, 2);
        \Log::channel('api')->info('API Response', [
            'request_id' => $requestId,
            'status' => $response->status(),
            'duration_ms' => $duration,
        ]);

        // Add request ID to response headers
        $response->header('X-Request-Id', $requestId);
        $response->header('X-Response-Time', $duration . 'ms');

        return $response;
    }
}
