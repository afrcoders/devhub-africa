<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Test User 1: Regular Member (Email verified)
        $user1 = User::create([
            'full_name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'john@example.com',
            'phone' => '+234 801 234 5678',
            'country' => 'Nigeria',
            'bio' => 'Full stack developer passionate about African tech',
            'password' => Hash::make('password123'),
            'role' => 'member',
            'trust_level' => 'verified',
            'email_verified' => true,
            'phone_verified' => false,
            'is_active' => true,
            'password_changed_at' => now()->subDays(5),
            'last_login' => now()->subHours(2),
        ]);

        // Create identity verification for user1
        $user1->verifications()->create([
            'type' => 'identity',
            'status' => 'approved',
            'data' => [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'id_type' => 'passport',
                'id_number' => 'AB123456',
            ],
            'reviewed_at' => now()->subDays(3),
        ]);

        // Create audit log for user1
        AuditLog::create([
            'user_id' => $user1->id,
            'action' => 'signup',
            'ip_address' => '192.168.1.100',
            'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7)',
        ]);

        // Test User 2: Business Owner (Email verified)
        $user2 = User::create([
            'full_name' => 'Jane Smith',
            'username' => 'janesmith',
            'email' => 'jane@example.com',
            'phone' => '+234 802 345 6789',
            'country' => 'Ghana',
            'bio' => 'Tech entrepreneur & startup mentor',
            'password' => Hash::make('password123'),
            'role' => 'business_owner',
            'trust_level' => 'trusted',
            'email_verified' => true,
            'phone_verified' => true,
            'is_active' => true,
            'password_changed_at' => now()->subDays(1),
            'last_login' => now(),
        ]);

        // Create business verification for user2
        $user2->verifications()->create([
            'type' => 'business',
            'status' => 'approved',
            'data' => [
                'business_name' => 'TechStart Africa',
                'business_number' => 'BN123456789',
            ],
            'reviewed_at' => now()->subDays(2),
        ]);

        AuditLog::create([
            'user_id' => $user2->id,
            'action' => 'signup',
            'ip_address' => '192.168.1.101',
            'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7)',
        ]);

        // Test User 3: Instructor (Email not verified)
        $user3 = User::create([
            'full_name' => 'Prof. Michael Johnson',
            'username' => 'prof_michael',
            'email' => 'michael@example.com',
            'phone' => '+234 803 456 7890',
            'country' => 'South Africa',
            'bio' => 'University lecturer & coding instructor',
            'password' => Hash::make('password123'),
            'role' => 'instructor',
            'trust_level' => 'unverified',
            'email_verified' => false,
            'phone_verified' => false,
            'is_active' => true,
            'password_changed_at' => null,
            'last_login' => null,
        ]);

        // Create instructor verification for user3
        $user3->verifications()->create([
            'type' => 'instructor',
            'status' => 'pending',
            'data' => [
                'qualifications' => 'Bachelor of Science in Computer Science, Master of Technology',
                'experience_years' => 10,
            ],
        ]);

        AuditLog::create([
            'user_id' => $user3->id,
            'action' => 'signup',
            'ip_address' => '192.168.1.102',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
        ]);

        // Test User 4: Admin User
        $admin = User::create([
            'full_name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@africoders.test',
            'phone' => '+234 800 000 0000',
            'country' => 'Nigeria',
            'bio' => 'System administrator',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'trust_level' => 'trusted',
            'email_verified' => true,
            'phone_verified' => true,
            'is_active' => true,
            'password_changed_at' => now()->subDays(10),
            'last_login' => now()->subHours(1),
        ]);

        AuditLog::create([
            'user_id' => $admin->id,
            'action' => 'signup',
            'ip_address' => '192.168.1.1',
            'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7)',
        ]);

        $this->command->info('Test users created successfully!');
        $this->command->line('');
        $this->command->info('Test Accounts:');
        $this->command->line('1. Member (Verified): johndoe / password123 (john@example.com)');
        $this->command->line('2. Business Owner: janesmith / password123 (jane@example.com)');
        $this->command->line('3. Instructor (Unverified): prof_michael / password123 (michael@example.com)');
        $this->command->line('4. Admin: admin / admin123 (admin@africoders.test)');
    }
}
