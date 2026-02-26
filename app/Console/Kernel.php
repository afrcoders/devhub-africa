<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Community activity simulation - spread throughout the day
        $schedule->command('simulate:community --discussions=1 --replies=3')
            ->everyThreeHours()
            ->between('8:00', '20:00')
            ->timezone('Africa/Lagos');

        // Learning platform activity simulation
        $schedule->command('simulate:learn --enrollments=2 --completions=8')
            ->everyFourHours()
            ->timezone('Africa/Lagos');

        // Business platform activity simulation
        $schedule->command('simulate:business --listings=1')
            ->everySixHours()
            ->timezone('Africa/Lagos');

        // Note: With 5-minute cron interval, tasks run at the top of each hour/interval
        // This gives you: ~5-7 activities per day spread naturally
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
