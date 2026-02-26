<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

/**
 * Example API Tests
 * Copy methods to your test suite to validate API endpoints
 */
class ApiTestExamples extends TestCase
{
    protected string $baseUrl = 'http://api.africoders.test/api/v1';
    protected string $token = 'token_internal_secret_key_12345';

    /**
     * Test health endpoint (public, no auth).
     */
    public function test_health_endpoint()
    {
        $response = $this->get($this->baseUrl . '/health');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'timestamp',
                'version',
            ]);
    }

    /**
     * Test status endpoint (public, no auth).
     */
    public function test_status_endpoint()
    {
        $response = $this->get($this->baseUrl . '/status');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'services',
                'timestamp',
            ]);
    }

    /**
     * Test token validation with valid token.
     */
    public function test_validate_token_success()
    {
        $response = $this->post(
            $this->baseUrl . '/internal/auth/validate-token',
            [],
            [
                'Authorization' => 'Bearer ' . $this->token,
            ]
        );

        $response->assertStatus(200)
            ->assertJsonStructure([
                'valid',
                'user_id',
                'scopes',
            ])
            ->assertJson(['valid' => true]);
    }

    /**
     * Test token validation without authorization header.
     */
    public function test_validate_token_missing_auth()
    {
        $response = $this->post(
            $this->baseUrl . '/internal/auth/validate-token'
        );

        $response->assertStatus(401)
            ->assertJsonStructure([
                'error',
                'message',
                'code',
            ])
            ->assertJson(['code' => 401]);
    }

    /**
     * Test token validation with invalid token.
     */
    public function test_validate_token_invalid()
    {
        $response = $this->post(
            $this->baseUrl . '/internal/auth/validate-token',
            [],
            [
                'Authorization' => 'Bearer invalid_token_xyz',
            ]
        );

        $response->assertStatus(401);
    }

    /**
     * Test service ping endpoint.
     */
    public function test_service_ping()
    {
        $response = $this->post(
            $this->baseUrl . '/internal/services/ping',
            ['service' => 'noccea'],
            [
                'Authorization' => 'Bearer ' . $this->token,
            ]
        );

        $response->assertStatus(200)
            ->assertJsonStructure([
                'service',
                'pong',
                'timestamp',
            ])
            ->assertJson([
                'service' => 'noccea',
                'pong' => true,
            ]);
    }

    /**
     * Test session creation.
     */
    public function test_create_session()
    {
        $response = $this->post(
            $this->baseUrl . '/internal/sessions/create',
            [
                'user_id' => 123,
                'ip_address' => '192.168.1.1',
                'user_agent' => 'Mozilla/5.0...',
            ],
            [
                'Authorization' => 'Bearer ' . $this->token,
            ]
        );

        $response->assertStatus(201)
            ->assertJsonStructure([
                'session_id',
                'user_id',
                'created_at',
            ])
            ->assertJson(['user_id' => 123]);
    }

    /**
     * Test email verification.
     */
    public function test_verify_email()
    {
        $response = $this->post(
            $this->baseUrl . '/internal/users/verify-email',
            ['email' => 'user@example.com'],
            [
                'Authorization' => 'Bearer ' . $this->token,
            ]
        );

        $response->assertStatus(200)
            ->assertJsonStructure([
                'verified',
                'email',
            ])
            ->assertJson([
                'verified' => true,
                'email' => 'user@example.com',
            ]);
    }

    /**
     * Test user retrieval.
     */
    public function test_get_user()
    {
        $response = $this->get(
            $this->baseUrl . '/internal/users/123',
            [
                'Authorization' => 'Bearer ' . $this->token,
            ]
        );

        $response->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'email',
                'verified',
            ])
            ->assertJson(['id' => 123]);
    }

    /**
     * Test WhatsApp webhook (with signature validation).
     */
    public function test_whatsapp_webhook()
    {
        $payload = json_encode([
            'from' => '1234567890',
            'message' => 'Hello bot!',
            'timestamp' => time(),
        ]);

        $signature = hash_hmac(
            'sha256',
            'POST|/api/v1/internal/bots/whatsapp/webhook|' . $payload,
            'secret_noccea_hmac_key_xyz123',
            true
        );
        $signature = base64_encode($signature);

        $response = $this->post(
            $this->baseUrl . '/internal/bots/whatsapp/webhook',
            json_decode($payload, true),
            [
                'X-Service-Id' => 'whatsapp',
                'X-Service-Signature' => $signature,
            ]
        );

        $response->assertStatus(202)
            ->assertJsonStructure([
                'received',
                'message_id',
            ])
            ->assertJson(['received' => true]);
    }

    /**
     * Test rate limiting.
     */
    public function test_rate_limiting()
    {
        // Make requests up to limit
        for ($i = 0; $i < 60; $i++) {
            $response = $this->get($this->baseUrl . '/health');
            $response->assertStatus(200);
        }

        // Next request should be rate limited
        $response = $this->get($this->baseUrl . '/health');
        $response->assertStatus(429)
            ->assertJsonStructure([
                'error',
                'message',
                'code',
                'retry_after',
            ])
            ->assertJson(['code' => 429]);
    }

    /**
     * Test request ID in response.
     */
    public function test_request_id_in_response()
    {
        $response = $this->get(
            $this->baseUrl . '/health',
            [
                'X-Request-Id' => 'test_request_123',
            ]
        );

        // Request ID should be echoed back (if using ApiResponse trait)
        $response->assertStatus(200);
        $this->assertNotNull($response->json('request_id'));
    }

    /**
     * Test API version header.
     */
    public function test_api_version_header()
    {
        $response = $this->get($this->baseUrl . '/health');

        $this->assertEquals('1.0', $response->header('X-API-Version'));
    }

    /**
     * Test 404 on undefined endpoint.
     */
    public function test_undefined_endpoint()
    {
        $response = $this->get($this->baseUrl . '/undefined/endpoint');

        $response->assertStatus(404)
            ->assertJsonStructure([
                'error',
                'message',
                'code',
            ]);
    }

    /**
     * Test response time header.
     */
    public function test_response_time_header()
    {
        $response = $this->get($this->baseUrl . '/health');

        $this->assertNotNull($response->header('X-Response-Time'));
        $this->assertStringContainsString('ms', $response->header('X-Response-Time'));
    }
}
