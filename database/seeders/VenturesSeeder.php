<?php

namespace Database\Seeders;

use App\Models\Africoders\Venture;
use Illuminate\Database\Seeder;

class VenturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ventures = [
            [
                'name' => 'Noccea',
                'slug' => 'noccea',
                'description' => 'A community platform connecting African tech professionals, entrepreneurs, and innovators. Noccea facilitates knowledge sharing, collaboration, and networking opportunities.',
                'content' => 'A community platform connecting African tech professionals, entrepreneurs, and innovators. Noccea facilitates knowledge sharing, collaboration, and networking opportunities.',
                'website_url' => 'https://noccea.com',
                'status' => 'launched',
                'featured_image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80',
                'meta_description' => 'Community platform connecting African tech professionals, entrepreneurs, and innovators.',
                'meta_keywords' => 'community, tech, professionals, networking, Africa',
                'featured' => true,
                'published' => true,
                'published_at' => now(),
                'order' => 1,
            ],
            [
                'name' => 'Afrihealthsys',
                'slug' => 'afrihealthsys',
                'description' => 'A comprehensive hospital management system developed in partnership with healthcare providers. Streamlines patient records, appointments, billing, and inventory management.',
                'content' => 'A comprehensive hospital management system developed in partnership with healthcare providers. Streamlines patient records, appointments, billing, and inventory management.',
                'website_url' => 'https://afrihealthsys.com',
                'status' => 'launched',
                'featured_image' => 'https://images.unsplash.com/photo-1576091160550-112173f31f0f?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80',
                'meta_description' => 'Hospital management system streamlining healthcare operations.',
                'meta_keywords' => 'healthcare, hospital, management, system, Africa',
                'featured' => true,
                'published' => true,
                'published_at' => now(),
                'order' => 2,
            ],
            [
                'name' => 'Kortextools',
                'slug' => 'kortextools',
                'description' => 'All-in-one online tools platform featuring PDF editors, file converters, and text utilities. Simple, fast, and reliable tools right in your browser — no installs, no hassle.',
                'content' => 'All-in-one online tools platform featuring PDF editors, file converters, and text utilities. Simple, fast, and reliable tools right in your browser — no installs, no hassle.',
                'website_url' => 'https://kortextools.com',
                'status' => 'launched',
                'featured_image' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80',
                'meta_description' => 'All-in-one online tools platform for productivity and file management.',
                'meta_keywords' => 'tools, productivity, PDF, converter, utilities',
                'featured' => true,
                'published' => true,
                'published_at' => now(),
                'order' => 3,
            ],
            [
                'name' => 'PHPBrowserBox',
                'slug' => 'phpbrowserbox',
                'description' => 'A freeware tool that allows developers to run PHP applications directly in the browser. Simplifies testing, demonstration, and educational use of PHP code.',
                'content' => 'A freeware tool that allows developers to run PHP applications directly in the browser. Simplifies testing, demonstration, and educational use of PHP code.',
                'website_url' => 'https://phpbb.africoders.com',
                'status' => 'launched',
                'featured_image' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80',
                'meta_description' => 'Developer tool for running PHP applications in the browser.',
                'meta_keywords' => 'PHP, developer, tool, browser, testing',
                'featured' => false,
                'published' => true,
                'published_at' => now(),
                'order' => 4,
            ],
            [
                'name' => 'Terra Nova Property Services',
                'slug' => 'terra-nova-property-services',
                'description' => 'A locally owned business serving Winnipeg with dependable lawn care, snow clearing, and property cleaning solutions designed for Manitoba\'s extreme seasons.',
                'content' => 'A locally owned business serving Winnipeg with dependable lawn care, snow clearing, and property cleaning solutions designed for Manitoba\'s extreme seasons.',
                'website_url' => 'https://experienceterranova.com/',
                'status' => 'launched',
                'featured_image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80',
                'meta_description' => 'Property services including lawn care, snow clearing, and cleaning.',
                'meta_keywords' => 'property, lawn care, snow clearing, cleaning',
                'featured' => false,
                'published' => true,
                'published_at' => now(),
                'order' => 5,
            ],
            [
                'name' => 'Dakoss Global',
                'slug' => 'dakoss-global',
                'description' => 'Industrial equipment solutions provider specializing in air compressors, material handling equipment, and forklift services. Trusted partner for Nigeria\'s leading manufacturing companies.',
                'content' => 'Industrial equipment solutions provider specializing in air compressors, material handling equipment, and forklift services. Trusted partner for Nigeria\'s leading manufacturing companies.',
                'website_url' => 'https://dakossglobal.com',
                'status' => 'launched',
                'featured_image' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80',
                'meta_description' => 'Industrial equipment solutions for manufacturing companies.',
                'meta_keywords' => 'industrial, equipment, compressors, manufacturing',
                'featured' => false,
                'published' => true,
                'published_at' => now(),
                'order' => 6,
            ],
        ];

        foreach ($ventures as $venture) {
            Venture::firstOrCreate(
                ['slug' => $venture['slug']],
                $venture
            );
        }
    }
}
