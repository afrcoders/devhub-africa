<?php

namespace App\Http\Controllers\Noccea\Business;

use App\Http\Controllers\Controller;
use App\Models\Business\Business;
use App\Models\Business\BusinessCategory;
use App\Models\Business\BusinessReview;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function index(Request $request)
    {
        $query = Business::with(['category', 'user'])
            ->active()
            ->latest();

        // Filter by category
        if ($request->category) {
            $category = BusinessCategory::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        // Search
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('description', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('city', 'LIKE', '%' . $request->search . '%');
            });
        }

        // Sort
        switch ($request->sort) {
            case 'name':
                $query->orderBy('name');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'views':
                $query->orderBy('views_count', 'desc');
                break;
            case 'featured':
                $query->featured()->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $businesses = $query->paginate(12);
        $categories = BusinessCategory::active()->ordered()->get();

        return view('noccea.business.businesses.index', compact('businesses', 'categories'));
    }

    public function show(Business $business)
    {
        $business->load(['category', 'user', 'reviews.user']);
        $business->incrementViews();

        $relatedBusinesses = Business::where('category_id', $business->category_id)
            ->where('id', '!=', $business->id)
            ->active()
            ->limit(4)
            ->get();

        return view('noccea.business.businesses.show', compact('business', 'relatedBusinesses'));
    }

    public function create()
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            $returnUrl = request()->fullUrl();
            return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
        }

        $categories = BusinessCategory::active()->ordered()->get();
        return view('noccea.business.businesses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            $returnUrl = route('noccea.business.businesses.create');
            return redirect('https://' . config('domains.africoders.id') . '/auth?return=' . urlencode($returnUrl));
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'category_id' => 'required|exists:business_categories,id',
            'website' => 'nullable|url|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'city' => 'required|string|max:100',
            'country' => 'required|string|max:100',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';

        $business = Business::create($validated);

        return redirect()->route('noccea.business.businesses.show', $business)
            ->with('success', 'Business listing submitted for review!');
    }

    public function featured()
    {
        $businesses = Business::with(['category', 'user'])
            ->featured()
            ->active()
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('noccea.business.businesses.featured', compact('businesses'));
    }

    /**
     * Show user's bookmarked businesses
     */
    public function bookmarksIndex()
    {
        $bookmarkedBusinesses = auth()->user()
            ->bookmarkedBusinesses()
            ->with(['category', 'user', 'reviews'])
            ->withCount('reviews')
            ->orderBy('business_bookmarks.created_at', 'desc')
            ->paginate(12);

        return view('noccea.business.bookmarks.index', compact('bookmarkedBusinesses'));
    }

    /**
     * Add business to bookmarks
     */
    public function bookmark(Business $business)
    {
        $user = auth()->user();

        if (!$user->bookmarkedBusinesses()->where('business_id', $business->id)->exists()) {
            $user->bookmarkedBusinesses()->attach($business);
            return back()->with('success', 'Business bookmarked successfully!');
        }

        return back()->with('info', 'Business is already bookmarked.');
    }

    /**
     * Remove business from bookmarks
     */
    public function unbookmark(Business $business)
    {
        $user = auth()->user();

        $user->bookmarkedBusinesses()->detach($business);

        return back()->with('success', 'Business removed from bookmarks.');
    }

    /**
     * Store a review for a business
     */
    public function storeReview(Request $request, Business $business)
    {
        $user = auth()->user();

        // Check if user can review this business
        if (!$business->canBeReviewedBy($user)) {
            return back()->with('error', 'You cannot review this business.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ]);

        $validated['user_id'] = $user->id;
        $validated['is_approved'] = true; // Auto-approve for now

        $business->reviews()->create($validated);

        return back()->with('success', 'Review submitted successfully!');
    }

    /**
     * Update a review
     */
    public function updateReview(Request $request, BusinessReview $review)
    {
        $user = auth()->user();

        // Check if user can edit this review (owner or admin)
        if ($review->user_id !== $user->id && !$user->is_admin) {
            return back()->with('error', 'You cannot edit this review.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ]);

        $review->update($validated);

        return back()->with('success', 'Review updated successfully!');
    }

    /**
     * Delete a review
     */
    public function deleteReview(BusinessReview $review)
    {
        $user = auth()->user();

        // Check if user can delete this review (owner or admin)
        if ($review->user_id !== $user->id && !$user->is_admin) {
            return back()->with('error', 'You cannot delete this review.');
        }

        $review->delete();

        return back()->with('success', 'Review deleted successfully!');
    }
}
