<?php

namespace App\Http\Controllers\Africoders\Admin\Kortextools;

use App\Http\Controllers\Controller;
use App\Models\ToolRating;
use App\Services\Kortextools\ToolService;

class DashboardController extends Controller
{
    protected $toolService;

    public function __construct(ToolService $toolService)
    {
        $this->toolService = $toolService;
    }

    /**
     * Show KortexTools admin dashboard
     */
    public function index()
    {
        // Get statistics
        $allTools = $this->toolService->getFlatToolsList();
        $totalTools = count($allTools);
        $totalCategories = count($this->toolService->getCategories());
        $totalRatings = ToolRating::count();

        $avgRating = ToolRating::avg('rating') ?? 0;

        // Get top tools
        $topTools = ToolRating::selectRaw('tool_slug, AVG(rating) as avg_rating, COUNT(*) as total_ratings')
            ->groupBy('tool_slug')
            ->orderByRaw('avg_rating DESC')
            ->take(10)
            ->get();

        // Get recent ratings
        $recentRatings = ToolRating::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.kortextools.dashboard', compact(
            'totalTools',
            'totalCategories',
            'totalRatings',
            'avgRating',
            'topTools',
            'recentRatings'
        ));
    }
}
