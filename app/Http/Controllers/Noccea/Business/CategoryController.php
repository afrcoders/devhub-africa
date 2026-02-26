<?php

namespace App\Http\Controllers\Noccea\Business;

use App\Http\Controllers\Controller;
use App\Models\Business\Business;
use App\Models\Business\BusinessCategory;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = BusinessCategory::active()
            ->withCount(['businesses' => function($query) {
                $query->active();
            }])
            ->ordered()
            ->get();

        $totalBusinesses = Business::active()->count();
        $activeBusinesses = Business::active()->count();

        return view('noccea.business.categories.index', compact('categories', 'totalBusinesses', 'activeBusinesses'));
    }

    public function show(BusinessCategory $category)
    {
        $query = Business::with(['category', 'user'])
            ->where('category_id', $category->id)
            ->active()
            ->latest();

        // Search
        if (request('search')) {
            $query->where(function ($q) {
                $q->where('name', 'LIKE', '%' . request('search') . '%')
                  ->orWhere('description', 'LIKE', '%' . request('search') . '%')
                  ->orWhere('city', 'LIKE', '%' . request('search') . '%');
            });
        }

        // Sort
        switch (request('sort')) {
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
        }

        $businesses = $query->paginate(12);

        // Get related categories (same parent or similar)
        $relatedCategories = BusinessCategory::active()
            ->where('id', '!=', $category->id)
            ->withCount(['businesses' => function($query) {
                $query->active();
            }])
            ->ordered()
            ->limit(4)
            ->get();

        return view('noccea.business.categories.show', compact('category', 'businesses', 'relatedCategories'));
    }
}
