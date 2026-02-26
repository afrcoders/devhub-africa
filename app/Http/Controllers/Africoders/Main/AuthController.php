<?php

namespace App\Http\Controllers\Africoders\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Redirect to ID service for login.
     * Uses the referrer or provided return URL to bring user back to where they started.
     */
    public function login(Request $request): RedirectResponse
    {
        // Get return URL from query param or use the referrer (previous page)
        $returnUrl = $request->input('return') ?? url()->previous();

        // If previous URL is the login page itself, use home instead
        if ($returnUrl === $request->fullUrl() || str_contains($returnUrl, '/login')) {
            $returnUrl = route('africoders.home');
        }

        // Clean up the return URL to remove any nonce parameters
        $returnUrl = $this->cleanUrl($returnUrl);

        // Redirect to ID service login with return URL
        return redirect()->away('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
    }

    /**
     * Redirect to ID service for logout.
     * Always redirects back to home page after logout.
     */
    public function logout(Request $request): RedirectResponse
    {
        // Always return to home page after logout
        $returnUrl = route('africoders.home');

        // Redirect to ID service logout with return URL
        return redirect()->away('https://' . config('domains.africoders.id') . '/logout?return=' . urlencode($returnUrl));
    }

    /**
     * Clean up URL by removing nonce parameters.
     */
    private function cleanUrl(string $url): string
    {
        $parsed = parse_url($url);
        $cleanUrl = ($parsed['scheme'] ?? 'https') . '://' . $parsed['host'];

        if (isset($parsed['path'])) {
            $cleanUrl .= $parsed['path'];
        }

        if (isset($parsed['query'])) {
            parse_str($parsed['query'], $params);
            unset($params['auth_nonce'], $params['logout_nonce']);

            if (!empty($params)) {
                $cleanUrl .= '?' . http_build_query($params);
            }
        }

        return $cleanUrl;
    }
}
