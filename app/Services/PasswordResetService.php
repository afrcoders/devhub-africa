<?php

namespace App\Services;

use App\Events\PasswordResetTokenCreated;
use App\Models\PasswordResetToken;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PasswordResetService
{
    /**
     * Generate a password reset token for a user.
     */
    public function generateToken(User $user): string
    {
        // Delete any existing tokens for this user
        $user->passwordResetTokens()->delete();

        // Generate a new token (256-bit)
        $token = bin2hex(random_bytes(32));

        // Create and store the token
        PasswordResetToken::create([
            'user_id' => $user->id,
            'token' => $token,
            'expires_at' => now()->addHours(
                config('africoders.password_reset.token_expiry_hours', 1)
            ),
        ]);

        return $token;
    }

    /**
     * Verify a password reset token.
     */
    public function verifyToken(string $token): ?User
    {
        $resetToken = PasswordResetToken::where('token', $token)->first();

        if (!$resetToken || $resetToken->isExpired()) {
            return null;
        }

        $user = $resetToken->user;
        $resetToken->delete();

        return $user;
    }

    /**
     * Reset password for a user.
     */
    public function resetPassword(User $user, string $newPassword): bool
    {
        try {
            $user->update([
                'password' => Hash::make($newPassword),
                'password_changed_at' => now(),
            ]);

            // Invalidate all sessions
            $user->sessions()->delete();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Send password reset email.
     */
    public function sendResetEmail(User $user): void
    {
        $token = $this->generateToken($user);

        $resetUrl = route('password.reset', ['token' => $token]);

        $user->notify(new \App\Notifications\PasswordResetNotification($resetUrl, $user));

        event(new PasswordResetTokenCreated($user, $token));
    }
}
