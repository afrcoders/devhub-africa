<?php

namespace App\Http\Controllers\Africoders\Public;

use App\Http\Controllers\Controller;
use App\Models\Africoders\Page;
use App\Models\Africoders\Venture;
use App\Models\Africoders\PressRelease;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Show the Africoders home page.
     */
    public function home(): View
    {
        // Get platform statistics
        $stats = [
            'total_ventures' => Venture::count(),
            'total_users' => \App\Models\User::count(),
            'total_courses' => \App\Models\Noccea\Learn\Course::count(),
            'total_businesses' => \DB::table('businesses')->count(),
            'total_discussions' => \App\Models\Community\Discussion::count(),
        ];

        // Get featured ventures
        $featuredVentures = Venture::published()
            ->when(Venture::where('featured', true)->exists(), function($query) {
                return $query->where('featured', true);
            })
            ->orderBy('order')
            ->take(3)
            ->get();

        // Get recent press releases
        $recentPress = PressRelease::published()
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        // Get top courses from Learn platform
        $topCourses = \App\Models\Noccea\Learn\Course::with(['modules.lessons'])
            ->withCount('enrollments')
            ->orderByDesc('enrollments_count')
            ->take(3)
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

        // Get top community discussions
        $topDiscussions = \App\Models\Community\Discussion::with(['user', 'replies', 'category'])
            ->withCount('replies')
            ->orderByDesc('replies_count')
            ->orderByDesc('last_activity_at')
            ->take(4)
            ->get();

        // Get featured businesses (when businesses table exists and has data)
        $featuredBusinesses = collect(); // Empty for now
        if (\Schema::hasTable('businesses') && \DB::table('businesses')->count() > 0) {
            // Will be populated when business listings are added
        }

        // Get ecosystem products/platforms
        $ecosystemProducts = [
            [
                'name' => 'Noccea Learn',
                'description' => 'Professional learning platform with expert-led courses',
                'icon' => 'book',
                'url' => 'https://' . config('domains.noccea.learn'),
                'stats' => \App\Models\Noccea\Learn\Course::count() . ' courses',
            ],
            [
                'name' => 'Noccea Business',
                'description' => 'Business directory and marketplace platform',
                'icon' => 'building',
                'url' => 'https://' . config('domains.noccea.business'),
                'stats' => \DB::table('businesses')->count() . ' businesses',
            ],
            [
                'name' => 'Noccea Community',
                'description' => 'Professional community and discussion forums',
                'icon' => 'people',
                'url' => 'https://' . config('domains.noccea.community'),
                'stats' => \App\Models\User::count() . ' members',
            ],
            [
                'name' => 'Kortex Tools',
                'description' => 'Developer tools and utilities suite',
                'icon' => 'tools',
                'url' => 'https://' . config('domains.africoders.kortex'),
                'stats' => 'Dev Suite',
            ],
        ];

        return view('africoders.public.home', [
            'stats' => $stats,
            'featuredVentures' => $featuredVentures,
            'recentPress' => $recentPress,
            'ecosystemProducts' => $ecosystemProducts,
            'topCourses' => $topCourses,
            'topDiscussions' => $topDiscussions,
            'featuredBusinesses' => $featuredBusinesses,
        ]);
    }

    /**
     * Show a corporate page (about, vision, mission, etc).
     */
    public function showPage($page = null): View
    {
        // If no page parameter provided, try to get from route
        if (!$page) {
            // This shouldn't happen with proper routing, but as a fallback
            abort(404);
        }

        // Get the page by slug from the URL parameter
        $pageModel = Page::where('slug', $page)->published()->first();

        if (!$pageModel) {
            abort(404);
        }

        return view('africoders.public.page', [
            'page' => $pageModel,
        ]);
    }

    /**
     * Show all ventures/portfolio.
     */
    public function ventures(): View
    {
        $ventures = Venture::published()
            ->orderBy('order')
            ->orderByDesc('published_at')
            ->paginate(12);

        return view('africoders.public.ventures.index', [
            'ventures' => $ventures,
        ]);
    }

    /**
     * Show individual venture detail.
     */
    public function showVenture(Venture $venture): View
    {
        if (!$venture->published) {
            abort(404);
        }

        $relatedVentures = Venture::published()
            ->where('id', '!=', $venture->id)
            ->limit(3)
            ->get();

        return view('africoders.public.ventures.show', [
            'venture' => $venture,
            'relatedVentures' => $relatedVentures,
        ]);
    }

    /**
     * Show ecosystem/product explanation.
     */
    public function ecosystem(): View
    {
        $page = Page::where('page_type', 'ecosystem')->published()->first()
            ?? Page::where('slug', 'ecosystem')->published()->first();

        return view('africoders.public.ecosystem', [
            'page' => $page,
        ]);
    }

    /**
     * Show press/announcements.
     */
    public function press(): View
    {
        $pressReleases = PressRelease::published()
            ->orderByDesc('published_at')
            ->paginate(12);

        return view('africoders.public.press.index', [
            'releases' => $pressReleases,
        ]);
    }

    /**
     * Show individual press release.
     */
    public function showPressRelease(PressRelease $pressRelease): View
    {
        if (!$pressRelease->published) {
            abort(404);
        }

        $relatedReleases = PressRelease::published()
            ->where('id', '!=', $pressRelease->id)
            ->limit(3)
            ->get();

        return view('africoders.public.press.show', [
            'release' => $pressRelease,
            'relatedReleases' => $relatedReleases,
        ]);
    }

    /**
     * Show contact/partnership inquiry form (integrated with help system).
     */
    public function contact(): View
    {
        return view('africoders.public.contact');
    }

    /**
     * Submit contact/partnership inquiry.
     */
    public function submitContact()
    {
        $validated = request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'inquiry_type' => 'required|in:partnership,investment,collaboration,support',
            'message' => 'required|string|min:10',
        ]);

        // Save to help system contact messages
        $contactMessage = \App\Models\Help\ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['inquiry_type'],
            'message' => $validated['message'],
            'metadata' => ['company' => $validated['company'] ?? null, 'inquiry_type' => $validated['inquiry_type']],
            'read' => false,
        ]);

        return redirect()->route('africoders.contact.success')
            ->with('success', 'Thank you for your inquiry. We will get back to you soon.');
    }

    /**
     * Show contact success page.
     */
    public function contactSuccess(): View
    {
        return view('africoders.public.contact-success');
    }
}
