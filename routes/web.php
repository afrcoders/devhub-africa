<?php

use App\Http\Controllers\Africoders\Main\HomeController as PortalHomeController;
use App\Http\Controllers\Africoders\Id\Auth\LoginController;
use App\Http\Controllers\Africoders\Id\Auth\LogoutController;
use App\Http\Controllers\Africoders\Id\Auth\RegisterController;
use App\Http\Controllers\Africoders\Id\Auth\OAuthController;
use App\Http\Controllers\Africoders\Id\Auth\PasswordResetController;
use App\Http\Controllers\Africoders\Id\DashboardController;
use App\Http\Controllers\Africoders\Id\ProfileController;
use App\Http\Controllers\Africoders\Id\VerificationController;
use App\Http\Controllers\Africoders\Id\SessionController;
use App\Http\Controllers\Africoders\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Africoders\Admin\UserManagementController;
use App\Http\Controllers\Africoders\Admin\HelpManagementController;
use App\Http\Controllers\Africoders\Help\HomeController as HelpHomeController;
use App\Http\Controllers\Africoders\Help\SupportController;
use App\Http\Controllers\Africoders\Help\ContactController;
use App\Http\Controllers\Africoders\Help\LegalController;
use App\Http\Controllers\Africoders\Public\HomeController as AfriccodersPublicController;
use App\Http\Controllers\Africoders\Admin\AfriccodersAdminController;
use App\Http\Controllers\Africoders\Main\AuthController as AfriccodersAuthController;
use App\Http\Controllers\Africoders\Main\DashboardController as AfricodersDashboardController;
use App\Http\Controllers\Africoders\Kortextools\ToolsController;
use App\Http\Controllers\Africoders\Kortextools\CategoryController;
use App\Http\Controllers\Africoders\Kortextools\SearchController;
use App\Http\Controllers\Africoders\Kortextools\ToolRatingController;
use App\Http\Controllers\Noccea\Main\HomeController as NocceaMainHomeController;
use App\Http\Controllers\Noccea\Community\HomeController as NocceaCommunityHomeController;
use App\Http\Controllers\Noccea\Business\HomeController as NocceaBusinessHomeController;
use App\Http\Controllers\Noccea\Business\BusinessController;
use App\Http\Controllers\Noccea\Business\CategoryController as BusinessCategoryController;
use App\Http\Controllers\Noccea\Learn\HomeController as NocceaLearnHomeController;
use App\Http\Controllers\Noccea\Learn\LessonController;
use App\Http\Controllers\Noccea\Learn\ReviewController;
use App\Http\Controllers\Noccea\Learn\ForumController;
use App\Http\Controllers\Noccea\Learn\StudyGroupController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes - Domain-Based Routing
|--------------------------------------------------------------------------
*/

// ==========================================
// PORTAL HOME (portal.africoders)
// ==========================================
Route::domain(config('domains.portal'))
    ->middleware(['web'])
    ->group(function () {
        Route::get('/', [PortalHomeController::class, 'home'])->name('portal.home');
    });

// ==========================================
// ID SERVICE (id.africoders)
// ==========================================
Route::domain(config('domains.africoders.id'))
    ->middleware(['web'])
    ->group(function () {

        // Redirect home to login or dashboard
        Route::get('/', function () {
            if (auth()->check()) {
                return redirect()->route('id.dashboard');
            }
            return redirect()->route('id.auth.unified');
        })->name('id.home');

        Route::get('/home', function () {
            if (auth()->check()) {
                return redirect()->route('id.dashboard');
            }
            return redirect()->route('id.auth.unified');
        });

        // Authentication routes
        Route::get('/auth', [LoginController::class, 'showUnifiedAuth'])->name('id.auth.unified');

        Route::middleware('guest')->group(function () {
            Route::post('/auth', [LoginController::class, 'unifiedAuth']);
            Route::post('/auth/check-user', [LoginController::class, 'checkUser'])->name('id.auth.check-user');

            Route::get('/sign-up', fn() => redirect('/auth'))->name('id.signup');
            Route::get('/sign-in', fn() => redirect('/auth'))->name('id.login');

            Route::get('/forgot-password', [PasswordResetController::class, 'showForgotPassword'])->name('id.password.forgot');
            Route::post('/forgot-password', [PasswordResetController::class, 'forgotPassword'])->name('id.password.forgot.submit');
            Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetPassword'])->name('id.password.reset');
            Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('id.password.reset.submit');
        });

        // Socialite routes
        Route::get('/auth/{provider}/redirect', [OAuthController::class, 'redirect'])->name('id.socialite.redirect');
        Route::get('/auth/{provider}/callback', [OAuthController::class, 'callback'])->name('id.socialite.callback');

        // Public email verification route
        Route::get('/verify-email-token', [LoginController::class, 'verifyEmail'])->name('id.verify-email-token');

        // Nonce exchange endpoint (for cross-domain auth) - No CSRF needed
        Route::post('/auth/exchange-nonce', [LoginController::class, 'exchangeNonce'])
            ->name('id.auth.exchange-nonce')
            ->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);

        // Logout routes - support both GET and POST (public, no auth required)
        Route::get('/logout', [LogoutController::class, 'logout'])->name('id.logout.get');
        Route::post('/logout', [LogoutController::class, 'logout'])->name('id.logout');

        // Protected routes
        Route::middleware('auth')->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('id.dashboard');

            Route::prefix('/profile')->name('id.profile.')->group(function () {
                Route::get('/', [ProfileController::class, 'show'])->name('show');
                Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
                Route::put('/', [ProfileController::class, 'update'])->name('update');
            });

            Route::get('/verify-email', [LoginController::class, 'showEmailVerification'])->name('id.verify-email');
            Route::post('/resend-verification', [LoginController::class, 'resendVerification'])->name('id.resend-verification');

            Route::get('/change-password', [LoginController::class, 'showChangePassword'])->name('id.change-password');
            Route::post('/change-password', [LoginController::class, 'changePassword'])->name('id.change-password.submit');

            Route::prefix('/verification')->name('id.verification.')->group(function () {
                Route::get('/{type}', [VerificationController::class, 'show'])->name('show');
                Route::post('/{type}', [VerificationController::class, 'submit'])->name('submit');
            });

            Route::prefix('/sessions')->name('id.sessions.')->group(function () {
                Route::get('/', [SessionController::class, 'index'])->name('index');
                Route::post('/logout-all', [SessionController::class, 'logoutAll'])->name('logout-all');
                Route::post('/{sessionToken}/logout', [SessionController::class, 'logoutSession'])->name('logout-session');
            });
        });
    });

// ==========================================
// API SERVICE (api.africoders)
// ==========================================
Route::domain(config('domains.africoders.api'))
    ->middleware(['api'])
    ->prefix('/api')
    ->name('api.')
    ->group(function () {
        Route::get('/health', fn() => response()->json(['status' => 'ok', 'timestamp' => now()]))->name('health');
    });

