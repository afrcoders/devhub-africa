<?php

namespace App\Jobs;

use App\Models\Community\Discussion;
use App\Models\Community\DiscussionCategory;
use App\Models\User;
use App\Services\AIContentGenerator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class GenerateDiscussion implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Get random category
        $category = DiscussionCategory::inRandomOrder()->first();
        if (!$category) {
            \Log::warning('No discussion categories found');
            return;
        }

        // Get random active user
        $user = User::where('is_active', true)->inRandomOrder()->first();
        if (!$user) {
            \Log::warning('No active users found');
            return;
        }

        // Generate content using AI
        $ai = new AIContentGenerator();
        $content = $ai->generateDiscussion($category->name);

        $title = $content['title'] ?? 'Discussion about ' . $category->name . ' ' . rand(1000, 9999);
        $slug = Str::slug($title) . '-' . uniqid();

        // Create discussion
        $discussion = Discussion::create([
            'category_id' => $category->id,
            'user_id' => $user->id,
            'title' => $title,
            'slug' => $slug,
            'body' => $content['body'] ?? 'Let\'s discuss this topic.',
            'last_activity_at' => now(),
        ]);

        \Log::info('Generated discussion', [
            'id' => $discussion->id,
            'title' => $discussion->title,
            'category' => $category->name
        ]);
    }
}
