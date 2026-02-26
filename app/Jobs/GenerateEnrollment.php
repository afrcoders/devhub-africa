<?php

namespace App\Jobs;

use App\Models\Noccea\Learn\Course;
use App\Models\Noccea\Learn\CourseEnrollment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateEnrollment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Get random course
        $course = Course::inRandomOrder()->first();
        if (!$course) {
            \Log::warning('No courses found');
            return;
        }

        // Get random user not already enrolled
        $user = User::where('is_active', true)
            ->whereDoesntHave('enrollments', function($query) use ($course) {
                $query->where('course_id', $course->id);
            })
            ->inRandomOrder()
            ->first();

        if (!$user) {
            \Log::info('No unenrolled users available for course', ['course' => $course->title]);
            return;
        }

        // Create enrollment
        CourseEnrollment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'enrolled_at' => now(),
            'progress_percentage' => 0,
        ]);

        \Log::info('Generated enrollment', [
            'user_id' => $user->id,
            'course' => $course->title
        ]);
    }
}
