<?php

namespace App\Http\Controllers\Noccea\Learn;

use App\Http\Controllers\Controller;
use App\Models\Noccea\Learn\CourseLesson;
use App\Models\Noccea\Learn\LessonCompletion;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function show($courseSlug, $moduleName, $lessonId)
    {
        $lesson = CourseLesson::with('module.course')->findOrFail($lessonId);

        $course = $lesson->module->course;
        if ($course->slug !== $courseSlug) {
            abort(404);
        }

        // Check if user is enrolled
        if (auth()->check()) {
            $isEnrolled = $course->enrollments()
                ->where('user_id', auth()->id())
                ->exists();
        } else {
            $isEnrolled = false;
        }

        if (!$isEnrolled) {
            return redirect()->route('noccea.learn.course-detail', $courseSlug)
                ->with('message', 'Please enroll to view lessons');
        }

        $module = $lesson->module;
        $lessons = $module->lessons;

        // Find next lesson
        $nextLesson = null;
        $currentLessonIndex = $lessons->search(fn($l) => $l->id === $lesson->id);

        if ($currentLessonIndex !== false && $currentLessonIndex < $lessons->count() - 1) {
            // Next lesson in same module
            $nextLesson = $lessons[$currentLessonIndex + 1];
        } else {
            // Try to find next module
            $modules = $course->modules()->orderBy('order')->get();
            $currentModuleIndex = $modules->search(fn($m) => $m->id === $module->id);

            if ($currentModuleIndex !== false && $currentModuleIndex < $modules->count() - 1) {
                $nextModule = $modules[$currentModuleIndex + 1];
                $nextLesson = $nextModule->lessons()->orderBy('order')->first();
            }
        }

        return view('noccea.learn.lesson', compact('course', 'module', 'lesson', 'lessons', 'nextLesson'));
    }

    public function markComplete(Request $request, $lessonId)
    {
        $lesson = CourseLesson::findOrFail($lessonId);
        $userId = auth()->id();

        // Check if user is enrolled in the course
        $course = $lesson->module->course;
        $isEnrolled = $course->enrollments()
            ->where('user_id', $userId)
            ->exists();

        if (!$isEnrolled) {
            return response()->json(['error' => 'Not enrolled in this course'], 403);
        }

        // Create or update lesson completion
        LessonCompletion::updateOrCreate(
            ['user_id' => $userId, 'lesson_id' => $lessonId],
            ['completed_at' => now()]
        );

        // Update course enrollment progress
        $totalLessons = $course->modules()
            ->with('lessons')
            ->get()
            ->flatMap->lessons
            ->count();

        $completedLessons = LessonCompletion::whereIn(
            'lesson_id',
            $course->modules()
                ->with('lessons')
                ->get()
                ->flatMap->lessons
                ->pluck('id')
        )
            ->where('user_id', $userId)
            ->count();

        $progress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;

        $course->enrollments()
            ->where('user_id', $userId)
            ->update(['progress_percentage' => $progress]);

        // Check if course is complete
        if ($completedLessons === $totalLessons) {
            $course->enrollments()
                ->where('user_id', $userId)
                ->update(['completed_at' => now()]);
        }

        // Find next lesson
        $nextLessonUrl = null;
        $module = $lesson->module;
        $lessons = $module->lessons()->orderBy('order')->get();
        $currentLessonIndex = $lessons->search(fn($l) => $l->id === $lesson->id);

        if ($currentLessonIndex !== false && $currentLessonIndex < $lessons->count() - 1) {
            // Next lesson in same module
            $nextLesson = $lessons[$currentLessonIndex + 1];
            $nextLessonUrl = route('noccea.learn.lesson.show', [
                $course->slug,
                $module->title,
                $nextLesson->id
            ]);
        } else {
            // Try to find next module
            $modules = $course->modules()->orderBy('order')->get();
            $currentModuleIndex = $modules->search(fn($m) => $m->id === $module->id);

            if ($currentModuleIndex !== false && $currentModuleIndex < $modules->count() - 1) {
                $nextModule = $modules[$currentModuleIndex + 1];
                $nextLesson = $nextModule->lessons()->orderBy('order')->first();
                if ($nextLesson) {
                    $nextLessonUrl = route('noccea.learn.lesson.show', [
                        $course->slug,
                        $nextModule->title,
                        $nextLesson->id
                    ]);
                }
            }
        }

        return response()->json([
            'message' => 'Lesson marked as complete',
            'progress' => $progress,
            'nextLessonUrl' => $nextLessonUrl,
            'courseCompleted' => $completedLessons === $totalLessons
        ]);
    }
}
