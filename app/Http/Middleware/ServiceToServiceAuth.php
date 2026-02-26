<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Service-to-Service Authentication middleware.
 * Validates requests from internal services using shared secrets.
 */
class ServiceToServiceAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        $serviceId = $request->header('X-Service-Id');
        $signature = $request->header('X-Service-Signature');

        if (!$serviceId || !$signature) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'Missing service authentication headers.',
                'code' => 401,
            ], 401);
        }

        // Validate service signature
        if (!$this->validateSignature($serviceId, $signature, $request)) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'Invalid service signature.',
                'code' => 401,
            ], 401);
        }

        // Store service info in request
        $request->attributes->set('service_id', $serviceId);

        return $next($request);
    }

    /**
     * Validate service signature using HMAC.
     *
     * @param string $serviceId
     * @param string $signature
     * @param Request $request
     * @return bool
     */
    private function validateSignature(string $serviceId, string $signature, Request $request): bool
    {
        $secret = config("api.services.{$serviceId}.secret");

        if (!$secret) {
            return false;
        }

        $payload = $request->method() . '|' . $request->path() . '|' . $request->getContent();
        $expectedSignature = hash_hmac('sha256', $payload, $secret);

        return hash_equals($expectedSignature, $signature);
    }
}
