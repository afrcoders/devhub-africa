<?php

namespace App\Http\Controllers\Africoders\Kortextools;

use App\Http\Controllers\Controller;
use App\Models\ToolRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ToolRatingController extends Controller
{
    /**
     * Rate a tool (1-5 stars)
     */
    public function rateTool(Request $request, $slug)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
        ]);

        // Only authenticated users can rate
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to rate tools',
            ], 401);
        }

        ToolRating::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'tool_slug' => $slug,
            ],
            [
                'rating' => $request->rating,
            ]
        );

        // Calculate new average rating
        $rates = $this->getToolRatings($slug);
        $newRating = $rates['avg'];
        $ratingCount = $rates['total'];

        return response()->json([
            'success' => true,
            'newRating' => round($newRating, 1),
            'ratingCount' => $ratingCount,
        ]);
    }

    /**
     * Get tool ratings
     */
    protected function getToolRatings($slug)
    {
        $ratings = ToolRating::where('tool_slug', $slug)->get();

        if ($ratings->isEmpty()) {
            return [
                'avg' => 0,
                'total' => 0,
            ];
        }

        return [
            'avg' => $ratings->avg('rating'),
            'total' => $ratings->count(),
        ];
    }
}
