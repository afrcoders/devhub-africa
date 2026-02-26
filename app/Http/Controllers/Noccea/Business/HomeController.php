<?php

namespace App\Http\Controllers\Noccea\Business;

use App\Http\Controllers\Controller;
use App\Models\Business\Business;
use App\Models\Business\BusinessCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get platform statistics
        $stats = [
            'total_businesses' => Business::active()->count(),
            'total_categories' => BusinessCategory::active()->count(),
            'featured_businesses' => Business::featured()->active()->count(),
            'total_reviews' => Business::active()->sum('reviews_count'),
        ];

        // Get featured businesses
        $featuredBusinesses = Business::with(['category', 'user'])
            ->featured()
            ->active()
            ->limit(6)
            ->latest()
            ->get();

        // Get recent businesses
        $recentBusinesses = Business::with(['category', 'user'])
            ->active()
            ->latest()
            ->limit(8)
            ->get();

        // Get top categories
        $topCategories = BusinessCategory::withCount(['businesses' => function ($query) {
            $query->active();
        }])
        ->active()
        ->orderBy('businesses_count', 'desc')
        ->limit(6)
        ->get();

        return view('noccea.business.home', compact(
            'stats',
            'featuredBusinesses',
            'recentBusinesses',
            'topCategories'
        ));
    }

    public function login(Request $request)
    {
        // Get return URL from query param or use the referrer (previous page)
        $returnUrl = $request->input('return') ?? url()->previous();

        // If previous URL is the login page itself, use home instead
        if ($returnUrl === $request->fullUrl() || str_contains($returnUrl, '/login')) {
            $returnUrl = route('noccea.business.home');
        }

        // Clean up the return URL to remove any nonce parameters
        $returnUrl = $this->cleanUrl($returnUrl);

        // Redirect to ID service login with return URL
        return redirect()->away('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
    }

    public function logout(Request $request)
    {
        // Always return to home page after logout
        $returnUrl = route('noccea.business.home');

        // Redirect to ID service logout with return URL
        return redirect()->away('https://' . config('domains.africoders.id') . '/logout?return=' . urlencode($returnUrl));
    }

    /**
     * Clean up URL by removing nonce parameters.
     */
    private function cleanUrl(string $url): string
    {
        $parsed = parse_url($url);
        $path = $parsed['path'] ?? '/';
        $scheme = $parsed['scheme'] ?? 'https';
        $host = $parsed['host'] ?? request()->getHost();

        // Reconstruct URL without query string (which may contain nonce)
        return $scheme . '://' . $host . $path;
    }

    public function dashboard()
    {
        // Check if user is authenticated, if not redirect to login
        if (!auth()->check()) {
            return $this->login(request());
        }

        $user = auth()->user();

        // Get user's businesses with categories
        $businesses = \App\Models\Business\Business::where('user_id', $user->id)
            ->with(['category'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $stats = [
            'total_businesses' => $businesses->total(),
            'active_businesses' => \App\Models\Business\Business::where('user_id', $user->id)->where('status', 'active')->count(),
            'pending_businesses' => \App\Models\Business\Business::where('user_id', $user->id)->where('status', 'pending')->count(),
            'total_views' => \App\Models\Business\Business::where('user_id', $user->id)->sum('views_count'),
        ];

        return view('noccea.business.dashboard', compact('businesses', 'stats'));
    }
}
