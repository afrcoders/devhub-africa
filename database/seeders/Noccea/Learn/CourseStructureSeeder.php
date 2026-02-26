<?php

namespace Database\Seeders\Noccea\Learn;

use App\Models\Noccea\Learn\Course;
use App\Models\Noccea\Learn\CourseModule;
use App\Models\Noccea\Learn\CourseLesson;
use Illuminate\Database\Seeder;

class CourseStructureSeeder extends Seeder
{
    public function run(): void
    {
        $coursesData = [
            ['title' => 'Advanced Web Development with React', 'modules' => 3],
            ['title' => 'Full Stack Web Development Bootcamp', 'modules' => 4],
            ['title' => 'Mobile App Development with Flutter', 'modules' => 4],
            ['title' => 'Data Science and Machine Learning', 'modules' => 4],
            ['title' => 'Cloud Computing with AWS', 'modules' => 3],
            ['title' => 'DevOps and CI/CD Pipeline', 'modules' => 3],
            ['title' => 'Blockchain and Cryptocurrency', 'modules' => 3],
            ['title' => 'UI/UX Design Masterclass', 'modules' => 3],
            ['title' => 'Digital Marketing for Beginners', 'modules' => 3],
            ['title' => 'Project Management Essentials', 'modules' => 3],
            ['title' => 'Python Programming for Everyone', 'modules' => 4],
            ['title' => 'JavaScript: The Complete Guide', 'modules' => 4],
            ['title' => 'Database Design and SQL', 'modules' => 3],
            ['title' => 'API Development and REST Services', 'modules' => 3],
            ['title' => 'Cybersecurity Fundamentals', 'modules' => 3],
            ['title' => 'Artificial Intelligence Basics', 'modules' => 3],
            ['title' => 'Vue.js: Build Modern Web Apps', 'modules' => 3],
            ['title' => 'Angular Advanced Concepts', 'modules' => 4],
            ['title' => 'Node.js and Express.js Mastery', 'modules' => 3],
            ['title' => 'GraphQL Complete Guide', 'modules' => 3],
            ['title' => 'Docker and Kubernetes', 'modules' => 3],
        ];

        foreach ($coursesData as $courseData) {
            $course = Course::where('title', $courseData['title'])->first();

            if ($course) {
                // Create modules for this course
                $lessonCount = 0;
                for ($m = 1; $m <= $courseData['modules']; $m++) {
                    $module = CourseModule::create([
                        'course_id' => $course->id,
                        'title' => "Module $m: " . $this->getModuleTitle($course->title, $m),
                        'description' => "This module covers the fundamentals of " . $this->getModuleTitle($course->title, $m),
                        'order' => $m,
                    ]);

                    // Create 5-6 lessons per module
                    $lessonCount = rand(5, 6);
                    for ($l = 1; $l <= $lessonCount; $l++) {
                        CourseLesson::create([
                            'module_id' => $module->id,
                            'title' => "Lesson $l: " . $this->getLessonTitle($course->title, $m, $l),
                            'content' => "Comprehensive lesson content covering key concepts and practical examples.",
                            'video_url' => null,
                            'duration_minutes' => rand(15, 60),
                            'order' => $l,
                        ]);
                    }
                }
            }
        }

        $this->command->info('Course structure seeded successfully!');
    }

    private function getModuleTitle(string $courseTitle, int $moduleNum): string
    {
        $topics = [
            'Introduction and Fundamentals',
            'Core Concepts and Theory',
            'Practical Implementation',
            'Advanced Techniques',
        ];
        return $topics[$moduleNum - 1] ?? 'Module ' . $moduleNum;
    }

    private function getLessonTitle(string $courseTitle, int $moduleNum, int $lessonNum): string
    {
        $baseTitles = [
            'Getting Started',
            'Core Principles',
            'Best Practices',
            'Real-World Examples',
            'Advanced Topics',
            'Troubleshooting and Tips',
        ];
        return $baseTitles[$lessonNum - 1] ?? 'Lesson ' . $lessonNum;
    }
}
