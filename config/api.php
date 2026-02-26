<?php

return [
    /*
    |--------------------------------------------------------------------------
    | API Configuration
    |--------------------------------------------------------------------------
    | Configuration for the Shared Platform API Layer
    */

    'version' => env('API_VERSION', '1.0'),

    'default_version' => 'v1',

    /*
    |--------------------------------------------------------------------------
    | Service Tokens
    |--------------------------------------------------------------------------
    | Tokens for internal services (Noccea, Kortextools, etc.)
    */
    'tokens' => [
        'internal' => env('API_TOKEN_INTERNAL'),
        'noccea' => env('API_TOKEN_NOCCEA'),
        'kortex' => env('API_TOKEN_KORTEX'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Service Credentials
    |--------------------------------------------------------------------------
    | Configuration for service-to-service authentication
    */
    'services' => [
        'noccea' => [
            'secret' => env('SERVICE_SECRET_NOCCEA'),
        ],
        'kortex' => [
            'secret' => env('SERVICE_SECRET_KORTEX'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    | Rate limits per minute for different API endpoint categories
    */
    'rate_limits' => [
        'public' => (int) env('API_RATE_LIMIT_PUBLIC', 60),        // 60 requests/min per IP
        'internal' => (int) env('API_RATE_LIMIT_INTERNAL', 1000),  // 1000 requests/min per service
        'auth' => (int) env('API_RATE_LIMIT_AUTH', 10),            // 10 login attempts/min per IP
    ],

    /*
    |--------------------------------------------------------------------------
    | Response Settings
    |--------------------------------------------------------------------------
    */
    'response' => [
        'include_request_id' => true,
        'include_timestamp' => true,
        'pretty_print' => env('APP_DEBUG', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Logging
    |--------------------------------------------------------------------------
    | API-specific logging configuration
    */
    'logging' => [
        'channel' => 'api',
        'log_requests' => true,
        'log_responses' => true,
        'log_sensitive' => false,
    ],
];
