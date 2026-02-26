<?php

namespace App\Jobs;

use App\Models\Business\BusinessCategory;
use App\Models\User;
use App\Services\AIContentGenerator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class GenerateBusinessListing implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Get random user and category
        $user = User::where('is_active', true)->inRandomOrder()->first();
        $category = BusinessCategory::inRandomOrder()->first();

        if (!$user || !$category) {
            \Log::warning('No active users or categories found for business listing');
            return;
        }

        // Generate business content using AI
        $ai = new AIContentGenerator();
        $content = $ai->generateBusinessListing();

        $name = $content['name'] ?? 'African Tech Company ' . rand(1000, 9999);
        $slug = Str::slug($name) . '-' . uniqid();

        // Create business listing
        \DB::table('businesses')->insert([
            'user_id' => $user->id,
            'name' => $name,
            'slug' => $slug,
            'description' => $content['description'] ?? 'A leading tech company in Africa.',
            'category_id' => $category->id,
            'country' => $content['country'] ?? 'Nigeria',
            'website' => null,
            'phone' => null,
            'email' => $user->email,
            'address' => null,
            'city' => $content['city'] ?? 'Lagos',
            'logo' => null,
            'cover_image' => null,
            'is_featured' => false,
            'is_verified' => false,
            'status' => 'active',
            'views_count' => 0,
            'rating' => 0,
            'reviews_count' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        \Log::info('Generated business listing', [
            'name' => $content['name'] ?? 'Unknown',
            'category' => $category->name
        ]);
    }
}
