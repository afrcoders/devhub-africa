<?php

return [
    // Application
    'app_name' => 'Africoders ID',
    'app_url' => env('APP_URL', 'https://me.africoders.test'),

    // Email
    'email' => [
        'from' => env('MAIL_FROM_ADDRESS', 'studio@africoders.com'),
        'from_name' => env('MAIL_FROM_NAME', 'Africoders Studio'),
        'recipient' => env('MAIL_FROM_ADDRESS', 'studio@africoders.com'),
    ],

    // reCAPTCHA
    'recaptcha' => [
        'site_key' => env('RECAPTCHA_SITE_KEY'),
        'secret_key' => env('RECAPTCHA_SECRET_KEY'),
        'enabled' => true,
    ],

    // Session
    'session' => [
        'timeout' => env('SESSION_TIMEOUT', 3600),
        'remember_me_timeout' => env('REMEMBER_ME_TIMEOUT', 2592000),
    ],

    // Color Palette
    'colors' => [
        'primary' => '#1E3A8A',
        'secondary' => '#0F172A',
        'success' => '#22C55E',
        'warning' => '#F59E0B',
        'danger' => '#EF4444',
        'bg' => '#F8FAFC',
    ],

    // Verification Statuses
    'verification' => [
        'statuses' => [
            'not_submitted' => 'not_submitted',
            'pending' => 'pending',
            'approved' => 'approved',
            'rejected' => 'rejected',
        ],
        'types' => [
            'identity' => 'identity',
            'business' => 'business',
            'instructor' => 'instructor',
        ],
    ],

    // User Roles
    'roles' => [
        'member' => 'member',
        'business_owner' => 'business_owner',
        'instructor' => 'instructor',
        'admin' => 'admin',
    ],

    // Trust Levels
    'trust_levels' => [
        'unverified' => 'unverified',
        'verified' => 'verified',
        'trusted' => 'trusted',
    ],

    // Email Verification
    'email_verification' => [
        'token_expiry_hours' => 24,
        'resend_cooldown_seconds' => 60,
    ],

    // Password Reset
    'password_reset' => [
        'token_expiry_hours' => 1,
    ],

    // Help Center
    'help_center_url' => 'https://' . config('domains.africoders.help'),
];
