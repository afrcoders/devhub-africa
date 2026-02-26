<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Contracts\Factory;
use Illuminate\Support\Facades\Http;

// Custom LinkedIn Provider that uses OpenID Connect /userinfo endpoint
class LinkedInProviderCustom extends \Laravel\Socialite\Two\LinkedInProvider
{
    /**
     * The scopes being requested.
     *
     * @var array
     */
    protected $scopes = ['openid', 'profile', 'email'];

    /**
     * Get the raw user array.
     *
     * @param  string  $accessToken
     * @return array
     */
    protected function getUserByToken($accessToken)
    {
        // Use the new OpenID Connect /userinfo endpoint instead of deprecated /v2/me
        $response = Http::withToken($accessToken)
            ->get('https://api.linkedin.com/v2/userinfo');

        return $response->json();
    }

    /**
     * Map the raw user array to a Socialite User.
     *
     * @param  array  $user
     * @return \Laravel\Socialite\Two\User
     */
    protected function mapUserToObject(array $user)
    {
        return (new \Laravel\Socialite\Two\User())->setRaw($user)->map([
            'id' => $user['sub'] ?? null,
            'nickname' => $user['given_name'] ?? null,
            'name' => trim(($user['given_name'] ?? '') . ' ' . ($user['family_name'] ?? '')),
            'email' => $user['email'] ?? null,
            'avatar' => $user['picture'] ?? null,
        ]);
    }
}

class CustomLinkedInProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(Factory $socialite): void
    {
        // Override LinkedIn provider with custom scopes and userinfo endpoint
        $socialite->extend('linkedin', function ($app) {
            $config = $app['config']['services.linkedin'];

            $provider = new LinkedInProviderCustom(
                $app['request'],
                $config['client_id'],
                $config['client_secret'],
                $config['redirect'],
            );

            return $provider;
        });
    }
}
