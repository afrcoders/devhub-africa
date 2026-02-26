<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Services\JWTService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JWTServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_generate_token_for_user(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'username' => 'testuser',
        ]);

        $token = JWTService::generateToken($user);

        $this->assertNotNull($token);
        $this->assertIsString($token);
    }

    public function test_can_verify_valid_token(): void
    {
        $user = User::factory()->create();
        $token = JWTService::generateToken($user);

        $decoded = JWTService::verifyToken($token);

        $this->assertNotNull($decoded);
        $this->assertEquals($user->id, $decoded->user_id);
        $this->assertEquals($user->email, $decoded->email);
    }

    public function test_returns_null_for_invalid_token(): void
    {
        $result = JWTService::verifyToken('invalid-token');

        $this->assertNull($result);
    }

    public function test_returns_null_for_tampered_token(): void
    {
        $user = User::factory()->create();
        $token = JWTService::generateToken($user);

        // Tamper with the token
        $tamperedToken = $token . 'tampered';

        $result = JWTService::verifyToken($tamperedToken);

        $this->assertNull($result);
    }

    public function test_can_get_user_from_token(): void
    {
        $user = User::factory()->create();
        $token = JWTService::generateToken($user);

        $retrievedUser = JWTService::getUserFromToken($token);

        $this->assertNotNull($retrievedUser);
        $this->assertEquals($user->id, $retrievedUser->id);
    }

    public function test_returns_null_user_for_invalid_token(): void
    {
        $result = JWTService::getUserFromToken('invalid-token');

        $this->assertNull($result);
    }

    public function test_token_contains_correct_claims(): void
    {
        $user = User::factory()->create([
            'email' => 'claims@example.com',
            'username' => 'claimsuser',
        ]);

        $token = JWTService::generateToken($user, 7200);
        $decoded = JWTService::verifyToken($token);

        $this->assertEquals($user->id, $decoded->user_id);
        $this->assertEquals('claims@example.com', $decoded->email);
        $this->assertEquals('claimsuser', $decoded->username);
        $this->assertObjectHasProperty('iat', $decoded);
        $this->assertObjectHasProperty('exp', $decoded);
    }
}
