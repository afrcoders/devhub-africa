<?php

namespace App\Http\Middleware;

use App\Services\SessionManagerService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateSessionToken
{
    protected $sessionManager;

    public function __construct(SessionManagerService $sessionManager)
    {
        $this->sessionManager = $sessionManager;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();
            $sessionToken = session('session_token');

            if (!empty($sessionToken)) {
                if (!$this->sessionManager->validateSession($user, $sessionToken)) {
                    auth()->logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    return redirect()->route('noccea.business.login')
                        ->with('error', 'Your password was changed from another location. Please log in again.');
                }
            }
        }

        return $next($request);
    }
}
