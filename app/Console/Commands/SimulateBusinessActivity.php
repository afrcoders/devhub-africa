<?php

namespace App\Console\Commands;

use App\Jobs\GenerateBusinessListing;
use Illuminate\Console\Command;

class SimulateBusinessActivity extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'simulate:business {--listings=2 : Number of business listings to generate}';

    /**
     * The console command description.
     */
    protected $description = 'Simulate business platform activity by generating AI-powered business listings';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $listingCount = (int) $this->option('listings');

        $this->info("Simulating business platform activity...");

        // Dispatch business listing generation jobs
        for ($i = 0; $i < $listingCount; $i++) {
            GenerateBusinessListing::dispatch();
        }
        $this->info("Dispatched {$listingCount} business listing generation jobs");

        $this->info("✓ Business platform activity simulation complete!");

        return self::SUCCESS;
    }
}
