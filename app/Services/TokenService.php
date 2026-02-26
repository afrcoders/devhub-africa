<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

/**
 * API Token Service
 * Handles token generation, validation, and revocation.
 */
class TokenService
{
    /**
     * Generate a new API token for a service.
     *
     * @param string $serviceId
     * @param int $expiresInHours
     * @return array
     */
    public function generateToken(string $serviceId, int $expiresInHours = 24): array
    {
        $token = 'sk_' . bin2hex(random_bytes(32));
        $expiresAt = now()->addHours($expiresInHours);

        // Store token in cache with metadata
        Cache::put("api_token:{$token}", [
            'service_id' => $serviceId,
            'created_at' => now()->toIso8601String(),
            'expires_at' => $expiresAt->toIso8601String(),
        ], $expiresAt);

        return [
            'token' => $token,
            'expires_at' => $expiresAt->toIso8601String(),
            'type' => 'Bearer',
        ];
    }

    /**
     * Validate if a token is valid and not expired.
     *
     * @param string $token
     * @return bool
     */
    public function isValid(string $token): bool
    {
        $cached = Cache::get("api_token:{$token}");

        if (!$cached) {
            return false;
        }

        $expiresAt = \Carbon\Carbon::parse($cached['expires_at']);

        return $expiresAt->isFuture();
    }

    /**
     * Get token metadata (service_id, creation time, expiration).
     *
     * @param string $token
     * @return array|null
     */
    public function getTokenMetadata(string $token): ?array
    {
        return Cache::get("api_token:{$token}");
    }

    /**
     * Revoke (delete) a token.
     *
     * @param string $token
     * @return bool
     */
    public function revokeToken(string $token): bool
    {
        return Cache::forget("api_token:{$token}");
    }

    /**
     * Refresh a token, extending its expiration.
     *
     * @param string $token
     * @param int $expiresInHours
     * @return string|null
     */
    public function refreshToken(string $token, int $expiresInHours = 24): ?string
    {
        $metadata = $this->getTokenMetadata($token);

        if (!$metadata) {
            return null;
        }

        // Revoke old token
        $this->revokeToken($token);

        // Generate new token for same service
        $newTokenData = $this->generateToken($metadata['service_id'], $expiresInHours);

        return $newTokenData['token'];
    }
}
