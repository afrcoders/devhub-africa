<?php

namespace App\Http\Controllers\Noccea\Community;

use App\Http\Controllers\Controller;
use App\Models\Community\DiscussionCategory;
use App\Models\Community\Discussion;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = DiscussionCategory::ordered()
            ->withCount('discussions')
            ->get();

        return view('noccea.community.categories.index', compact('categories'));
    }

    public function show(DiscussionCategory $category, Request $request)
    {
        $query = $category->discussions()
            ->with('user', 'category')
            ->withCount('replies');

        // Search within category
        if ($request->search) {
            $query->whereRaw(
                "MATCH(title, body) AGAINST(? IN BOOLEAN MODE)",
                [$request->search]
            );
        }

        // Sort
        switch ($request->sort) {
            case 'popular':
                $query->popular();
                break;
            case 'oldest':
                $query->orderBy('created_at');
                break;
            default:
                // Show all discussions, pinned first, then by recent activity
                $query->orderBy('is_pinned', 'desc')
                      ->orderBy('last_activity_at', 'desc');
                break;
        }

        $discussions = $query->paginate(20);

        return view('noccea.community.categories.show', compact('category', 'discussions'));
    }
}
