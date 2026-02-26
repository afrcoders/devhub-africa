<?php

namespace App\Http\Controllers\Africoders\Admin;

use App\Http\Controllers\Controller;
use App\Models\Africoders\Page;
use App\Models\Africoders\Venture;
use App\Models\Africoders\PressRelease;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AfriccodersAdminController extends Controller
{
    /**
     * Show Africoders CMS dashboard.
     */
    public function dashboard(): View
    {
        return view('admin.africoders.dashboard', [
            'pagesCount' => Page::count(),
            'venturesCount' => Venture::count(),
            'pressCount' => PressRelease::count(),
            'publishedPagesCount' => Page::published()->count(),
            'publishedVenturesCount' => Venture::published()->count(),
            'recentPages' => Page::latest()->take(5)->get(),
            'recentVentures' => Venture::latest()->take(5)->get(),
            'recentPress' => PressRelease::latest()->take(5)->get(),
        ]);
    }

    // ========== PAGES MANAGEMENT ==========

    /**
     * List all pages.
     */
    public function pages(): View
    {
        $pages = Page::latest()->paginate(15);
        return view('admin.africoders.pages.index', ['pages' => $pages]);
    }

    /**
     * Show create page form.
     */
    public function createPage(): View
    {
        return view('admin.africoders.pages.create');
    }

    /**
     * Store new page.
     */
    public function storePage(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:africoders_pages',
            'slug' => 'nullable|string|unique:africoders_pages',
            'content' => 'required|string',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'featured_image' => 'nullable|string',
            'page_type' => 'required|in:custom,about,vision,mission,ecosystem',
            'published' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        if (!$validated['slug']) {
            $validated['slug'] = str()->slug($validated['title']);
        }

        if ($validated['published']) {
            $validated['published_at'] = $validated['published_at'] ?? now();
        }

        Page::create($validated);

        return redirect()->route('admin.africoders.pages.index')
            ->with('success', 'Page created successfully.');
    }

    /**
     * Show edit page form.
     */
    public function editPage(Page $page): View
    {
        return view('admin.africoders.pages.edit', ['page' => $page]);
    }

    /**
     * Update page.
     */
    public function updatePage(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:africoders_pages,title,' . $page->id,
            'slug' => 'nullable|string|unique:africoders_pages,slug,' . $page->id,
            'content' => 'required|string',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'featured_image' => 'nullable|string',
            'page_type' => 'required|in:custom,about,vision,mission,ecosystem',
            'published' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        if (!$validated['slug']) {
            $validated['slug'] = str()->slug($validated['title']);
        }

        if ($validated['published'] && !$page->published) {
            $validated['published_at'] = $validated['published_at'] ?? now();
        }

        $page->update($validated);

        return redirect()->route('admin.africoders.pages.index')
            ->with('success', 'Page updated successfully.');
    }

    /**
     * Delete page.
     */
    public function deletePage(Page $page)
    {
        $page->delete();
        return redirect()->route('admin.africoders.pages.index')
            ->with('success', 'Page deleted successfully.');
    }

    // ========== VENTURES MANAGEMENT ==========

    /**
     * List all ventures.
     */
    public function ventures(): View
    {
        $ventures = Venture::latest()->paginate(15);
        return view('admin.africoders.ventures.index', ['ventures' => $ventures]);
    }

    /**
     * Show create venture form.
     */
    public function createVenture(): View
    {
        return view('admin.africoders.ventures.create');
    }

    /**
     * Store new venture.
     */
    public function storeVenture(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:africoders_ventures',
            'description' => 'required|string|max:500',
            'content' => 'nullable|string',
            'logo' => 'nullable|string',
            'featured_image' => 'nullable|string',
            'website_url' => 'nullable|url',
            'mission' => 'nullable|string',
            'vision' => 'nullable|string',
            'status' => 'required|in:active,incubating,launched,exited',
            'launch_year' => 'nullable|integer|between:2000,2100',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'featured' => 'boolean',
            'published' => 'boolean',
            'published_at' => 'nullable|date',
            'order' => 'nullable|integer',
        ]);

        if (!$validated['slug']) {
            $validated['slug'] = str()->slug($validated['name']);
        }

        if ($validated['published']) {
            $validated['published_at'] = $validated['published_at'] ?? now();
        }

        Venture::create($validated);

        return redirect()->route('admin.africoders.ventures.index')
            ->with('success', 'Venture created successfully.');
    }

    /**
     * Show edit venture form.
     */
    public function editVenture(Venture $venture): View
    {
        return view('admin.africoders.ventures.edit', ['venture' => $venture]);
    }

    /**
     * Update venture.
     */
    public function updateVenture(Request $request, Venture $venture)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:africoders_ventures,slug,' . $venture->id,
            'description' => 'required|string|max:500',
            'content' => 'nullable|string',
            'logo' => 'nullable|string',
            'featured_image' => 'nullable|string',
            'website_url' => 'nullable|url',
            'mission' => 'nullable|string',
            'vision' => 'nullable|string',
            'status' => 'required|in:active,incubating,launched,exited',
            'launch_year' => 'nullable|integer|between:2000,2100',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'featured' => 'boolean',
            'published' => 'boolean',
            'published_at' => 'nullable|date',
            'order' => 'nullable|integer',
        ]);

        if (!$validated['slug']) {
            $validated['slug'] = str()->slug($validated['name']);
        }

        if ($validated['published'] && !$venture->published) {
            $validated['published_at'] = $validated['published_at'] ?? now();
        }

        $venture->update($validated);

        return redirect()->route('admin.africoders.ventures.index')
            ->with('success', 'Venture updated successfully.');
    }

    /**
     * Delete venture.
     */
    public function deleteVenture(Venture $venture)
    {
        $venture->delete();
        return redirect()->route('admin.africoders.ventures.index')
            ->with('success', 'Venture deleted successfully.');
    }

    // ========== PRESS RELEASES MANAGEMENT ==========

    /**
     * List all press releases.
     */
    public function press(): View
    {
        $releases = PressRelease::latest()->paginate(15);
        return view('admin.africoders.press.index', ['releases' => $releases]);
    }

    /**
     * Show create press release form.
     */
    public function createPress(): View
    {
        $ventures = Venture::published()->pluck('name', 'id');
        return view('admin.africoders.press.create', ['ventures' => $ventures]);
    }

    /**
     * Store new press release.
     */
    public function storePress(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:africoders_press_releases',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|string',
            'author' => 'nullable|string|max:255',
            'venture_id' => 'nullable|exists:africoders_ventures,id',
            'press_category' => 'required|in:announcement,award,partnership,funding,milestone',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'featured' => 'boolean',
            'published' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        if (!$validated['slug']) {
            $validated['slug'] = str()->slug($validated['title']);
        }

        if ($validated['published']) {
            $validated['published_at'] = $validated['published_at'] ?? now();
        }

        PressRelease::create($validated);

        return redirect()->route('admin.africoders.press.index')
            ->with('success', 'Press release created successfully.');
    }

    /**
     * Show edit press release form.
     */
    public function editPress(PressRelease $pressRelease): View
    {
        $ventures = Venture::published()->pluck('name', 'id');
        return view('admin.africoders.press.edit', ['release' => $pressRelease, 'ventures' => $ventures]);
    }

    /**
     * Update press release.
     */
    public function updatePress(Request $request, PressRelease $pressRelease)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:africoders_press_releases,title,' . $pressRelease->id,
            'slug' => 'nullable|string|unique:africoders_press_releases,slug,' . $pressRelease->id,
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|string',
            'author' => 'nullable|string|max:255',
            'venture_id' => 'nullable|exists:africoders_ventures,id',
            'press_category' => 'required|in:announcement,award,partnership,funding,milestone',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string|max:255',
            'featured' => 'boolean',
            'published' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        if (!$validated['slug']) {
            $validated['slug'] = str()->slug($validated['title']);
        }

        if ($validated['published'] && !$pressRelease->published) {
            $validated['published_at'] = $validated['published_at'] ?? now();
        }

        $pressRelease->update($validated);

        return redirect()->route('admin.africoders.press.index')
            ->with('success', 'Press release updated successfully.');
    }

    /**
     * Delete press release.
     */
    public function deletePress(PressRelease $pressRelease)
    {
        $pressRelease->delete();
        return redirect()->route('admin.africoders.press.index')
            ->with('success', 'Press release deleted successfully.');
    }
}
