<?php

namespace App\Http\Controllers\Noccea\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get platform statistics
        $stats = [
            'total_courses' => \App\Models\Noccea\Learn\Course::count(),
            'total_users' => \App\Models\User::count(),
            'total_discussions' => \App\Models\Community\Discussion::count(),
            'total_businesses' => \DB::table('businesses')->count(),
        ];

        // Get featured courses from Learn platform
        $featuredCourses = \App\Models\Noccea\Learn\Course::with(['modules.lessons'])
            ->withCount('enrollments')
            ->orderByDesc('enrollments_count')
            ->take(6)
            ->get()
            ->map(function($course) {
                $totalLessons = 0;
                foreach ($course->modules as $module) {
                    $totalLessons += $module->lessons->count();
                }
                $course->total_lessons = $totalLessons;
                $course->students_count = $course->enrollments_count;
                return $course;
            });

        // Get recent community discussions
        $recentDiscussions = \App\Models\Community\Discussion::with(['user', 'replies', 'category'])
            ->withCount('replies')
            ->orderByDesc('last_activity_at')
            ->take(5)
            ->get();

        // Get featured businesses (when available)
        $featuredBusinesses = collect();
        if (\Schema::hasTable('businesses') && \DB::table('businesses')->count() > 0) {
            // Will be populated when business listings are added
        }

        return view('noccea.main.home', [
            'stats' => $stats,
            'featuredCourses' => $featuredCourses,
            'recentDiscussions' => $recentDiscussions,
            'featuredBusinesses' => $featuredBusinesses,
        ]);
    }

    public function login(Request $request)
    {
        // Get return URL from query param or use the referrer (previous page)
        $returnUrl = $request->input('return') ?? url()->previous();

        // If previous URL is the login page itself, use home instead
        if ($returnUrl === $request->fullUrl() || str_contains($returnUrl, '/login')) {
            $returnUrl = route('noccea.main.home');
        }

        // Clean up the return URL to remove any nonce parameters
        $returnUrl = $this->cleanUrl($returnUrl);

        // Redirect to ID service login with return URL
        return redirect()->away('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
    }

    public function logout(Request $request)
    {
        // Always return to home page after logout
        $returnUrl = route('noccea.main.home');

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
        return view('noccea.main.dashboard');
    }
}
