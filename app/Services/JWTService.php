<?php

namespace App\Services;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class JWTService
{
    /**
     * Generate a JWT token for a user.
     */
    public static function generateToken($user, $expirationSeconds = 3600)
    {
        $now = time();
        $expire = $now + $expirationSeconds;

        $payload = [
            'iat' => $now,
            'exp' => $expire,
            'user_id' => $user->id,
            'email' => $user->email,
            'username' => $user->username,
        ];

        $secret = config('auth.jwt_secret', 'your-secret-key-change-in-production');
        $token = JWT::encode($payload, $secret, 'HS256');

        return $token;
    }

    /**
     * Verify and decode a JWT token.
     */
    public static function verifyToken($token)
    {
        try {
            $secret = config('auth.jwt_secret', 'your-secret-key-change-in-production');
            $decoded = JWT::decode($token, new Key($secret, 'HS256'));
            return $decoded;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Get user from token.
     */
    public static function getUserFromToken($token)
    {
        $decoded = self::verifyToken($token);

        if (!$decoded) {
            return null;
        }

        return \App\Models\User::find($decoded->user_id);
    }
}
