<?php

namespace App\Services;

/**
 * API Contract Service
 * Defines and validates internal API contracts between services.
 */
class ApiContractService
{
    /**
     * Get request contract for an endpoint.
     *
     * @param string $endpoint e.g., 'v1.internal.auth.validate-token'
     * @return array|null
     */
    public function getRequestContract(string $endpoint): ?array
    {
        $contracts = [
            'v1.internal.auth.validate-token' => [
                'method' => 'POST',
                'headers' => [
                    'Authorization' => 'required|string|starts_with:Bearer',
                    'X-Request-Id' => 'optional|string',
                ],
                'body' => [],
            ],
            'v1.internal.users.verify-email' => [
                'method' => 'POST',
                'headers' => [
                    'Authorization' => 'required|string|starts_with:Bearer',
                ],
                'body' => [
                    'email' => 'required|email',
                ],
            ],
            'v1.internal.sessions.create' => [
                'method' => 'POST',
                'headers' => [
                    'Authorization' => 'required|string|starts_with:Bearer',
                ],
                'body' => [
                    'user_id' => 'required|integer',
                    'ip_address' => 'optional|ip',
                    'user_agent' => 'optional|string',
                ],
            ],
            'v1.internal.bots.whatsapp.webhook' => [
                'method' => 'POST',
                'headers' => [
                    'X-Webhook-Signature' => 'required|string',
                ],
                'body' => [
                    'from' => 'required|string',
                    'message' => 'required|string',
                    'timestamp' => 'required|integer',
                ],
            ],
            'v1.internal.services.ping' => [
                'method' => 'POST',
                'headers' => [
                    'Authorization' => 'required|string|starts_with:Bearer',
                ],
                'body' => [
                    'service' => 'required|string',
                ],
            ],
        ];

        return $contracts[$endpoint] ?? null;
    }

    /**
     * Get response contract for an endpoint.
     *
     * @param string $endpoint
     * @return array|null
     */
    public function getResponseContract(string $endpoint): ?array
    {
        $contracts = [
            'v1.internal.auth.validate-token' => [
                'status' => 200,
                'body' => [
                    'valid' => 'boolean',
                    'user_id' => 'integer|null',
                    'scopes' => 'array',
                ],
            ],
            'v1.internal.auth.refresh-token' => [
                'status' => 201,
                'body' => [
                    'token' => 'string',
                    'expires_in' => 'integer',
                    'token_type' => 'string',
                ],
            ],
            'v1.internal.users.verify-email' => [
                'status' => 200,
                'body' => [
                    'verified' => 'boolean',
                    'email' => 'string',
                ],
            ],
            'v1.internal.sessions.create' => [
                'status' => 201,
                'body' => [
                    'session_id' => 'string',
                    'user_id' => 'integer',
                    'created_at' => 'string',
                ],
            ],
            'v1.internal.services.ping' => [
                'status' => 200,
                'body' => [
                    'service' => 'string',
                    'pong' => 'boolean',
                    'timestamp' => 'string',
                ],
            ],
        ];

        return $contracts[$endpoint] ?? null;
    }

    /**
     * Validate request against contract.
     *
     * @param string $endpoint
     * @param \Illuminate\Http\Request $request
     * @return array with 'valid' => bool and 'errors' => array
     */
    public function validateRequest(string $endpoint, \Illuminate\Http\Request $request): array
    {
        $contract = $this->getRequestContract($endpoint);

        if (!$contract) {
            return ['valid' => true, 'errors' => []];
        }

        $errors = [];

        // Validate HTTP method
        if ($request->method() !== $contract['method']) {
            $errors[] = "Expected {$contract['method']} request, got {$request->method()}";
        }

        // Validate headers (simplified)
        foreach ($contract['headers'] as $header => $rule) {
            if (str_contains($rule, 'required') && !$request->header($header)) {
                $errors[] = "Missing required header: {$header}";
            }
        }

        // Validate body fields (simplified)
        foreach ($contract['body'] as $field => $rule) {
            if (str_contains($rule, 'required') && !$request->input($field)) {
                $errors[] = "Missing required field: {$field}";
            }
        }

        return [
            'valid' => empty($errors),
            'errors' => $errors,
        ];
    }
}
