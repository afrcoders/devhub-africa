<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ImportUsersFromNoccea extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:noccea-users';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Import users from noccea database to Africoders database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting user import from noccea database...');

        try {
            // Connect to noccea database
            $noccaeUsers = DB::connection('noccea')->table('users')->get();

            if ($noccaeUsers->isEmpty()) {
                $this->warn('No users found in noccea database');
                return;
            }

            $imported = 0;
            $skipped = 0;
            $failed = 0;

            foreach ($noccaeUsers as $noccaeUser) {
                try {
                    // Skip if email already exists
                    if (User::where('email', $noccaeUser->email)->exists()) {
                        $this->line("<fg=yellow>⊘</> Skipped: {$noccaeUser->email} (email already exists)");
                        $skipped++;
                        continue;
                    }

                    // Generate username from email if not provided
                    $username = $noccaeUser->username ?? $this->generateUsernameFromEmail($noccaeUser->email);

                    // Ensure username is unique
                    $baseUsername = $username;
                    $counter = 1;
                    while (User::where('username', $username)->exists()) {
                        $username = $baseUsername . $counter;
                        $counter++;
                    }

                    // Generate random password
                    $randomPassword = Str::random(16);

                    // Create new user
                    User::create([
                        'full_name' => $noccaeUser->full_name ?? $noccaeUser->name ?? $noccaeUser->email,
                        'username' => $username,
                        'email' => $noccaeUser->email,
                        'phone' => $noccaeUser->phone ?? null,
                        'bio' => $noccaeUser->bio ?? null,
                        'country' => $noccaeUser->country ?? null,
                        'profile_picture' => $noccaeUser->profile_picture ?? null,
                        'password' => Hash::make($randomPassword),
                        'role' => $noccaeUser->role ?? 'member',
                        'trust_level' => 'unverified',
                        'email_verified' => false,  // Not activated
                        'phone_verified' => false,
                        'is_active' => true,
                        'email_verified_at' => null,  // Not verified
                        'password_changed_at' => now(),
                    ]);

                    $this->line("<fg=green>✓</> Imported: {$noccaeUser->email} (username: {$username})");
                    $imported++;

                } catch (\Exception $e) {
                    $this->line("<fg=red>✗</> Failed to import {$noccaeUser->email}: {$e->getMessage()}");
                    $failed++;
                }
            }

            // Summary
            $this->newLine();
            $this->info('=== Import Summary ===');
            $this->line("<fg=green>Imported:</> {$imported} users");
            $this->line("<fg=yellow>Skipped:</> {$skipped} users (email already exists)");
            $this->line("<fg=red>Failed:</> {$failed} users");
            $this->info('Import completed!');

        } catch (\Exception $e) {
            $this->error('Error connecting to noccea database: ' . $e->getMessage());
            return;
        }
    }

    /**
     * Generate a username from email address
     */
    private function generateUsernameFromEmail(string $email): string
    {
        // Extract the part before @ and make it alphanumeric with underscores
        $username = explode('@', $email)[0];
        $username = preg_replace('/[^a-zA-Z0-9_]/', '_', $username);

        // Ensure it's 3-20 characters
        if (strlen($username) < 3) {
            $username = substr($username, 0, 3) . Str::random(3);
        } elseif (strlen($username) > 20) {
            $username = substr($username, 0, 20);
        }

        return $username;
    }
}
