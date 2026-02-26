<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

/**
 * ApiResponse Trait
 * Provides consistent JSON response formatting across all API endpoints.
 */
trait ApiResponse
{
    /**
     * Return a successful response with data.
     *
     * @param mixed $data
     * @param string $message
     * @param int $status
     * @return JsonResponse
     */
    protected function success($data = null, string $message = '', int $status = 200): JsonResponse
    {
        $response = [
            'success' => true,
            'data' => $data,
            'message' => $message,
            'timestamp' => now()->toIso8601String(),
        ];

        // Add request ID if available
        if (request()->attributes->has('request_id')) {
            $response['request_id'] = request()->attributes->get('request_id');
        }

        return response()->json($response, $status);
    }

    /**
     * Return a created response (201).
     *
     * @param mixed $data
     * @param string $message
     * @return JsonResponse
     */
    protected function created($data = null, string $message = 'Resource created successfully'): JsonResponse
    {
        return $this->success($data, $message, 201);
    }

    /**
     * Return an accepted response (202 for async).
     *
     * @param mixed $data
     * @param string $message
     * @return JsonResponse
     */
    protected function accepted($data = null, string $message = 'Request accepted'): JsonResponse
    {
        return $this->success($data, $message, 202);
    }

    /**
     * Return an error response.
     *
     * @param string $error Error type/code
     * @param string $message
     * @param int $status
     * @param array $errors Detailed errors
     * @return JsonResponse
     */
    protected function error(string $error, string $message = '', int $status = 400, array $errors = []): JsonResponse
    {
        $response = [
            'success' => false,
            'error' => $error,
            'message' => $message,
            'code' => $status,
            'timestamp' => now()->toIso8601String(),
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        // Add request ID if available
        if (request()->attributes->has('request_id')) {
            $response['request_id'] = request()->attributes->get('request_id');
        }

        return response()->json($response, $status);
    }

    /**
     * Return a 400 Bad Request error.
     *
     * @param string $message
     * @param array $errors
     * @return JsonResponse
     */
    protected function badRequest(string $message = 'Bad request', array $errors = []): JsonResponse
    {
        return $this->error('Bad Request', $message, 400, $errors);
    }

    /**
     * Return a 401 Unauthorized error.
     *
     * @param string $message
     * @return JsonResponse
     */
    protected function unauthorized(string $message = 'Unauthorized'): JsonResponse
    {
        return $this->error('Unauthorized', $message, 401);
    }

    /**
     * Return a 403 Forbidden error.
     *
     * @param string $message
     * @return JsonResponse
     */
    protected function forbidden(string $message = 'Forbidden'): JsonResponse
    {
        return $this->error('Forbidden', $message, 403);
    }

    /**
     * Return a 404 Not Found error.
     *
     * @param string $message
     * @return JsonResponse
     */
    protected function notFound(string $message = 'Not found'): JsonResponse
    {
        return $this->error('Not Found', $message, 404);
    }

    /**
     * Return a 429 Too Many Requests error.
     *
     * @param string $message
     * @param int $retryAfter
     * @return JsonResponse
     */
    protected function rateLimited(string $message = 'Rate limit exceeded', int $retryAfter = 60): JsonResponse
    {
        $response = response()->json([
            'success' => false,
            'error' => 'Too Many Requests',
            'message' => $message,
            'code' => 429,
            'retry_after' => $retryAfter,
            'timestamp' => now()->toIso8601String(),
        ], 429);

        return $response->header('Retry-After', $retryAfter);
    }

    /**
     * Return a 500 Internal Server Error.
     *
     * @param string $message
     * @return JsonResponse
     */
    protected function internalError(string $message = 'Internal server error'): JsonResponse
    {
        return $this->error('Internal Server Error', $message, 500);
    }
}
