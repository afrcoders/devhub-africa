<?php

namespace Tests\Unit\Services;

use App\Models\EmailVerificationToken;
use App\Models\User;
use App\Services\EmailVerificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmailVerificationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected EmailVerificationService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new EmailVerificationService();
    }

    public function test_can_generate_verification_token(): void
    {
        $user = User::factory()->create();

        $token = $this->service->generateToken($user);

        $this->assertInstanceOf(EmailVerificationToken::class, $token);
        $this->assertEquals($user->id, $token->user_id);
        $this->assertNotNull($token->token);
        $this->assertEquals(64, strlen($token->token)); // 32 bytes hex encoded
    }

    public function test_generating_new_token_deletes_old_tokens(): void
    {
        $user = User::factory()->create();

        // Generate first token
        $firstToken = $this->service->generateToken($user);
        $firstTokenId = $firstToken->id;

        // Generate second token
        $secondToken = $this->service->generateToken($user);

        // First token should be deleted
        $this->assertDatabaseMissing('email_verification_tokens', ['id' => $firstTokenId]);
        $this->assertDatabaseHas('email_verification_tokens', ['id' => $secondToken->id]);
    }

    public function test_can_verify_valid_token(): void
    {
        $user = User::factory()->create(['email_verified_at' => null]);
        $verificationToken = $this->service->generateToken($user);

        $verifiedUser = $this->service->verifyToken($verificationToken->token);

        $this->assertNotNull($verifiedUser);
        $this->assertEquals($user->id, $verifiedUser->id);
        $this->assertNotNull($verifiedUser->email_verified_at);
    }

    public function test_returns_null_for_invalid_token(): void
    {
        $result = $this->service->verifyToken('nonexistent-token');

        $this->assertNull($result);
    }

    public function test_returns_null_for_expired_token(): void
    {
        $user = User::factory()->create();
        $token = $this->service->generateToken($user);

        // Manually expire the token
        $token->update(['expires_at' => now()->subHour()]);

        $result = $this->service->verifyToken($token->token);

        $this->assertNull($result);
    }

    public function test_token_is_deleted_after_verification(): void
    {
        $user = User::factory()->create(['email_verified_at' => null]);
        $verificationToken = $this->service->generateToken($user);
        $tokenValue = $verificationToken->token;

        $this->service->verifyToken($tokenValue);

        $this->assertDatabaseMissing('email_verification_tokens', ['token' => $tokenValue]);
    }

    public function test_token_expires_in_24_hours(): void
    {
        $user = User::factory()->create();
        $token = $this->service->generateToken($user);

        // Token should expire approximately 24 hours from now
        $this->assertTrue($token->expires_at->isAfter(now()->addHours(23)));
        $this->assertTrue($token->expires_at->isBefore(now()->addHours(25)));
    }
}
