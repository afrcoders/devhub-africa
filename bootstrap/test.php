<?php

/*
|--------------------------------------------------------------------------
| Test Bootstrap
|--------------------------------------------------------------------------
|
| This file is executed before running the test suite to ensure
| proper environment configuration for testing.
|
*/

// Set APP_ENV to testing BEFORE anything loads .env
putenv('APP_ENV=testing');
$_ENV['APP_ENV'] = 'testing';
$_SERVER['APP_ENV'] = 'testing';

// Load vendor autoload
require __DIR__ . '/../vendor/autoload.php';

// Now explicitly load .env.testing after dotenv is available
$envFile = __DIR__ . '/../.env.testing';
if (file_exists($envFile)) {
    // Remove any existing env variables that might have been loaded
    foreach ($_ENV as $key => $value) {
        if (in_array($key, ['DB_CONNECTION', 'DB_HOST', 'DB_PORT', 'DB_DATABASE', 'DB_USERNAME', 'DB_PASSWORD', 'CACHE_DRIVER', 'SESSION_DRIVER'])) {
            unset($_ENV[$key]);
            unset($_SERVER[$key]);
        }
    }

    // Load .env.testing specifically
    $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/..', '.env.testing');
    $dotenv->load();
}

// Ensure APP_ENV remains testing
$_ENV['APP_ENV'] = $_SERVER['APP_ENV'] = 'testing';
