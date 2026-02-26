<?php

namespace App\Services;

use App\Models\User;
use App\Models\EmailVerificationToken;
use Illuminate\Support\Str;

class EmailVerificationService
{
    /**
     * Generate a new email verification token.
     */
    public function generateToken(User $user): EmailVerificationToken
    {
        // Delete existing tokens for this user
        $user->emailVerificationTokens()->delete();

        // Create new token (256-bit, hex encoded = 64 characters)
        $token = bin2hex(random_bytes(32));

        $verificationToken = EmailVerificationToken::create([
            'user_id' => $user->id,
            'token' => $token,
            'expires_at' => now()->addHours(24),
        ]);

        return $verificationToken;
    }

    /**
     * Verify email token.
     */
    public function verifyToken(string $token): ?User
    {
        $verificationToken = EmailVerificationToken::where('token', $token)
            ->where('expires_at', '>', now())
            ->first();

        if (!$verificationToken) {
            return null;
        }

        $user = $verificationToken->user;

        // Mark email as verified
        $user->markEmailAsVerified();

        // Delete the token
        $verificationToken->delete();

        // Log action
        $this->logAction($user, 'email_verified', 'User verified their email address');

        // Reload user from database to ensure email_verified attribute is updated in memory
        return $user->fresh();
    }

    /**
     * Check if user's email is verified.
     */
    public function isEmailVerified(User $user): bool
    {
        return (bool) $user->email_verified;
    }

    /**
     * Resend verification email.
     */
    public function resendVerificationEmail(User $user): EmailVerificationToken
    {
        $token = $this->generateToken($user);

        // Send email (will be handled by notification)
        event(new \App\Events\EmailVerificationTokenCreated($token));

        return $token;
    }

    /**
     * Log an action in audit logs.
     */
    protected function logAction(User $user, string $action, string $details): void
    {
        \App\Models\AuditLog::create([
            'user_id' => $user->id,
            'action' => $action,
            'details' => $details,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