// ==========================================
// ADMIN SERVICE (admin.africoders)
// ==========================================
Route::domain(config('domains.africoders.admin'))
    ->middleware(['web'])
    ->name('admin.')
    ->group(function () {
        // Specific admin routes - with inline authentication checks
        Route::get('/', function (Request $request) {
            if (!auth()->check()) {
                // Show welcome page with login button instead of auto-redirect
                $returnUrl = $request->fullUrl();
                $loginUrl = 'https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl);

                return view('admin.welcome', [
                    'loginUrl' => $loginUrl
                ]);
            }

            // Check admin status
            $user = auth()->user();
            if (!$user || !method_exists($user, 'isAdmin') || !$user->isAdmin()) {
                return view('admin.under-construction', [
                    'user' => $user,
                    'debug' => [
                        'authenticated' => auth()->check(),
                        'user_exists' => !!$user,
                        'has_isAdmin_method' => $user && method_exists($user, 'isAdmin'),
                        'isAdmin' => $user && method_exists($user, 'isAdmin') ? $user->isAdmin() : 'method not found'
                    ]
                ]);
            }

            return redirect()->route('admin.dashboard.explicit');
        })->name('dashboard');

        Route::get('/dashboard', function (Request $request) {
            if (!auth()->check()) {
                $returnUrl = $request->fullUrl();
                return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
            }
            if (!auth()->user()->isAdmin()) {
                return view('admin.under-construction');
            }
            return app(AdminDashboardController::class)->dashboard($request);
        })->name('dashboard.explicit');

        // Test route to verify admin access
        Route::get('/test', function (Request $request) {
            if (!auth()->check()) {
                $returnUrl = $request->fullUrl();
                return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
            }
            if (!auth()->user()->isAdmin()) {
                return response()->json(['error' => 'Access denied'], 403);
            }
            return response()->json([
                'message' => 'Admin access confirmed!',
                'user' => auth()->user()->only(['id', 'username', 'email']),
                'is_admin' => auth()->user()->isAdmin()
            ]);
        })->name('test');

        // User management routes with authentication
        Route::prefix('/users')->name('users.')->group(function () {
            Route::get('/', function (Request $request) {
                if (!auth()->check()) {
                    $returnUrl = $request->fullUrl();
                    return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
                }
                if (!auth()->user()->isAdmin()) {
                    return view('admin.under-construction');
                }
                return app(UserManagementController::class)->users($request);
            })->name('index');

            Route::get('/{user}', function (Request $request, $user) {
                if (!auth()->check()) {
                    $returnUrl = $request->fullUrl();
                    return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
                }
                if (!auth()->user()->isAdmin()) {
                    return view('admin.under-construction');
                }
                return app(UserManagementController::class)->showUser($request, $user);
            })->name('show');

            Route::post('/{user}/role', [UserManagementController::class, 'updateRole'])->name('update-role');
            Route::put('/{user}', [UserManagementController::class, 'updateUser'])->name('update');
            Route::post('/{user}/deactivate', [UserManagementController::class, 'deactivateUser'])->name('deactivate');
            Route::post('/{user}/logout-all', [UserManagementController::class, 'logoutAllSessions'])->name('logout-all');
            Route::delete('/{user}', [UserManagementController::class, 'deleteUser'])->name('destroy');
        });

        // Verification management routes with authentication
        Route::prefix('/verifications')->name('verifications.')->group(function () {
            Route::get('/', function (Request $request) {
                if (!auth()->check()) {
                    $returnUrl = $request->fullUrl();
                    return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
                }
                if (!auth()->user()->isAdmin()) {
                    return view('admin.under-construction');
                }
                return app(AdminDashboardController::class)->verifications($request);
            })->name('index');

            Route::get('/{verification}', function (Request $request, $verification) {
                if (!auth()->check()) {
                    $returnUrl = $request->fullUrl();
                    return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
                }
                if (!auth()->user()->isAdmin()) {
                    return view('admin.under-construction');
                }
                return app(AdminDashboardController::class)->showVerification($request, $verification);
            })->name('show');

            Route::post('/{verification}/approve', [AdminDashboardController::class, 'approveVerification'])->name('approve');
            Route::post('/{verification}/reject', [AdminDashboardController::class, 'rejectVerification'])->name('reject');
        });

        // Audit logs routes with authentication
        Route::prefix('/audit-logs')->name('audit-logs.')->group(function () {
            Route::get('/', function (Request $request) {
                if (!auth()->check()) {
                    $returnUrl = $request->fullUrl();
                    return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
                }
                if (!auth()->user()->isAdmin()) {
                    return view('admin.under-construction');
                }
                return app(AdminDashboardController::class)->auditLogs($request);
            })->name('index');
        });

        // Help Management routes with authentication
        Route::prefix('/help')->name('help.')->group(function () {
            // Help Dashboard
            Route::get('/', function (Request $request) {
                if (!auth()->check()) {
                    $returnUrl = $request->fullUrl();
                    return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
                }
                if (!auth()->user()->isAdmin()) {
                    return view('admin.under-construction');
                }
                return app(\App\Http\Controllers\Africoders\Admin\HelpManagementController::class)->dashboard($request);
            })->name('dashboard');

            // Contact Messages Management
            Route::prefix('/messages')->name('messages.')->group(function () {
                Route::get('/', function (Request $request) {
                    if (!auth()->check()) {
                        $returnUrl = $request->fullUrl();
                        return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
                    }
                    if (!auth()->user()->isAdmin()) {
                        return view('admin.under-construction');
                    }
                    return app(\App\Http\Controllers\Africoders\Admin\HelpManagementController::class)->messages($request);
                })->name('index');

                Route::get('/{message}', function (Request $request, $message) {
                    if (!auth()->check()) {
                        $returnUrl = $request->fullUrl();
                        return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
                    }
                    if (!auth()->user()->isAdmin()) {
                        return view('admin.under-construction');
                    }
                    return app(\App\Http\Controllers\Africoders\Admin\HelpManagementController::class)->showMessage(\App\Models\Help\ContactMessage::findOrFail($message));
                })->name('show');

                Route::put('/{message}/status', function (Request $request, $message) {
                    if (!auth()->check()) {
                        $returnUrl = $request->fullUrl();
                        return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
                    }
                    if (!auth()->user()->isAdmin()) {
                        return view('admin.under-construction');
                    }
                    return app(\App\Http\Controllers\Africoders\Admin\HelpManagementController::class)->updateMessageStatus(\App\Models\Help\ContactMessage::findOrFail($message), $request);
                })->name('update-status');

                Route::delete('/{message}', function (Request $request, $message) {
                    if (!auth()->check()) {
                        $returnUrl = $request->fullUrl();
                        return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
                    }
                    if (!auth()->user()->isAdmin()) {
                        return view('admin.under-construction');
                    }
                    return app(\App\Http\Controllers\Africoders\Admin\HelpManagementController::class)->deleteMessage(\App\Models\Help\ContactMessage::findOrFail($message));
                })->name('destroy');
            });

            // Articles Management
            Route::prefix('/articles')->name('articles.')->group(function () {
                Route::get('/', function (Request $request) {
                    if (!auth()->check()) {
                        $returnUrl = $request->fullUrl();
                        return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
                    }
                    if (!auth()->user()->isAdmin()) {
                        return view('admin.under-construction');
                    }
                    return app(\App\Http\Controllers\Africoders\Admin\HelpManagementController::class)->articles($request);
                })->name('index');

                Route::get('/create', function (Request $request) {
                    if (!auth()->check()) {
                        $returnUrl = $request->fullUrl();
                        return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
                    }
                    if (!auth()->user()->isAdmin()) {
                        return view('admin.under-construction');
                    }
                    return app(\App\Http\Controllers\Africoders\Admin\HelpManagementController::class)->createArticle();
                })->name('create');

                Route::post('/', function (Request $request) {
                    if (!auth()->check()) {
                        $returnUrl = $request->fullUrl();
                        return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
                    }
                    if (!auth()->user()->isAdmin()) {
                        return view('admin.under-construction');
                    }
                    return app(\App\Http\Controllers\Africoders\Admin\HelpManagementController::class)->storeArticle($request);
                })->name('store');

                Route::get('/{article}', function (Request $request, $article) {
                    if (!auth()->check()) {
                        $returnUrl = $request->fullUrl();
                        return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
                    }
                    if (!auth()->user()->isAdmin()) {
                        return view('admin.under-construction');
                    }
                    return app(\App\Http\Controllers\Africoders\Admin\HelpManagementController::class)->showArticle(\App\Models\Help\Article::findOrFail($article));
                })->name('show');

                Route::get('/{article}/edit', function (Request $request, $article) {
                    if (!auth()->check()) {
                        $returnUrl = $request->fullUrl();
                        return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
                    }
                    if (!auth()->user()->isAdmin()) {
                        return view('admin.under-construction');
                    }
                    return app(\App\Http\Controllers\Africoders\Admin\HelpManagementController::class)->editArticle(\App\Models\Help\Article::findOrFail($article));
                })->name('edit');

                Route::put('/{article}', function (Request $request, $article) {
                    if (!auth()->check()) {
                        $returnUrl = $request->fullUrl();
                        return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
                    }
                    if (!auth()->user()->isAdmin()) {
                        return view('admin.under-construction');
                    }
                    return app(\App\Http\Controllers\Africoders\Admin\HelpManagementController::class)->updateArticle(\App\Models\Help\Article::findOrFail($article), $request);
                })->name('update');

                Route::delete('/{article}', function (Request $request, $article) {
                    if (!auth()->check()) {
                        $returnUrl = $request->fullUrl();
                        return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
                    }
                    if (!auth()->user()->isAdmin()) {
                        return view('admin.under-construction');
                    }
                    return app(\App\Http\Controllers\Africoders\Admin\HelpManagementController::class)->deleteArticle(\App\Models\Help\Article::findOrFail($article));
                })->name('destroy');
            });

            // FAQs Management
            Route::prefix('/faqs')->name('faqs.')->group(function () {
                Route::get('/', function (Request $request) {
                    if (!auth()->check()) {
                        $returnUrl = $request->fullUrl();
                        return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
                    }
                    if (!auth()->user()->isAdmin()) {
                        return view('admin.under-construction');
                    }
                    return app(\App\Http\Controllers\Africoders\Admin\HelpManagementController::class)->faqs($request);
                })->name('index');

                Route::get('/create', function (Request $request) {
                    if (!auth()->check()) {
                        $returnUrl = $request->fullUrl();
                        return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
                    }
                    if (!auth()->user()->isAdmin()) {
                        return view('admin.under-construction');
                    }
                    return app(\App\Http\Controllers\Africoders\Admin\HelpManagementController::class)->createFaq();
                })->name('create');

                Route::post('/', function (Request $request) {
                    if (!auth()->check()) {
                        $returnUrl = $request->fullUrl();
                        return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
                    }
                    if (!auth()->user()->isAdmin()) {
                        return view('admin.under-construction');
                    }
                    return app(\App\Http\Controllers\Africoders\Admin\HelpManagementController::class)->storeFaq($request);
                })->name('store');

                Route::get('/{faq}', function (Request $request, $faq) {
                    if (!auth()->check()) {
                        $returnUrl = $request->fullUrl();
                        return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
                    }
                    if (!auth()->user()->isAdmin()) {
                        return view('admin.under-construction');
                    }
                    return app(\App\Http\Controllers\Africoders\Admin\HelpManagementController::class)->showFaq(\App\Models\Help\Faq::findOrFail($faq));
                })->name('show');

                Route::get('/{faq}/edit', function (Request $request, $faq) {
                    if (!auth()->check()) {
                        $returnUrl = $request->fullUrl();
                        return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
                    }
                    if (!auth()->user()->isAdmin()) {
                        return view('admin.under-construction');
                    }
                    return app(\App\Http\Controllers\Africoders\Admin\HelpManagementController::class)->editFaq(\App\Models\Help\Faq::findOrFail($faq));
                })->name('edit');

                Route::put('/{faq}', function (Request $request, $faq) {
                    if (!auth()->check()) {
                        $returnUrl = $request->fullUrl();
                        return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
                    }
                    if (!auth()->user()->isAdmin()) {
                        return view('admin.under-construction');
                    }
                    return app(\App\Http\Controllers\Africoders\Admin\HelpManagementController::class)->updateFaq(\App\Models\Help\Faq::findOrFail($faq), $request);
                })->name('update');

                Route::delete('/{faq}', function (Request $request, $faq) {
                    if (!auth()->check()) {
                        $returnUrl = $request->fullUrl();
                        return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
                    }
                    if (!auth()->user()->isAdmin()) {
                        return view('admin.under-construction');
                    }
                    return app(\App\Http\Controllers\Africoders\Admin\HelpManagementController::class)->deleteFaq(\App\Models\Help\Faq::findOrFail($faq));
                })->name('destroy');
            });

            // Legal Documents Management
            Route::prefix('/legal')->name('legal.')->group(function () {
                Route::get('/', function (Request $request) {
                    if (!auth()->check()) {
                        $returnUrl = $request->fullUrl();
                        return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
                    }
                    if (!auth()->user()->isAdmin()) {
                        return view('admin.under-construction');
                    }
                    return app(\App\Http\Controllers\Africoders\Admin\HelpManagementController::class)->legalDocuments($request);
                })->name('index');

                Route::get('/create', function (Request $request) {
                    if (!auth()->check()) {
                        $returnUrl = $request->fullUrl();
                        return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
                    }
                    if (!auth()->user()->isAdmin()) {
                        return view('admin.under-construction');
                    }
                    return app(\App\Http\Controllers\Africoders\Admin\HelpManagementController::class)->createLegalDocument();
                })->name('create');

                Route::post('/', function (Request $request) {
                    if (!auth()->check()) {
                        $returnUrl = $request->fullUrl();
                        return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
                    }
                    if (!auth()->user()->isAdmin()) {
                        return view('admin.under-construction');
                    }
                    return app(\App\Http\Controllers\Africoders\Admin\HelpManagementController::class)->storeLegalDocument($request);
                })->name('store');

                Route::get('/{document}', function (Request $request, $document) {
                    if (!auth()->check()) {
                        $returnUrl = $request->fullUrl();
                        return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
                    }
                    if (!auth()->user()->isAdmin()) {
                        return view('admin.under-construction');
                    }
                    return app(\App\Http\Controllers\Africoders\Admin\HelpManagementController::class)->showLegalDocument(\App\Models\Help\LegalDocument::findOrFail($document));
                })->name('show');

                Route::get('/{document}/edit', function (Request $request, $document) {
                    if (!auth()->check()) {
                        $returnUrl = $request->fullUrl();
                        return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
                    }
                    if (!auth()->user()->isAdmin()) {
                        return view('admin.under-construction');
                    }
                    return app(\App\Http\Controllers\Africoders\Admin\HelpManagementController::class)->editLegalDocument(\App\Models\Help\LegalDocument::findOrFail($document));
                })->name('edit');

                Route::put('/{document}', function (Request $request, $document) {
                    if (!auth()->check()) {
                        $returnUrl = $request->fullUrl();
                        return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
                    }
                    if (!auth()->user()->isAdmin()) {
                        return view('admin.under-construction');
                    }
                    return app(\App\Http\Controllers\Africoders\Admin\HelpManagementController::class)->updateLegalDocument(\App\Models\Help\LegalDocument::findOrFail($document), $request);
                })->name('update');

                Route::delete('/{document}', function (Request $request, $document) {
                    if (!auth()->check()) {
                        $returnUrl = $request->fullUrl();
                        return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
                    }
                    if (!auth()->user()->isAdmin()) {
                        return view('admin.under-construction');
                    }
                    return app(\App\Http\Controllers\Africoders\Admin\HelpManagementController::class)->deleteLegalDocument(\App\Models\Help\LegalDocument::findOrFail($document));
                })->name('destroy');
            });
        });

        // KortexTools Management routes with authentication
        Route::prefix('/kortextools')->name('kortextools.')->group(function () {
            // KortexTools Dashboard
            Route::get('/', function (Request $request) {
                if (!auth()->check()) {
                    $returnUrl = $request->fullUrl();
                    return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
                }
                if (!auth()->user()->isAdmin()) {
                    return view('admin.under-construction');
                }
                return app(\App\Http\Controllers\Africoders\Admin\Kortextools\DashboardController::class)->index($request);
            })->name('dashboard');

            // Tools Management
            Route::prefix('/tools')->name('tools.')->group(function () {
                Route::get('/', function (Request $request) {
                    if (!auth()->check()) {
                        $returnUrl = $request->fullUrl();
                        return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
                    }
                    if (!auth()->user()->isAdmin()) {
                        return view('admin.under-construction');
                    }
                    return app(\App\Http\Controllers\Africoders\Admin\Kortextools\ToolsManagementController::class)->index($request);
                })->name('index');

                Route::get('/{tool}', function (Request $request, $tool) {
                    if (!auth()->check()) {
                        $returnUrl = $request->fullUrl();
                        return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
                    }
                    if (!auth()->user()->isAdmin()) {
                        return view('admin.under-construction');
                    }
                    return app(\App\Http\Controllers\Africoders\Admin\Kortextools\ToolsManagementController::class)->show($tool);
                })->name('show');
            });

            // Ratings Management
            Route::prefix('/ratings')->name('ratings.')->group(function () {
                Route::get('/', function (Request $request) {
                    if (!auth()->check()) {
                        $returnUrl = $request->fullUrl();
                        return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
                    }
                    if (!auth()->user()->isAdmin()) {
                        return view('admin.under-construction');
                    }
                    return app(\App\Http\Controllers\Africoders\Admin\Kortextools\ToolRatingsController::class)->index($request);
                })->name('index');
            });
        });

        // Catch-all route for authentication/authorization - MUST BE LAST
        Route::get('/{any?}', function (Request $request) {
            // If user is not authenticated, redirect to ID domain with return URL
            if (!auth()->check()) {
                $returnUrl = $request->fullUrl();
                return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
            }

            // If user is authenticated but not admin, show under construction
            if (!auth()->user()->isAdmin()) {
                return view('admin.under-construction');
            }

            // User is authenticated and admin but route not found - redirect to dashboard
            return redirect()->route('admin.dashboard');

        })->where('any', '.*')->name('catch-all');
    });

