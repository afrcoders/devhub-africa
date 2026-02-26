<?php

namespace App\Jobs;

use App\Models\Community\Discussion;
use App\Models\Community\DiscussionReply;
use App\Models\User;
use App\Services\AIContentGenerator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateReply implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Get a recent discussion without too many replies
        $discussion = Discussion::withCount('replies')
            ->where('created_at', '>=', now()->subDays(7))
            ->where('is_locked', false)
            ->having('replies_count', '<', 5)
            ->inRandomOrder()
            ->first();

        if (!$discussion) {
            \Log::info('No suitable discussions found for reply');
            return;
        }

        // Get random active user (different from discussion author)
        $user = User::where('is_active', true)
            ->where('id', '!=', $discussion->user_id)
            ->inRandomOrder()
            ->first();

        if (!$user) {
            \Log::warning('No active users found for reply');
            return;
        }

        // Generate reply using AI
        $ai = new AIContentGenerator();
        $replyBody = $ai->generateReply($discussion->title, $discussion->body);

        // Create reply
        $reply = DiscussionReply::create([
            'discussion_id' => $discussion->id,
            'user_id' => $user->id,
            'body' => $replyBody,
        ]);

        // Update discussion activity
        $discussion->update([
            'replies_count' => $discussion->replies_count + 1,
            'last_activity_at' => now(),
        ]);

        \Log::info('Generated reply', [
            'reply_id' => $reply->id,
            'discussion' => $discussion->title
        ]);
    }
}
