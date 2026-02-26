<?php

namespace App\Jobs;

use App\Models\Noccea\Learn\CourseEnrollment;
use App\Models\Noccea\Learn\LessonCompletion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateLessonCompletion implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Get random enrollment with incomplete lessons
        $enrollment = CourseEnrollment::with(['course.modules.lessons'])
            ->where('progress_percentage', '<', 100)
            ->inRandomOrder()
            ->first();

        if (!$enrollment) {
            \Log::info('No enrollments with incomplete lessons found');
            return;
        }

        // Get all lessons for the course
        $allLessons = collect();
        foreach ($enrollment->course->modules as $module) {
            $allLessons = $allLessons->merge($module->lessons);
        }

        // Get already completed lesson IDs
        $completedLessonIds = LessonCompletion::where('user_id', $enrollment->user_id)
            ->whereIn('lesson_id', $allLessons->pluck('id'))
            ->pluck('lesson_id');

        // Get next incomplete lesson
        $nextLesson = $allLessons->whereNotIn('id', $completedLessonIds)->first();

        if (!$nextLesson) {
            // All lessons completed
            $enrollment->update(['progress_percentage' => 100, 'completed_at' => now()]);
            \Log::info('Course fully completed', ['enrollment_id' => $enrollment->id]);
            return;
        }

        // Mark lesson as complete
        LessonCompletion::create([
            'user_id' => $enrollment->user_id,
            'lesson_id' => $nextLesson->id,
            'completed_at' => now(),
        ]);

        // Update enrollment progress
        $completedCount = $completedLessonIds->count() + 1;
        $totalLessons = $allLessons->count();
        $progress = $totalLessons > 0 ? round(($completedCount / $totalLessons) * 100) : 0;

        $enrollment->update(['progress_percentage' => $progress]);

        \Log::info('Generated lesson completion', [
            'user_id' => $enrollment->user_id,
            'lesson' => $nextLesson->title,
            'progress' => $progress . '%'
        ]);
    }
}