// ==========================================
// HELP SERVICE (help.africoders)
// ==========================================
Route::domain(config('domains.africoders.help'))
    ->middleware(['web'])
    ->name('help.')
    ->group(function () {
        // Home page
        Route::get('/', [HelpHomeController::class, 'home'])->name('home');

        // Support & FAQ
        Route::get('/support', [SupportController::class, 'index'])->name('support');
        Route::get('/faq', [SupportController::class, 'faq'])->name('faq');

        // Articles
        Route::get('/articles', [SupportController::class, 'articles'])->name('articles');
        Route::get('/article/{slug}', [SupportController::class, 'article'])->name('article');

        // Direct business guidelines route for SEO and bookmarked links
        Route::get('/business-guidelines', function() {
            return app(SupportController::class)->article('business-guidelines');
        })->name('business-guidelines');

        // Contact
        Route::get('/contact', [ContactController::class, 'show'])->name('contact');
        Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');
        Route::get('/contact-success', [ContactController::class, 'success'])->name('contact.success');
        Route::get('/contact-error', [ContactController::class, 'error'])->name('contact.error');

        // Search
        Route::get('/search', [SearchController::class, 'search'])->name('search');

        // Auth routes (redirect to ID service with return URL)
        Route::get('/login', function (Request $request) {
            $returnUrl = $request->input('return', $request->fullUrl());
            return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
        })->name('login');

        Route::get('/logout', function (Request $request) {
            $returnUrl = $request->input('return', request()->getScheme() . '://' . request()->getHost() . '/');
            return redirect('https://' . config('domains.africoders.id') . '/logout?return=' . urlencode($returnUrl));
        })->name('logout');

        // Protected user routes
        Route::middleware('auth')->group(function () {
            Route::get('/dashboard', function () {
                return redirect()->route('help.home');
            })->name('dashboard');
        });

        // Legal documents (catch-all at the end)
        Route::get('/{slug}', [LegalController::class, 'document'])->name('legal');
    });

