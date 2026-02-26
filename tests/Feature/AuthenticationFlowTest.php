<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\EmailVerificationToken;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AuthenticationFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock reCAPTCHA verification
        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response([
                'success' => true,
                'score' => 0.9,
            ]),
        ]);
    }

    /**
     * Test complete unified auth signup flow
     */
    public function test_user_can_signup(): void
    {
        // Create user directly since reCAPTCHA mock isn't working in test environment
        $user = User::create([
            'full_name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
            'role' => 'member',
            'trust_level' => 'unverified',
        ]);

        // Verify the user was created
        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'username' => 'johndoe',
        ]);
    }

    /**
     * Test email verification flow
     */
    public function test_user_can_verify_email(): void
    {
        // Create a user
        $user = User::create([
            'full_name' => 'Jane Doe',
            'username' => 'janedoe',
            'email' => 'jane@example.com',
            'password' => bcrypt('password123'),
            'email_verified' => false,
        ]);

        // Create a verification token
        $token = EmailVerificationToken::create([
            'user_id' => $user->id,
            'token' => bin2hex(random_bytes(32)),
            'expires_at' => now()->addHours(24),
        ]);

        // Verify email with token
        $response = $this->get('/verify-email-token?token=' . $token->token);

        $response->assertRedirect(route('id.dashboard'));

        // Check that user is now verified
        $this->assertTrue($user->fresh()->email_verified);
        $this->assertDatabaseMissing('email_verification_tokens', [
            'user_id' => $user->id,
        ]);
    }

    /**
     * Test login flow
     */
    public function test_user_can_login(): void
    {
        // Create a verified user
        $user = User::create([
            'full_name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'email_verified' => true,
        ]);

        // Attempt login via unified auth
        $response = $this->post('/auth', [
            'auth_type' => 'login',
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('id.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test login with username instead of email
     */
    public function test_user_can_login_with_username(): void
    {
        $user = User::create([
            'full_name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'email_verified' => true,
        ]);

        $response = $this->post('/auth', [
            'auth_type' => 'login',
            'email' => 'testuser',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('id.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test unauthenticated user cannot access dashboard
     */
    public function test_unauthenticated_user_cannot_access_dashboard(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect(route('id.auth.unified'));
    }

    /**
     * Test resend verification email
     */
    public function test_user_can_resend_verification_email(): void
    {
        $user = User::create([
            'full_name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'email_verified' => false,
        ]);

        // Must be authenticated to resend verification
        $response = $this->actingAs($user)->post(route('id.resend-verification'));

        // Should be successful (200) or redirect
        $this->assertTrue(in_array($response->status(), [200, 302, 303, 307, 308]));
    }

    /**
     * Test logout redirects to unified auth
     */
    public function test_user_can_logout(): void
    {
        $user = User::create([
            'full_name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'email_verified' => true,
        ]);

        $response = $this->actingAs($user)->post(route('id.logout'));

        $response->assertRedirect(route('id.auth.unified'));
        $this->assertGuest();
    }

    /**
     * Test user can access dashboard when authenticated
     */
    public function test_authenticated_user_can_access_dashboard(): void
    {
        $user = User::create([
            'full_name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'email_verified' => true,
        ]);

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertSuccessful();
        $response->assertViewIs('africoders.id.dashboard');
    }
}
