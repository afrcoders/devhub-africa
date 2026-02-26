<?php

namespace App\Console\Commands;

use App\Jobs\GenerateDiscussion;
use App\Jobs\GenerateReply;
use Illuminate\Console\Command;

class SimulateCommunityActivity extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'simulate:community {--discussions=2 : Number of discussions to generate} {--replies=5 : Number of replies to generate}';

    /**
     * The console command description.
     */
    protected $description = 'Simulate community activity by generating AI-powered discussions and replies';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $discussionCount = (int) $this->option('discussions');
        $replyCount = (int) $this->option('replies');

        $this->info("Simulating community activity...");

        // Dispatch discussion generation jobs
        for ($i = 0; $i < $discussionCount; $i++) {
            GenerateDiscussion::dispatch();
        }
        $this->info("Dispatched {$discussionCount} discussion generation jobs");

        // Dispatch reply generation jobs
        for ($i = 0; $i < $replyCount; $i++) {
            GenerateReply::dispatch();
        }
        $this->info("Dispatched {$replyCount} reply generation jobs");

        $this->info("✓ Community activity simulation complete!");

        return self::SUCCESS;
    }
}