// ==========================================
// AFRICODERS MAIN SITE (africoders.test)
// ==========================================
Route::domain(config('domains.africoders.main'))
    ->middleware(['web'])
    ->name('africoders.')
    ->group(function () {
        // Public routes
        Route::get('/', [AfriccodersPublicController::class, 'home'])->name('home');
        Route::get('/about', [AfriccodersPublicController::class, 'showPage'])->defaults('page', 'about')->name('about');
        Route::get('/vision', [AfriccodersPublicController::class, 'showPage'])->defaults('page', 'vision')->name('vision');
        Route::get('/mission', [AfriccodersPublicController::class, 'showPage'])->defaults('page', 'mission')->name('mission');
        Route::get('/partnerships', [AfriccodersPublicController::class, 'showPage'])->defaults('page', 'partnerships')->name('partnerships');

        Route::get('/ventures', [AfriccodersPublicController::class, 'ventures'])->name('ventures.index');
        Route::get('/ventures/{venture}', [AfriccodersPublicController::class, 'showVenture'])->name('ventures.show');

        Route::get('/ecosystem', [AfriccodersPublicController::class, 'ecosystem'])->name('ecosystem');

        Route::get('/press', [AfriccodersPublicController::class, 'press'])->name('press.index');
        Route::get('/press/{pressRelease}', [AfriccodersPublicController::class, 'showPressRelease'])->name('press.show');

        Route::redirect('/contact', 'https://' . config('domains.africoders.help') . '/contact');
        Route::redirect('/static/privacy', 'https://' . config('domains.africoders.help') . '/privacy');
        Route::redirect('/static/terms', 'https://' . config('domains.africoders.help') . '/terms');

        // Auth routes (redirect to ID service)
        Route::get('/login', [AfriccodersAuthController::class, 'login'])->name('login');
        Route::get('/logout', [AfriccodersAuthController::class, 'logout'])->name('logout');
        Route::post('/logout', [AfriccodersAuthController::class, 'logout'])->name('logout.post');

        // Protected user routes
        Route::middleware('auth')->group(function () {
            Route::get('/dashboard', [AfricodersDashboardController::class, 'index'])->name('dashboard');
            Route::get('/account', [AfricodersDashboardController::class, 'account'])->name('account');
        });

        // Named page routes with explicit parameters (must come before catch-all)
        Route::get('/about', [AfriccodersPublicController::class, 'showPage'])->defaults('page', 'about')->name('about');
        Route::get('/vision', [AfriccodersPublicController::class, 'showPage'])->defaults('page', 'vision')->name('vision');
        Route::get('/mission', [AfriccodersPublicController::class, 'showPage'])->defaults('page', 'mission')->name('mission');
        Route::get('/partnerships', [AfriccodersPublicController::class, 'showPage'])->defaults('page', 'partnerships')->name('partnerships');
        Route::get('/{page}', [AfriccodersPublicController::class, 'showPage'])->name('page');

        // Admin routes (protected by auth and admin check)
        Route::middleware(['auth', 'admin'])->prefix('/admin')->name('admin.')->group(function () {
            Route::get('/africoders', [AfriccodersAdminController::class, 'dashboard'])->name('africoders.dashboard');

            // Pages management
            Route::prefix('/pages')->name('africoders.pages.')->group(function () {
                Route::get('/', [AfriccodersAdminController::class, 'pages'])->name('index');
                Route::get('/create', [AfriccodersAdminController::class, 'createPage'])->name('create');
                Route::post('/', [AfriccodersAdminController::class, 'storePage'])->name('store');
                Route::get('/{page}/edit', [AfriccodersAdminController::class, 'editPage'])->name('edit');
                Route::put('/{page}', [AfriccodersAdminController::class, 'updatePage'])->name('update');
                Route::delete('/{page}', [AfriccodersAdminController::class, 'deletePage'])->name('destroy');
            });

            // Ventures management
            Route::prefix('/ventures')->name('africoders.ventures.')->group(function () {
                Route::get('/', [AfriccodersAdminController::class, 'ventures'])->name('index');
                Route::get('/create', [AfriccodersAdminController::class, 'createVenture'])->name('create');
                Route::post('/', [AfriccodersAdminController::class, 'storeVenture'])->name('store');
                Route::get('/{venture}/edit', [AfriccodersAdminController::class, 'editVenture'])->name('edit');
                Route::put('/{venture}', [AfriccodersAdminController::class, 'updateVenture'])->name('update');
                Route::delete('/{venture}', [AfriccodersAdminController::class, 'deleteVenture'])->name('destroy');
            });

            // Press releases management
            Route::prefix('/press')->name('africoders.press.')->group(function () {
                Route::get('/', [AfriccodersAdminController::class, 'press'])->name('index');
                Route::get('/create', [AfriccodersAdminController::class, 'createPress'])->name('create');
                Route::post('/', [AfriccodersAdminController::class, 'storePress'])->name('store');
                Route::get('/{pressRelease}/edit', [AfriccodersAdminController::class, 'editPress'])->name('edit');
                Route::put('/{pressRelease}', [AfriccodersAdminController::class, 'updatePress'])->name('update');
                Route::delete('/{pressRelease}', [AfriccodersAdminController::class, 'deletePress'])->name('destroy');
            });
        });
    });

