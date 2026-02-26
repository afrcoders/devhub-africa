<?php

namespace Database\Seeders;

use App\Models\Business\BusinessCategory;
use App\Models\Business\Business;
use App\Models\User;
use Illuminate\Database\Seeder;

class BusinessSeeder extends Seeder
{
    public function run(): void
    {
        // Create business categories
        $categories = [
            [
                'name' => 'Technology',
                'description' => 'IT services, software development, and tech solutions',
                'icon' => '💻',
                'color' => 'blue',
                'sort_order' => 1
            ],
            [
                'name' => 'Healthcare',
                'description' => 'Medical services, clinics, and health-related businesses',
                'icon' => '🏥',
                'color' => 'green',
                'sort_order' => 2
            ],
            [
                'name' => 'Education',
                'description' => 'Schools, training centers, and educational services',
                'icon' => '🎓',
                'color' => 'purple',
                'sort_order' => 3
            ],
            [
                'name' => 'Finance',
                'description' => 'Banks, financial services, and investment firms',
                'icon' => '💰',
                'color' => 'yellow',
                'sort_order' => 4
            ],
            [
                'name' => 'Retail',
                'description' => 'Stores, e-commerce, and retail businesses',
                'icon' => '🛍️',
                'color' => 'pink',
                'sort_order' => 5
            ],
            [
                'name' => 'Food & Beverage',
                'description' => 'Restaurants, cafes, and food-related businesses',
                'icon' => '🍽️',
                'color' => 'orange',
                'sort_order' => 6
            ],
            [
                'name' => 'Construction',
                'description' => 'Building, engineering, and construction services',
                'icon' => '🏗️',
                'color' => 'gray',
                'sort_order' => 7
            ],
            [
                'name' => 'Transportation',
                'description' => 'Logistics, delivery, and transport services',
                'icon' => '🚚',
                'color' => 'indigo',
                'sort_order' => 8
            ]
        ];

        foreach ($categories as $category) {
            BusinessCategory::create($category);
        }

        // Get the first user or create one
        $user = User::first() ?? User::factory()->create();

        // Create sample businesses
        $techCategory = BusinessCategory::where('name', 'Technology')->first();
        $healthCategory = BusinessCategory::where('name', 'Healthcare')->first();
        $educationCategory = BusinessCategory::where('name', 'Education')->first();

        $businesses = [
            [
                'user_id' => $user->id,
                'name' => 'TechSolutions Africa',
                'description' => 'Leading provider of innovative technology solutions for businesses across Africa. We specialize in web development, mobile apps, and cloud services.',
                'website' => 'https://techsolutions.africa',
                'phone' => '+234-800-123-4567',
                'email' => 'info@techsolutions.africa',
                'address' => '123 Innovation Street',
                'city' => 'Lagos',
                'country' => 'Nigeria',
                'category_id' => $techCategory->id,
                'is_featured' => true,
                'is_verified' => true,
                'status' => 'active',
                'views_count' => 1250,
                'rating' => 4.8,
                'reviews_count' => 45
            ],
            [
                'user_id' => $user->id,
                'name' => 'HealthCare Plus Clinic',
                'description' => 'Modern healthcare facility providing comprehensive medical services with state-of-the-art equipment and experienced medical professionals.',
                'website' => 'https://healthcareplus.clinic',
                'phone' => '+234-800-234-5678',
                'email' => 'contact@healthcareplus.clinic',
                'address' => '45 Medical Center Road',
                'city' => 'Abuja',
                'country' => 'Nigeria',
                'category_id' => $healthCategory->id,
                'is_featured' => true,
                'is_verified' => true,
                'status' => 'active',
                'views_count' => 980,
                'rating' => 4.6,
                'reviews_count' => 32
            ],
            [
                'user_id' => $user->id,
                'name' => 'Bright Future Academy',
                'description' => 'Premier educational institution offering quality education from primary to secondary level with focus on STEM subjects.',
                'website' => 'https://brightfuture.edu.ng',
                'phone' => '+234-800-345-6789',
                'email' => 'info@brightfuture.edu.ng',
                'address' => '78 Education Avenue',
                'city' => 'Kano',
                'country' => 'Nigeria',
                'category_id' => $educationCategory->id,
                'is_featured' => false,
                'is_verified' => true,
                'status' => 'active',
                'views_count' => 756,
                'rating' => 4.4,
                'reviews_count' => 28
            ],
            [
                'user_id' => $user->id,
                'name' => 'Digital Marketing Pro',
                'description' => 'Full-service digital marketing agency helping businesses grow their online presence through SEO, social media, and content marketing.',
                'website' => 'https://digitalmarketingpro.ng',
                'phone' => '+234-800-456-7890',
                'email' => 'hello@digitalmarketingpro.ng',
                'address' => '12 Marketing Plaza',
                'city' => 'Port Harcourt',
                'country' => 'Nigeria',
                'category_id' => $techCategory->id,
                'is_featured' => false,
                'is_verified' => true,
                'status' => 'active',
                'views_count' => 543,
                'rating' => 4.2,
                'reviews_count' => 18
            ]
        ];

        foreach ($businesses as $business) {
            Business::create($business);
        }
    }
}
