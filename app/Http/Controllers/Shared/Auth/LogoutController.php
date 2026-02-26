<?php

namespace App\Http\Controllers\Shared\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Cookie;

class LogoutController extends Controller
{
    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        $user = auth()->user();

        if ($user) {
            \App\Models\AuditLog::create([
                'user_id' => $user->id,
                'action' => 'logout',
                'details' => 'User logged out',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }

        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Determine parent domain for cookie clearing
        $host = $request->getHost();
        $parentDomain = '.test';
        if (preg_match('/\.africoders\.(test|com)$/', $host, $m)) {
            $parentDomain = '.africoders.' . $m[1];
        } elseif (preg_match('/\.noccea\.(test|com)$/', $host, $m)) {
            $parentDomain = '.noccea.' . $m[1];
        } elseif (preg_match('/\.kortextools\.(test|com)$/', $host, $m)) {
            $parentDomain = '.kortextools.' . $m[1];
        }

        // Clear JWT cookie for cross-domain logout
        $clearTokenCookie = Cookie::create('auth_token')
            ->withValue('')
            ->withExpires(time() - 3600) // Expire in the past
            ->withPath('/')
            ->withDomain($parentDomain)
            ->withHttpOnly(true)
            ->withSecure(config('app.env') === 'production')
            ->withSameSite('Lax');

        // Check for return URL
        $returnUrl = $request->input('return');
        if ($returnUrl && filter_var($returnUrl, FILTER_VALIDATE_URL)) {
            // Only allow returns to our trusted domains
            $trustedDomains = config('domains.trusted_domains', []);
            $parsedUrl = parse_url($returnUrl);
            $isAllowed = false;

            if (isset($parsedUrl['host'])) {
                foreach ($trustedDomains as $domain) {
                    if (str_ends_with($parsedUrl['host'], $domain)) {
                        $isAllowed = true;
                        break;
                    }
                }
            }

            if ($isAllowed) {
                return redirect($returnUrl)->withCookie($clearTokenCookie);
            }
        }

        return redirect()->route('id.auth.unified')->withCookie($clearTokenCookie);
    }
}