// ==========================================
// NOCCEA UNIFIED (noccea.test/noccea.com)
// Entry Hub + Path-based routing for ecosystem services
//
// Strategy: Hybrid approach combining spec's vision with modern UX
// 1. noccea.com serves as Entry Hub (onboarding, storytelling, navigation)
// 2. Path-based routes provide unified access: /community, /business, /learn
// 3. Subdomain routes provide dedicated experiences: community.noccea.com
// 4. Session sharing across all access methods via .noccea.com cookie
// ==========================================
Route::domain(config('domains.noccea.main'))
    ->middleware(['web'])
    ->name('noccea.')
    ->group(function () {
        // Entry Hub - Main discovery and onboarding
        Route::get('/', [NocceaMainHomeController::class, 'index'])->name('home');

        // Main Community Hub (legacy route + direct access)
        Route::get('/main', [NocceaMainHomeController::class, 'index'])->name('main.home');
        Route::get('/main/login', [NocceaMainHomeController::class, 'login'])->name('main.login');
        Route::get('/main/logout', [NocceaMainHomeController::class, 'logout'])->name('main.logout');
        Route::post('/main/logout', [NocceaMainHomeController::class, 'logout'])->name('main.logout.post');
        Route::middleware('auth')->get('/main/dashboard', [NocceaMainHomeController::class, 'dashboard'])->name('main.dashboard');

        // Community Platform - Forums & discussions
        Route::get('/community', [NocceaCommunityHomeController::class, 'index'])->name('community.home');
        Route::get('/community/login', [NocceaCommunityHomeController::class, 'login'])->name('community.login');
        Route::get('/community/logout', [NocceaCommunityHomeController::class, 'logout'])->name('community.logout');
        Route::post('/community/logout', [NocceaCommunityHomeController::class, 'logout'])->name('community.logout.post');
        Route::middleware('auth')->get('/community/dashboard', [NocceaCommunityHomeController::class, 'dashboard'])->name('community.dashboard');

        // Community Discussion Routes
        Route::prefix('/community')->name('community.')->group(function () {
            // Categories
            Route::get('/categories', [\App\Http\Controllers\Noccea\Community\CategoryController::class, 'index'])->name('categories.index');
            Route::get('/categories/{category}', [\App\Http\Controllers\Noccea\Community\CategoryController::class, 'show'])->name('categories.show');

            // Discussions
            Route::get('/discussions', [\App\Http\Controllers\Noccea\Community\DiscussionController::class, 'index'])->name('discussions.index');
            Route::get('/discussions/create', [\App\Http\Controllers\Noccea\Community\DiscussionController::class, 'create'])->name('discussions.create');
            Route::post('/discussions', [\App\Http\Controllers\Noccea\Community\DiscussionController::class, 'store'])->name('discussions.store');
            Route::get('/discussions/{discussion}', [\App\Http\Controllers\Noccea\Community\DiscussionController::class, 'show'])->name('discussions.show');
            Route::get('/discussions/{discussion}/edit', [\App\Http\Controllers\Noccea\Community\DiscussionController::class, 'edit'])->name('discussions.edit');
            Route::put('/discussions/{discussion}', [\App\Http\Controllers\Noccea\Community\DiscussionController::class, 'update'])->name('discussions.update');
            Route::delete('/discussions/{discussion}', [\App\Http\Controllers\Noccea\Community\DiscussionController::class, 'destroy'])->middleware('auth')->name('discussions.destroy');

            // Discussion Replies
            Route::get('/discussions/{discussion}/replies/create', [\App\Http\Controllers\Noccea\Community\DiscussionController::class, 'createReply'])->name('discussions.replies.create');
            Route::post('/discussions/{discussion}/replies', [\App\Http\Controllers\Noccea\Community\DiscussionController::class, 'storeReply'])->name('discussions.replies.store');
            Route::get('/replies/{reply}/edit', [\App\Http\Controllers\Noccea\Community\DiscussionController::class, 'editReply'])->name('replies.edit');
            Route::put('/replies/{reply}', [\App\Http\Controllers\Noccea\Community\DiscussionController::class, 'updateReply'])->name('replies.update');
            Route::delete('/replies/{reply}', [\App\Http\Controllers\Noccea\Community\DiscussionController::class, 'destroyReply'])->name('replies.destroy');
            Route::post('/replies/{reply}/best-answer', [\App\Http\Controllers\Noccea\Community\DiscussionController::class, 'markBestAnswer'])->name('replies.best-answer');

            // Voting
            Route::post('/discussions/{discussion}/vote', [\App\Http\Controllers\Noccea\Community\DiscussionController::class, 'vote'])->name('discussions.vote');
            Route::post('/replies/{reply}/vote', [\App\Http\Controllers\Noccea\Community\DiscussionController::class, 'voteReply'])->name('replies.vote');

            // Bookmarks
            Route::get('/bookmarks', [\App\Http\Controllers\Noccea\Community\DiscussionController::class, 'bookmarksIndex'])->name('bookmarks.index');
            Route::post('/discussions/{discussion}/bookmark', [\App\Http\Controllers\Noccea\Community\DiscussionController::class, 'bookmark'])->name('discussions.bookmark');

            // Members
            Route::get('/members', [\App\Http\Controllers\Noccea\Community\MemberController::class, 'index'])->name('members.index');
            Route::get('/members/top-contributors', [\App\Http\Controllers\Noccea\Community\MemberController::class, 'topContributors'])->name('members.top-contributors');
            Route::get('/members/{user}', [\App\Http\Controllers\Noccea\Community\MemberController::class, 'show'])->name('members.show');
        });

        // Business Discovery - Business listings & networking
        Route::get('/business', [NocceaBusinessHomeController::class, 'index'])->name('business.home');
        Route::get('/business/login', [NocceaBusinessHomeController::class, 'login'])->name('business.login');
        Route::get('/business/logout', [NocceaBusinessHomeController::class, 'logout'])->name('business.logout');
        Route::post('/business/logout', [NocceaBusinessHomeController::class, 'logout'])->name('business.logout.post');
        Route::middleware('auth')->get('/business/dashboard', [NocceaBusinessHomeController::class, 'dashboard'])->name('business.dashboard');

        // Learning Platform - Cohort-based courses & mentorship
        Route::get('/learn', [NocceaLearnHomeController::class, 'index'])->name('learn.home');
        Route::get('/learn/login', [NocceaLearnHomeController::class, 'login'])->name('learn.login');
        Route::get('/learn/logout', [NocceaLearnHomeController::class, 'logout'])->name('learn.logout');
        Route::post('/learn/logout', [NocceaLearnHomeController::class, 'logout'])->name('learn.logout.post');
        Route::middleware('auth')->get('/learn/dashboard', [NocceaLearnHomeController::class, 'dashboard'])->name('learn.dashboard');

        // Legacy auth routes for backward compatibility
        Route::get('/login', [NocceaMainHomeController::class, 'login'])->name('login');
        Route::get('/logout', [NocceaMainHomeController::class, 'logout'])->name('logout');
        Route::post('/logout', [NocceaMainHomeController::class, 'logout'])->name('logout.post');

        // Protected routes
        Route::middleware('auth')->group(function () {
            Route::get('/dashboard', [NocceaMainHomeController::class, 'dashboard'])->name('dashboard');
        });
    });

