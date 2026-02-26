<?php

namespace App\Http\Controllers\Africoders\Admin\Kortextools;

use App\Http\Controllers\Controller;
use App\Models\ToolRating;
use Illuminate\Http\Request;

class ToolRatingsController extends Controller
{
    /**
     * Show tool ratings dashboard
     */
    public function index()
    {
        $ratings = ToolRating::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        $topRated = ToolRating::selectRaw('tool_slug, AVG(rating) as avg_rating, COUNT(*) as total_ratings')
            ->groupBy('tool_slug')
            ->orderByRaw('avg_rating DESC')
            ->take(10)
            ->get();

        return view('admin.kortextools.ratings.index', compact('ratings', 'topRated'));
    }

    /**
     * Show ratings for a specific tool
     */
    public function showTool($slug)
    {
        $ratings = ToolRating::where('tool_slug', $slug)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        $avgRating = ToolRating::where('tool_slug', $slug)->avg('rating');
        $totalRatings = ToolRating::where('tool_slug', $slug)->count();

        return view('admin.kortextools.ratings.tool', compact(
            'slug',
            'ratings',
            'avgRating',
            'totalRatings'
        ));
    }

    /**
     * Delete a rating
     */
    public function destroy($id)
    {
        $rating = ToolRating::findOrFail($id);
        $rating->delete();

        return redirect()->back()
            ->with('success', 'Rating deleted successfully');
    }
}
