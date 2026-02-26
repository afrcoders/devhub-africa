<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

/**
 * API Rate Limiting Service
 * Tracks and enforces API rate limits by IP, service ID, or user.
 */
class RateLimitService
{
    /**
     * Check if a request exceeds rate limit.
     *
     * @param string $identifier IP, Service ID, or User ID
     * @param string $category 'public', 'internal', 'auth', etc.
     * @return bool
     */
    public function isAllowed(string $identifier, string $category = 'public'): bool
    {
        $limit = config("api.rate_limits.{$category}", 60);
        $cacheKey = "rate_limit:{$category}:{$identifier}";
        $attempts = Cache::get($cacheKey, 0);

        if ($attempts >= $limit) {
            return false;
        }

        // Increment attempts, expire after 1 minute
        Cache::put($cacheKey, $attempts + 1, now()->addMinute());

        return true;
    }

    /**
     * Get remaining requests for an identifier.
     *
     * @param string $identifier
     * @param string $category
     * @return int
     */
    public function getRemainingRequests(string $identifier, string $category = 'public'): int
    {
        $limit = config("api.rate_limits.{$category}", 60);
        $cacheKey = "rate_limit:{$category}:{$identifier}";
        $attempts = Cache::get($cacheKey, 0);

        return max(0, $limit - $attempts);
    }

    /**
     * Get reset time (when rate limit resets) in seconds.
     *
     * @param string $identifier
     * @param string $category
     * @return int
     */
    public function getResetTime(string $identifier, string $category = 'public'): int
    {
        $cacheKey = "rate_limit:{$category}:{$identifier}";
        $ttl = Cache::store('cache')->getStore()->connection()->ttl($cacheKey);

        return max(0, $ttl);
    }

    /**
     * Reset rate limit for an identifier (admin only).
     *
     * @param string $identifier
     * @param string $category
     * @return bool
     */
    public function reset(string $identifier, string $category = 'public'): bool
    {
        $cacheKey = "rate_limit:{$category}:{$identifier}";
        return Cache::forget($cacheKey);
    }
}
