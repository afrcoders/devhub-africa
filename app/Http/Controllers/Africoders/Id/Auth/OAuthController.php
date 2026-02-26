<?php

namespace App\Http\Controllers\Africoders\Id\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class OAuthController extends Controller
{
    /**
     * Redirect to social provider.
     */
    public function redirect($provider)
    {
        // Validate provider
        $allowedProviders = ['google', 'github', 'facebook', 'twitter', 'x', 'linkedin'];
        if (!in_array($provider, $allowedProviders)) {
            return redirect()->route('id.auth.unified')->withErrors(['error' => 'Invalid provider']);
        }

        // Map 'twitter' to 'x' for Socialite driver
        $driver = $provider === 'twitter' ? 'x' : $provider;

        // For X/Twitter, request specific scopes for user email and profile
        if ($driver === 'x') {
            return Socialite::driver($driver)
                ->scopes(['tweet.read', 'users.read', 'users.email'])
                ->redirect();
        }

        // For LinkedIn, request specific scopes (updated OAuth 2.0 scopes)
        if ($driver === 'linkedin') {
            return Socialite::driver($driver)
                ->scopes(['openid', 'profile', 'email'])
                ->redirect();
        }

        return Socialite::driver($driver)->redirect();
    }

    /**
     * Handle callback from social provider.
     */
    public function callback($provider)
    {
        try {
            // Map 'twitter' to 'x' for Socialite driver
            $driver = $provider === 'twitter' ? 'x' : $provider;

            // Get user from provider
            $socialUser = Socialite::driver($driver)->user();

            // Extract and normalize data from social provider
            $email = $socialUser->getEmail();
            $name = $socialUser->getName() ?? $socialUser->getNickname();
            $avatar = $socialUser->getAvatar();

            // Normalize provider name for storage (use 'twitter' instead of 'x')
            $storageName = $provider === 'x' ? 'twitter' : $provider;

            // Check if user exists by email (if email is available)
            $user = null;
            if ($email) {
                $user = User::where('email', $email)->first();
            }

            if ($user) {
                // User exists, update social ID and last login
                $user->update([
                    "{$storageName}_id" => $socialUser->getId(),
                    'last_login' => now(),
                ]);
            } else {
                // Generate email if not provided by provider
                if (!$email) {
                    $email = $this->generateEmailFromSocialUser($storageName, $socialUser);
                }

                // Create new user
                $user = User::create([
                    'email' => $email,
                    'full_name' => $name ?? $this->generateNameFromEmail($email),
                    'username' => $this->generateUsername($socialUser),
                    'password' => Hash::make(Str::random(32)),
                    "{$storageName}_id" => $socialUser->getId(),
                    'profile_picture' => $avatar,
                    'role' => 'member',
                    'trust_level' => 'unverified',
                    'email_verified' => true,
                    'email_verified_at' => now(),
                    'is_active' => true,
                ]);

                // Create verification record
                $user->verifications()->create([
                    'type' => 'identity',
                    'status' => 'not_submitted',
                ]);

                // Log signup
                \App\Models\AuditLog::create([
                    'user_id' => $user->id,
                    'action' => 'signup_' . $storageName,
                    'details' => "User registered via {$storageName}",
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ]);
            }

            // Log in the user
            auth()->login($user);

            // Refresh user from database
            $user = auth()->user()->fresh();
            auth()->setUser($user);

            // Create session
            app(\App\Services\SessionManagerService::class)->createSession($user);

            return redirect()->route('id.dashboard')->with('success', "Welcome {$user->full_name}!");

        } catch (\Exception $e) {
            return redirect()->route('id.auth.unified')->withErrors(['error' => "Failed to authenticate with {$provider}: " . $e->getMessage()]);
        }
    }

    /**
     * Generate a unique username from social user data.
     */
    private function generateUsername($socialUser): string
    {
        // Try to get username from nickname or name
        $baseUsername = $socialUser->getNickname() ??
                       str_replace(' ', '', strtolower($socialUser->getName() ?? '')) ??
                       str_replace('@', '', strtolower($socialUser->getEmail() ?? ''));

        // If still empty, use provider ID
        if (empty($baseUsername)) {
            $baseUsername = strtolower($socialUser->getProvider()) . '_' . substr($socialUser->getId(), 0, 8);
        }

        // Ensure it matches regex: /^[a-zA-Z0-9_]{3,20}$/
        $username = preg_replace('/[^a-zA-Z0-9_]/', '', $baseUsername);

        // Ensure minimum length
        if (strlen($username) < 3) {
            $username .= Str::random(3 - strlen($username));
        }

        // Ensure maximum length
        if (strlen($username) > 20) {
            $username = substr($username, 0, 20);
        }

        // Check uniqueness
        $originalUsername = $username;
        $counter = 1;
        while (User::where('username', $username)->exists()) {
            $suffix = (string)$counter;
            $username = substr($originalUsername, 0, 20 - strlen($suffix)) . $suffix;
            $counter++;
        }

        return $username;
    }

    /**
     * Generate a unique email when provider doesn't supply one.
     */
    private function generateEmailFromSocialUser($provider, $socialUser): string
    {
        // Create a unique email based on provider and user ID
        $uniqueId = Str::slug(strtolower($socialUser->getProvider() . '_' . $socialUser->getId()));
        $email = $uniqueId . '@' . strtolower($provider) . '.social';

        // Ensure uniqueness
        $originalEmail = $email;
        $counter = 1;
        while (User::where('email', $email)->exists()) {
            $email = str_replace('@', "_$counter@", $originalEmail);
            $counter++;
        }

        return $email;
    }

    /**
     * Generate a display name from email when provider doesn't supply one.
     */
    private function generateNameFromEmail($email): string
    {
        // Extract name from email
        $name = str_replace(['.', '_', '-'], ' ', explode('@', $email)[0]);

        // Capitalize each word
        return ucwords($name);
    }
}
