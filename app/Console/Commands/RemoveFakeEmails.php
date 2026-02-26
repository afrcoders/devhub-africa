<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\DisposableEmailService;
use Illuminate\Console\Command;

class RemoveFakeEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:remove-fake {--dry-run} {--delete}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Detect and remove users with fake/disposable email addresses';

    /**
     * Execute the console command.
     */
    public function handle(DisposableEmailService $disposableEmailService)
    {
        $isDryRun = $this->option('dry-run');
        $shouldDelete = $this->option('delete');

        // Get all users and filter for disposable emails
        $allUsers = User::all();
        $fakeEmailUsers = $allUsers->filter(function ($user) use ($disposableEmailService) {
            return $disposableEmailService->isDisposable($user->email);
        });

        if ($fakeEmailUsers->isEmpty()) {
            $this->info('✓ No users with fake email addresses found.');
            return 0;
        }

        // Display findings
        $this->newLine();
        $this->warn("Found {$fakeEmailUsers->count()} user(s) with fake/disposable email addresses:");
        $this->newLine();

        $this->table(
            ['ID', 'Username', 'Email', 'Full Name', 'Email Verified', 'Created At'],
            $fakeEmailUsers->map(fn($user) => [
                $user->id,
                $user->username,
                $user->email,
                $user->full_name,
                $user->email_verified_at ? 'Yes' : 'No',
                $user->created_at->format('Y-m-d H:i:s'),
            ])->toArray()
        );

        $this->newLine();

        // Handle deletion
        if ($isDryRun) {
            $this->info('🔍 DRY RUN: Would remove ' . $fakeEmailUsers->count() . ' user(s)');
            $this->line('Run without --dry-run and add --delete flag to perform actual deletion.');
            return 0;
        }

        if (!$shouldDelete) {
            if (!$this->confirm("Delete these {$fakeEmailUsers->count()} user(s)?")) {
                $this->info('Operation cancelled.');
                return 0;
            }
        }

        // Delete users
        $deletedCount = 0;
        foreach ($fakeEmailUsers as $user) {
            try {
                // Log deletion for audit trail
                \DB::table('audit_logs')->insert([
                    'user_id' => auth()->id() ?? null,
                    'action' => 'user_deleted_fake_email',
                    'details' => "User with disposable email {$user->email} was deleted via RemoveFakeEmails command",
                    'ip_address' => '127.0.0.1',
                    'user_agent' => 'Command',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $user->delete();
                $deletedCount++;
                $this->line("✓ Deleted: {$user->email}");
            } catch (\Exception $e) {
                $this->error("✗ Failed to delete {$user->email}: {$e->getMessage()}");
            }
        }

        $this->newLine();
        $this->info("✓ Successfully deleted {$deletedCount} user(s).");

        return 0;
    }
}
