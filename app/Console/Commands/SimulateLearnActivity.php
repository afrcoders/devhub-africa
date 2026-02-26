<?php

namespace App\Console\Commands;

use App\Jobs\GenerateEnrollment;
use App\Jobs\GenerateLessonCompletion;
use Illuminate\Console\Command;

class SimulateLearnActivity extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'simulate:learn {--enrollments=3 : Number of enrollments to generate} {--completions=10 : Number of lesson completions to generate}';

    /**
     * The console command description.
     */
    protected $description = 'Simulate learning platform activity by generating enrollments and lesson completions';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $enrollmentCount = (int) $this->option('enrollments');
        $completionCount = (int) $this->option('completions');

        $this->info("Simulating learning platform activity...");

        // Dispatch enrollment generation jobs
        for ($i = 0; $i < $enrollmentCount; $i++) {
            GenerateEnrollment::dispatch();
        }
        $this->info("Dispatched {$enrollmentCount} enrollment generation jobs");

        // Dispatch lesson completion jobs
        for ($i = 0; $i < $completionCount; $i++) {
            GenerateLessonCompletion::dispatch();
        }
        $this->info("Dispatched {$completionCount} lesson completion jobs");

        $this->info("✓ Learning platform activity simulation complete!");

        return self::SUCCESS;
    }
}
