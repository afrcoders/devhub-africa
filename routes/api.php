<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - Shared Platform API Layer
|--------------------------------------------------------------------------
| Stateless, versioned, internal-first API for:
| - Internal products (Noccea, Kortextools)
| - Service-to-service authentication
| - Future third-party integrations (with explicit tokens)
|
| Non-Goals: UI, data ownership, business logic
*/

/*
|--------------------------------------------------------------------------
| V1 API Routes
|--------------------------------------------------------------------------
*/
Route::prefix('v1')->group(function () {

    /*
    | Health & Status Endpoints (Public)
    */
    Route::get('/health', function () {
        return response()->json([
            'status' => 'healthy',
            'timestamp' => now()->toIso8601String(),
            'version' => 'v1',
        ]);
    })->name('api.v1.health');

    Route::get('/status', function () {
        return response()->json([
            'status' => 'operational',
            'services' => [
                'africoders' => 'operational',
                'noccea' => 'operational',
                'id' => 'operational',
            ],
            'timestamp' => now()->toIso8601String(),
        ]);
    })->name('api.v1.status');

    /*
    | Internal Routes (Service-to-Service Auth Required)
    */
    Route::middleware(['api.token', 'throttle:api.internal'])
        ->prefix('/internal')
        ->group(function () {

            /*
            | User Authentication & Tokens
            */
            Route::post('/auth/validate-token', function (Request $request) {
                return response()->json([
                    'valid' => true,
                    'user_id' => auth()->id(),
                    'scopes' => [],
                ]);
            })->name('api.v1.internal.auth.validate-token');

            Route::post('/auth/refresh-token', function (Request $request) {
                $token = $request->bearerToken();
                return response()->json([
                    'token' => $token,
                    'expires_in' => 3600,
                    'token_type' => 'Bearer',
                ])->setStatusCode(201);
            })->name('api.v1.internal.auth.refresh-token');

            /*
            | User Data & Verification
            */
            Route::get('/users/{id}', function ($id) {
                return response()->json([
                    'id' => $id,
                    'email' => 'user@example.com',
                    'verified' => true,
                ])->setStatusCode(200);
            })->name('api.v1.internal.users.show');

            Route::post('/users/verify-email', function (Request $request) {
                return response()->json([
                    'verified' => true,
                    'email' => $request->input('email'),
                ])->setStatusCode(200);
            })->name('api.v1.internal.users.verify-email');

            /*
            | Session Management
            */
            Route::post('/sessions/create', function (Request $request) {
                return response()->json([
                    'session_id' => uniqid('sess_'),
                    'user_id' => $request->input('user_id'),
                    'created_at' => now()->toIso8601String(),
                ])->setStatusCode(201);
            })->name('api.v1.internal.sessions.create');

            Route::post('/sessions/{sessionId}/invalidate', function ($sessionId) {
                return response()->json([
                    'session_id' => $sessionId,
                    'invalidated' => true,
                    'invalidated_at' => now()->toIso8601String(),
                ])->setStatusCode(200);
            })->name('api.v1.internal.sessions.invalidate');

            /*
            | Bot Integration Endpoints
            */
            Route::prefix('/bots')->group(function () {
                Route::post('/whatsapp/webhook', function (Request $request) {
                    return response()->json([
                        'received' => true,
                        'message_id' => uniqid('msg_'),
                    ])->setStatusCode(202);
                })->name('api.v1.internal.bots.whatsapp.webhook');

                Route::post('/telegram/webhook', function (Request $request) {
                    return response()->json([
                        'ok' => true,
                        'message_id' => uniqid('msg_'),
                    ])->setStatusCode(202);
                })->name('api.v1.internal.bots.telegram.webhook');
            });

            /*
            | Service Status & Ping
            */
            Route::post('/services/ping', function (Request $request) {
                return response()->json([
                    'service' => $request->input('service', 'unknown'),
                    'pong' => true,
                    'timestamp' => now()->toIso8601String(),
                ])->setStatusCode(200);
            })->name('api.v1.internal.services.ping');
        });

    /*
    | Public Routes (Rate Limited)
    */
    Route::middleware(['throttle:api.public'])
        ->group(function () {

        Route::post('/auth/login', function (Request $request) {
            return response()->json([
                'token' => uniqid('token_'),
                'expires_in' => 3600,
                'token_type' => 'Bearer',
            ])->setStatusCode(200);
        })->name('api.v1.auth.login');
    });
});

/*
|--------------------------------------------------------------------------
| V2 API Routes (Future)
|--------------------------------------------------------------------------
*/
Route::prefix('v2')->group(function () {
    Route::get('/health', function () {
        return response()->json([
            'status' => 'healthy',
            'version' => 'v2',
            'timestamp' => now()->toIso8601String(),
        ]);
    })->name('api.v2.health');
});

/*
|--------------------------------------------------------------------------
| Catch-All for Undefined API Routes
|--------------------------------------------------------------------------
*/
Route::fallback(function () {
    return response()->json([
        'error' => 'Not Found',
        'message' => 'The requested API endpoint does not exist.',
        'code' => 404,
    ], 404);
});
