<?php

namespace App\Http\Controllers\Noccea\Community;

use App\Http\Controllers\Controller;
use App\Models\Community\Discussion;
use App\Models\Community\DiscussionCategory;
use App\Models\User;
use App\Models\Community\DiscussionReply;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get recent discussions (last 7 days)
        $recentDiscussions = Discussion::with(['category', 'user', 'replies'])
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // Get popular discussions (most replies in last 30 days)
        $popularDiscussions = Discussion::with(['category', 'user'])
            ->withCount(['replies' => function ($query) {
                $query->where('created_at', '>=', Carbon::now()->subDays(30));
            }])
            ->having('replies_count', '>', 0)
            ->orderBy('replies_count', 'desc')
            ->take(5)
            ->get();

        // Get active categories with recent activity
        $activeCategories = DiscussionCategory::with(['discussions' => function ($query) {
            $query->latest()->take(3);
        }])
            ->withCount(['discussions'])
            ->having('discussions_count', '>', 0)
            ->orderBy('replies_count', 'desc')
            ->take(8)
            ->get();

        // Get community stats
        $stats = [
            'total_members' => User::where('is_active', true)->count(),
            'total_discussions' => Discussion::count(),
            'total_replies' => DiscussionReply::count(),
            'active_today' => Discussion::where('created_at', '>=', Carbon::today())->count() +
                            DiscussionReply::where('created_at', '>=', Carbon::today())->count(),
        ];

        // Get recent active members (posted in last 7 days)
        $activeMembers = User::whereHas('discussions', function ($query) {
            $query->where('created_at', '>=', Carbon::now()->subDays(7));
        })
        ->orWhereHas('discussionReplies', function ($query) {
            $query->where('created_at', '>=', Carbon::now()->subDays(7));
        })
        ->withCount(['discussions', 'discussionReplies'])
        ->orderBy('discussions_count', 'desc')
        ->orderBy('discussion_replies_count', 'desc')
        ->take(6)
        ->get();

        return view('noccea.community.home', compact(
            'recentDiscussions',
            'popularDiscussions',
            'activeCategories',
            'stats',
            'activeMembers'
        ));
    }

    public function login(Request $request)
    {
        // Get return URL from query param or use the referrer (previous page)
        $returnUrl = $request->input('return') ?? url()->previous();

        // If previous URL is the login page itself, use home instead
        if ($returnUrl === $request->fullUrl() || str_contains($returnUrl, '/login')) {
            $returnUrl = route('noccea.community.home');
        }

        // Clean up the return URL to remove any nonce parameters
        $returnUrl = $this->cleanUrl($returnUrl);

        // Redirect to ID service login with return URL
        return redirect()->away('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
    }

    public function logout(Request $request)
    {
        // Always return to home page after logout
        $returnUrl = route('noccea.community.home');

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
        return view('noccea.community.dashboard');
    }
}
