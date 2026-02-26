<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Noccea\Learn\StudyGroup;
use App\Models\User;
use Carbon\Carbon;

class StudyGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Use an existing user (admin user or first available user)
        $user = User::where('email', 'admin@africoders.test')->first() ?? User::first();

        if (!$user) {
            $this->command->error('No users found. Please create a user first.');
            return;
        }

        $studyGroups = [
            [
                'name' => 'Web Development Bootcamp',
                'description' => 'A comprehensive study group for learning web development from scratch. We cover HTML, CSS, JavaScript, and modern frameworks. Perfect for beginners looking to break into web development.',
                'category' => 'Web Development',
                'created_by' => $user->id,
                'next_meeting_at' => Carbon::now()->addDays(3)->setTime(19, 0),
                'meeting_link' => 'https://zoom.us/j/123456789',
                'max_members' => 25,
                'is_active' => true,
            ],
            [
                'name' => 'Advanced Backend Development',
                'description' => 'Deep dive into backend development with Node.js, Laravel, and database design. We focus on building scalable APIs, microservices, and cloud deployment strategies.',
                'category' => 'Backend',
                'created_by' => $user->id,
                'next_meeting_at' => Carbon::now()->addDays(5)->setTime(18, 30),
                'meeting_link' => 'https://meet.google.com/abc-defg-hij',
                'max_members' => 20,
                'is_active' => true,
            ],
            [
                'name' => 'DevOps Masters',
                'description' => 'Learn DevOps practices, CI/CD pipelines, Docker, Kubernetes, and cloud infrastructure. Hands-on projects with AWS, Azure, and GCP. Great for developers transitioning to DevOps.',
                'category' => 'DevOps',
                'created_by' => $user->id,
                'next_meeting_at' => Carbon::now()->addDays(7)->setTime(20, 0),
                'meeting_link' => 'https://zoom.us/j/987654321',
                'max_members' => 15,
                'is_active' => true,
            ],
            [
                'name' => 'AI & Machine Learning Study Circle',
                'description' => 'Explore machine learning algorithms, neural networks, and AI applications. We work through real-world projects using Python, TensorFlow, and PyTorch. Prerequisites: Basic Python knowledge.',
                'category' => 'AI & ML',
                'created_by' => $user->id,
                'next_meeting_at' => Carbon::now()->addDays(4)->setTime(17, 0),
                'meeting_link' => null,
                'max_members' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'Blockchain Fundamentals',
                'description' => 'Understanding blockchain technology, smart contracts, and cryptocurrency. We cover Ethereum, Solidity, Web3.js, and DApp development. Join us to build the decentralized future!',
                'category' => 'Blockchain',
                'created_by' => $user->id,
                'next_meeting_at' => null,
                'meeting_link' => null,
                'max_members' => 20,
                'is_active' => true,
            ],
            [
                'name' => 'Programming Foundations',
                'description' => 'A beginner-friendly group focusing on programming fundamentals using Python and JavaScript. Learn problem-solving, algorithms, data structures, and best coding practices.',
                'category' => 'Programming',
                'created_by' => $user->id,
                'next_meeting_at' => Carbon::now()->addDays(2)->setTime(16, 0),
                'meeting_link' => 'https://zoom.us/j/111222333',
                'max_members' => 40,
                'is_active' => true,
            ],
        ];

        foreach ($studyGroups as $groupData) {
            $group = StudyGroup::create($groupData);

            // Automatically add creator as admin member
            $group->members()->attach($user->id, ['role' => 'admin']);
        }

        $this->command->info('Study groups seeded successfully!');
    }
}