// ==========================================
// NOCCEA SUBDOMAIN ROUTING (Legacy Support + Dedicated Experiences)
//
// Strategy: Complement unified routes with dedicated subdomain experiences
// - community.noccea.com: Dedicated community-first experience
// - business.noccea.com: Dedicated business discovery experience
// - learn.noccea.com: Dedicated learning platform experience
//
// Benefits:
// 1. Brand recognition (each service has its own subdomain identity)
// 2. SEO advantages (subdomain-specific content & keywords)
// 3. User preference (some prefer dedicated environments)
// 4. Future microservice migration path
//
// Note: These handle ONLY root routes (/). Path routes handled by main domain.
// ==========================================

// Noccea Community (via subdomain: community.noccea.test)
// Subdomain access for dedicated community experience
Route::domain(config('domains.noccea.community'))
    ->middleware(['web'])
    ->name('noccea.community.')
    ->group(function () {
        // Root landing page - Community hub
        Route::get('/', [NocceaCommunityHomeController::class, 'index'])->name('home');
        Route::get('/login', [NocceaCommunityHomeController::class, 'login'])->name('login');
        Route::get('/logout', [NocceaCommunityHomeController::class, 'logout'])->name('logout');
        Route::post('/logout', [NocceaCommunityHomeController::class, 'logout'])->name('logout.post');
        Route::middleware('auth')->get('/dashboard', [NocceaCommunityHomeController::class, 'dashboard'])->name('dashboard');

        // Community Features (same as main domain but with different route names)
        // Categories
        Route::get('/categories', [\App\Http\Controllers\Noccea\Community\CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/{category}', [\App\Http\Controllers\Noccea\Community\CategoryController::class, 'show'])->name('categories.show');

        // Discussions
        Route::get('/discussions', [\App\Http\Controllers\Noccea\Community\DiscussionController::class, 'index'])->name('discussions.index');
        Route::get('/discussions/create', [\App\Http\Controllers\Noccea\Community\DiscussionController::class, 'create'])->name('discussions.create');
        Route::post('/discussions', [\App\Http\Controllers\Noccea\Community\DiscussionController::class, 'store'])->name('discussions.store');
        Route::get('/discussions/{discussion}', [\App\Http\Controllers\Noccea\Community\DiscussionController::class, 'show'])->name('discussions.show');
        Route::get('/discussions/{discussion}/edit', [\App\Http\Controllers\Noccea\Community\DiscussionController::class, 'edit'])->name('discussions.edit');
        Route::put('/discussions/{discussion}', [\App\Http\Controllers\Noccea\Community\DiscussionController::class, 'update'])->name('discussions.update');
        Route::delete('/discussions/{discussion}', [\App\Http\Controllers\Noccea\Community\DiscussionController::class, 'destroy'])->middleware('auth')->name('discussions.destroy');

        // Discussion Replies
        Route::get('/discussions/{discussion}/replies/create', [\App\Http\Controllers\Noccea\Community\DiscussionController::class, 'createReply'])->name('discussions.replies.create');
        Route::post('/discussions/{discussion}/replies', [\App\Http\Controllers\Noccea\Community\DiscussionController::class, 'storeReply'])->name('discussions.replies.store');
        Route::get('/replies/{reply}/edit', [\App\Http\Controllers\Noccea\Community\DiscussionController::class, 'editReply'])->name('replies.edit');
        Route::put('/replies/{reply}', [\App\Http\Controllers\Noccea\Community\DiscussionController::class, 'updateReply'])->name('replies.update');
        Route::delete('/replies/{reply}', [\App\Http\Controllers\Noccea\Community\DiscussionController::class, 'destroyReply'])->name('replies.destroy');
        Route::post('/replies/{reply}/best-answer', [\App\Http\Controllers\Noccea\Community\DiscussionController::class, 'markBestAnswer'])->name('replies.best-answer');

        // Voting
        Route::post('/discussions/{discussion}/vote', [\App\Http\Controllers\Noccea\Community\DiscussionController::class, 'vote'])->name('discussions.vote');
        Route::post('/replies/{reply}/vote', [\App\Http\Controllers\Noccea\Community\DiscussionController::class, 'voteReply'])->name('replies.vote');

        // Bookmarks
        Route::get('/bookmarks', [\App\Http\Controllers\Noccea\Community\DiscussionController::class, 'bookmarksIndex'])->name('bookmarks.index');
        Route::post('/discussions/{discussion}/bookmark', [\App\Http\Controllers\Noccea\Community\DiscussionController::class, 'bookmark'])->name('discussions.bookmark');

        // Members
        Route::get('/members', [\App\Http\Controllers\Noccea\Community\MemberController::class, 'index'])->name('members.index');
        Route::get('/members/top-contributors', [\App\Http\Controllers\Noccea\Community\MemberController::class, 'topContributors'])->name('members.top-contributors');
        Route::get('/members/{user}', [\App\Http\Controllers\Noccea\Community\MemberController::class, 'show'])->name('members.show');
    });

// Noccea Business (via subdomain: business.noccea.test)
// Subdomain access for dedicated business discovery experience
Route::domain(config('domains.noccea.business'))
    ->middleware(['web'])
    ->name('noccea.business.')
    ->group(function () {
        // Root landing page - Business discovery hub
        Route::get('/', [NocceaBusinessHomeController::class, 'index'])->name('home');
        Route::get('/login', [NocceaBusinessHomeController::class, 'login'])->name('login');
        Route::get('/logout', [NocceaBusinessHomeController::class, 'logout'])->name('logout');
        Route::post('/logout', [NocceaBusinessHomeController::class, 'logout'])->name('logout.post');
        Route::get('/dashboard', [NocceaBusinessHomeController::class, 'dashboard'])->name('dashboard');

        // Business listings
        Route::get('/businesses', [BusinessController::class, 'index'])->name('businesses.index');
        Route::get('/businesses/featured', [BusinessController::class, 'featured'])->name('businesses.featured');
        Route::middleware('auth')->get('/businesses/create', [BusinessController::class, 'create'])->name('businesses.create');
        Route::middleware('auth')->post('/businesses', [BusinessController::class, 'store'])->name('businesses.store');
        Route::get('/businesses/{business}', [BusinessController::class, 'show'])->name('businesses.show');

        // Business bookmarks
        Route::middleware('auth')->get('/bookmarks', [BusinessController::class, 'bookmarksIndex'])->name('bookmarks.index');
        Route::middleware('auth')->post('/businesses/{business}/bookmark', [BusinessController::class, 'bookmark'])->name('businesses.bookmark');
        Route::middleware('auth')->delete('/businesses/{business}/bookmark', [BusinessController::class, 'unbookmark'])->name('businesses.unbookmark');

        // Business reviews
        Route::middleware('auth')->post('/businesses/{business}/reviews', [BusinessController::class, 'storeReview'])->name('businesses.reviews.store');
        Route::middleware('auth')->patch('/reviews/{review}', [BusinessController::class, 'updateReview'])->name('reviews.update');
        Route::middleware('auth')->delete('/reviews/{review}', [BusinessController::class, 'deleteReview'])->name('reviews.delete');

        // Categories
        Route::get('/categories', [BusinessCategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/{category}', [BusinessCategoryController::class, 'show'])->name('categories.show');
    });

// Noccea Learning (via subdomain: learn.noccea.test)
// Subdomain access for dedicated learning platform experience
Route::domain(config('domains.noccea.learn'))
    ->middleware(['web'])
    ->name('noccea.learn.')
    ->group(function () {
        // Root landing page - Learning platform hub
        Route::get('/', [NocceaLearnHomeController::class, 'index'])->name('home');
        Route::get('/login', [NocceaLearnHomeController::class, 'login'])->name('login');
        Route::get('/logout', [NocceaLearnHomeController::class, 'logout'])->name('logout');
        Route::post('/logout', [NocceaLearnHomeController::class, 'logout'])->name('logout.post');
        Route::middleware('auth')->get('/dashboard', [NocceaLearnHomeController::class, 'dashboard'])->name('dashboard');

        // Courses
        Route::get('/courses', [NocceaLearnHomeController::class, 'courses'])->name('courses.index');
        Route::get('/courses/{slug}', [NocceaLearnHomeController::class, 'courseDetail'])->name('courses.show');
        Route::post('/enroll', [NocceaLearnHomeController::class, 'enroll'])->name('enroll')->middleware('auth');

        // Certificates
        Route::get('/certificates', [NocceaLearnHomeController::class, 'certificates'])->name('certificates.index');

        // Instructors
        Route::get('/instructors', [NocceaLearnHomeController::class, 'instructors'])->name('instructors.index');

        // Study Groups
        Route::get('/study-groups', [StudyGroupController::class, 'index'])->name('study-groups.index');
        Route::middleware('auth')->get('/study-groups/create', [StudyGroupController::class, 'create'])->name('study-groups.create');
        Route::middleware('auth')->post('/study-groups', [StudyGroupController::class, 'store'])->name('study-groups.store');
        Route::get('/study-groups/{studyGroup}', [StudyGroupController::class, 'show'])->name('study-groups.show');
        Route::middleware('auth')->post('/study-groups/{studyGroup}/join', [StudyGroupController::class, 'join'])->name('study-groups.join');
        Route::middleware('auth')->post('/study-groups/{studyGroup}/leave', [StudyGroupController::class, 'leave'])->name('study-groups.leave');
        Route::middleware('auth')->get('/study-groups/{studyGroup}/edit', [StudyGroupController::class, 'edit'])->name('study-groups.edit');
        Route::middleware('auth')->put('/study-groups/{studyGroup}', [StudyGroupController::class, 'update'])->name('study-groups.update');
        Route::middleware('auth')->delete('/study-groups/{studyGroup}', [StudyGroupController::class, 'destroy'])->name('study-groups.destroy');
        Route::middleware('auth')->post('/study-groups/{studyGroup}/messages', [StudyGroupController::class, 'postMessage'])->name('study-groups.messages.post');
        Route::middleware('auth')->put('/study-groups/{studyGroup}/messages/{message}', [StudyGroupController::class, 'updateMessage'])->name('study-groups.messages.update');
        Route::middleware('auth')->delete('/study-groups/{studyGroup}/messages/{message}', [StudyGroupController::class, 'deleteMessage'])->name('study-groups.messages.delete');

        // Q&A Forum
        Route::get('/qa-forum', [ForumController::class, 'index'])->name('qa-forum.index');
        Route::middleware('auth')->get('/qa-forum/create', [ForumController::class, 'create'])->name('qa-forum.create');
        Route::middleware('auth')->post('/qa-forum', [ForumController::class, 'store'])->name('qa-forum.store');
        Route::get('/qa-forum/{question}', [ForumController::class, 'show'])->name('qa-forum.show');
        Route::middleware('auth')->post('/qa-forum/{question}/answers', [ForumController::class, 'answerStore'])->name('qa-forum.answer.store');
        Route::middleware('auth')->post('/qa-forum/{question}/answers/{answer}/accept', [ForumController::class, 'markAccepted'])->name('qa-forum.answer.accept');
        Route::middleware('auth')->delete('/qa-forum/{question}', [ForumController::class, 'destroy'])->name('qa-forum.destroy');

        // Forum Answer CRUD (Edit, Update, Delete)
        Route::middleware('auth')->get('/qa-forum/{question}/answers/{answer}/edit', [ForumController::class, 'editAnswer'])->name('qa-forum.answer.edit');
        Route::middleware('auth')->patch('/qa-forum/{question}/answers/{answer}', [ForumController::class, 'updateAnswer'])->name('qa-forum.answer.update');
        Route::middleware('auth')->delete('/qa-forum/{question}/answers/{answer}', [ForumController::class, 'deleteAnswer'])->name('qa-forum.answer.delete');

        // Forum Voting and Bookmarks
        Route::middleware('auth')->post('/qa-forum/{question}/vote', [ForumController::class, 'vote'])->name('qa-forum.vote');
        Route::middleware('auth')->post('/qa-forum/{question}/answers/{answer}/vote', [ForumController::class, 'voteAnswer'])->name('qa-forum.answer.vote');
        Route::middleware('auth')->post('/qa-forum/{question}/bookmark', [ForumController::class, 'bookmark'])->name('qa-forum.bookmark');

        // Leaderboard
        Route::get('/leaderboard', [NocceaLearnHomeController::class, 'leaderboard'])->name('leaderboard.index');

        // Bookmarks
        Route::middleware('auth')->get('/bookmarks', [NocceaLearnHomeController::class, 'bookmarks'])->name('bookmarks.index');

        // Lessons
        Route::middleware('auth')->get('/courses/{courseSlug}/modules/{moduleName}/lessons/{lessonId}', [LessonController::class, 'show'])->name('lesson.show');
        Route::middleware('auth')->post('/lessons/{lessonId}/complete', [LessonController::class, 'markComplete'])->name('lesson.complete');

        // Reviews
        Route::middleware('auth')->post('/courses/{courseId}/reviews', [ReviewController::class, 'store'])->name('review.store');
        Route::middleware('auth')->put('/reviews/{review}', [ReviewController::class, 'update'])->name('review.update');
        Route::middleware('auth')->delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('review.destroy');
    });

// ==========================================
// KORTEX TOOLS (kortextools)
// ==========================================
Route::domain(config('domains.tools.kortex'))
    ->middleware(['web'])
    ->name('tools.kortex.')
    ->prefix('/')
    ->group(function () {
        // Home
        Route::get('/', [ToolsController::class, 'index'])->name('home');

        // Tools
        Route::get('/explore', [ToolsController::class, 'index'])->name('tools.index');
        Route::get('/all-tools', [ToolsController::class, 'allTools'])->name('all-tools');
        Route::get('/how-it-works', [ToolsController::class, 'howItWorks'])->name('how-it-works');
        Route::get('/tool/{slug}', [ToolsController::class, 'show'])->name('tool.show');
        Route::post('/tool/{slug}', [ToolsController::class, 'handle'])
            ->middleware(['throttle:50,1'])
            ->name('tool.submit');

        // Categories
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/tools/{category}', [ToolsController::class, 'showCategory'])->name('tools.category');

        // Search
        Route::get('/search', [SearchController::class, 'index'])->name('search');

        // API - Requires Authentication
        Route::post('/api/tools/{slug}/rate', [ToolRatingController::class, 'rateTool'])
            ->middleware(['auth']);

        // Contact (redirect)
        Route::redirect('/contact', 'https://help.africoders.com/contact')->name('contact');

        // All other routes require authentication check
        // This will be handled by middleware or explicit checks in controllers
    });
