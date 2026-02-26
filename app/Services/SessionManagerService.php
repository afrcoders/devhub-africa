<?php

namespace App\Services;

use App\Models\User;
use App\Models\Session;
use Illuminate\Support\Str;

class SessionManagerService
{
    /**
     * Create a new session for a user.
     */
    public function createSession(User $user): string
    {
        $sessionToken = bin2hex(random_bytes(32));
        $sessionId = Str::random(40); // Generate a unique ID

        Session::create([
            'id' => $sessionId,
            'user_id' => $user->id,
            'session_token' => $sessionToken,
            'password_changed_at' => $user->password_changed_at,
            'browser_info' => $this->parseBrowserInfo(),
            'ip_address' => request()->ip(),
            'expires_at' => now()->addDays(30),
        ]);

        session(['session_token' => $sessionToken]);

        return $sessionToken;
    }

    /**
     * Validate a session.
     */
    public function validateSession(User $user, string $sessionToken): bool
    {
        if (empty($sessionToken)) {
            return true;
        }

        $session = Session::where('user_id', $user->id)
            ->where('session_token', $sessionToken)
            ->first();

        if (!$session) {
            \Log::warning("Session not found for user {$user->id} with token " . substr($sessionToken, 0, 20) . "...");
            return false;
        }

        if ($session->isExpired()) {
            \Log::warning("Session expired for user {$user->id}");
            return false;
        }

        // If either timestamp is empty, allow it (new user or migration case)
        if (empty($session->password_changed_at) || empty($user->password_changed_at)) {
            return true;
        }

        // Check if password was changed elsewhere
        if ($user->password_changed_at->greaterThan($session->password_changed_at)) {
            \Log::warning("Session invalidated: Password changed elsewhere for user {$user->id}");
            return false;
        }

        return true;
    }

    /**
     * Invalidate all other sessions for a user except the current one.
     */
    public function invalidateOtherSessions(User $user, string $currentSessionToken): void
    {
        Session::where('user_id', $user->id)
            ->where('session_token', '!=', $currentSessionToken)
            ->delete();
    }

    /**
     * Update session password timestamp.
     */
    public function updateSessionPasswordTimestamp(User $user, string $sessionToken): void
    {
        Session::where('user_id', $user->id)
            ->where('session_token', $sessionToken)
            ->update([
                'password_changed_at' => now(),
            ]);
    }

    /**
     * Delete expired sessions.
     */
    public function deleteExpiredSessions(): int
    {
        return Session::where('expires_at', '<', now())->delete();
    }

    /**
     * Parse browser information from user agent.
     */
    protected function parseBrowserInfo(): string
    {
        $userAgent = request()->userAgent() ?? 'Unknown';

        // Simple parsing - in production, use a library like Mobile_Detect
        if (strpos($userAgent, 'Chrome') !== false) {
            $browser = 'Chrome';
        } elseif (strpos($userAgent, 'Firefox') !== false) {
            $browser = 'Firefox';
        } elseif (strpos($userAgent, 'Safari') !== false) {
            $browser = 'Safari';
        } elseif (strpos($userAgent, 'Edge') !== false) {
            $browser = 'Edge';
        } else {
            $browser = 'Unknown';
        }

        if (strpos($userAgent, 'Windows') !== false) {
            $os = 'Windows';
        } elseif (strpos($userAgent, 'Mac') !== false) {
            $os = 'macOS';
        } elseif (strpos($userAgent, 'Linux') !== false) {
            $os = 'Linux';
        } elseif (strpos($userAgent, 'iPhone') !== false || strpos($userAgent, 'iPad') !== false) {
            $os = 'iOS';
        } elseif (strpos($userAgent, 'Android') !== false) {
            $os = 'Android';
        } else {
            $os = 'Unknown';
        }

        return "$browser on $os";
    }
}
