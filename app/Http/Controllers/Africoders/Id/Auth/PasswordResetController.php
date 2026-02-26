<?php

namespace App\Http\Controllers\Africoders\Id\Auth;

use App\Http\Controllers\Controller;
use App\Services\PasswordResetService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    protected $passwordResetService;

    public function __construct(PasswordResetService $passwordResetService)
    {
        $this->passwordResetService = $passwordResetService;
    }

    /**
     * Show forgot password form.
     */
    public function showForgotPassword()
    {
        if (auth()->check()) {
            return redirect()->route('id.dashboard');
        }
        return view('africoders.id.auth.forgot-password');
    }

    /**
     * Handle forgot password request.
     */
    public function forgotPassword(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'g-recaptcha-response' => ['required'],
        ]);

        // Verify reCAPTCHA
        $recaptchaResponse = $request->input('g-recaptcha-response');
        $response = \Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $recaptchaResponse,
        ]);

        $result = $response->json();

        if (!$result['success'] || ($result['score'] ?? 1) < 0.5) {
            return back()
                ->withInput()
                ->withErrors(['g-recaptcha-response' => 'reCAPTCHA verification failed. Please try again.']);
        }

        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            // Don't reveal if email exists - show success message anyway
            return view('africoders.id.auth.forgot-password', [
                'success' => 'If an account exists with this email, you will receive a password reset link.',
            ]);
        }

        try {
            $this->passwordResetService->sendResetEmail($user);

            \App\Models\AuditLog::create([
                'user_id' => $user->id,
                'action' => 'password_reset_requested',
                'details' => 'User requested password reset',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return view('africoders.id.auth.forgot-password', [
                'success' => 'Password reset link has been sent to your email. Please check your inbox.',
            ]);
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Failed to send reset email. Please try again.']);
        }
    }

    /**
     * Show password reset form.
     */
    public function showResetPassword($token)
    {
        if (auth()->check()) {
            return redirect()->route('id.dashboard');
        }

        // Verify token and get user
        $user = $this->passwordResetService->verifyToken($token);

        if (!$user) {
            return redirect()->route('id.password.forgot')
                ->withErrors(['token' => 'Invalid or expired password reset link.']);
        }

        // Recreate the token since verifyToken deletes it
        $newToken = $this->passwordResetService->generateToken($user);

        return view('africoders.id.auth.reset-password', [
            'token' => $newToken,
            'email' => $user->email
        ]);
    }

    /**
     * Handle password reset.
     */
    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'token' => ['required', 'string'],
            'password' => ['required', 'min:6'],
        ]);

        $user = $this->passwordResetService->verifyToken($validated['token']);

        if (!$user) {
            return redirect()->route('id.password.forgot')
                ->withErrors(['token' => 'Invalid or expired password reset link.']);
        }

        try {
            $this->passwordResetService->resetPassword($user, $validated['password']);

            \App\Models\AuditLog::create([
                'user_id' => $user->id,
                'action' => 'password_reset_completed',
                'details' => 'User successfully reset password',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Auto-login the user
            auth()->login($user, remember: false);

            // Create a new session record
            app(\App\Services\SessionManagerService::class)->createSession($user, $request);

            return redirect()->route('id.dashboard')
                ->with('success', 'Password reset successfully. You are now logged in.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Password reset failed. Please try again.']);
        }
    }
}
