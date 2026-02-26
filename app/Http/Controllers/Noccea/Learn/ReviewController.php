<?php

namespace App\Http\Controllers\Noccea\Learn;

use App\Http\Controllers\Controller;
use App\Models\Noccea\Learn\Course;
use App\Models\Noccea\Learn\CourseReview;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $courseId)
    {
        $course = Course::findOrFail($courseId);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        // Check if user has already reviewed this course
        $existingReview = CourseReview::where('user_id', auth()->id())
            ->where('course_id', $courseId)
            ->first();

        if ($existingReview) {
            $existingReview->update($validated);
            return redirect()->back()->with('success', 'Review updated successfully');
        }

        CourseReview::create([
            'user_id' => auth()->id(),
            'course_id' => $courseId,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return redirect()->back()->with('success', 'Review submitted successfully');
    }

    public function update(Request $request, CourseReview $review)
    {
        if ($review->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        $review->update($validated);

        return redirect()->back()->with('success', 'Review updated successfully');
    }

    public function destroy(CourseReview $review)
    {
        if ($review->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403);
        }

        $review->delete();

        return redirect()->back()->with('success', 'Review deleted successfully');
    }
}
