<?php

namespace App\Services;

class CourseImageService
{
    /**
     * Generate an SVG placeholder image for a course
     */
    public static function generateImageUrl(string $title, string $category, array $gradientColors): string
    {
        // Use placeholder service with query parameters
        $encodedTitle = urlencode($title);
        $encodedCategory = urlencode($category);

        // Extract colors from gradient (e.g., "from-blue-500 to-cyan-600")
        $color1 = self::getColorHex($gradientColors[0] ?? 'from-blue-500');
        $color2 = self::getColorHex($gradientColors[1] ?? 'to-cyan-600');

        // Generate SVG-based placeholder with gradient
        $svg = self::generateSVG($title, $category, $color1, $color2);

        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }

    /**
     * Generate SVG placeholder image
     */
    private static function generateSVG(string $title, string $category, string $color1, string $color2): string
    {
        $width = 600;
        $height = 400;
        $gradientId = 'grad' . uniqid();

        // Shorten title for display
        $displayTitle = strlen($title) > 50 ? substr($title, 0, 47) . '...' : $title;
        $displayTitle = htmlspecialchars($displayTitle);
        $displayCategory = htmlspecialchars($category);

        $svg = <<<SVG
<?xml version="1.0" encoding="UTF-8"?>
<svg width="{$width}" height="{$height}" xmlns="http://www.w3.org/2000/svg">
    <defs>
        <linearGradient id="{$gradientId}" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" style="stop-color:{$color1};stop-opacity:1" />
            <stop offset="100%" style="stop-color:{$color2};stop-opacity:1" />
        </linearGradient>
    </defs>

    <!-- Background with gradient -->
    <rect width="{$width}" height="{$height}" fill="url(#{$gradientId})" />

    <!-- Overlay pattern -->
    <circle cx="100" cy="50" r="80" fill="rgba(255,255,255,0.1)" />
    <circle cx="500" cy="350" r="120" fill="rgba(255,255,255,0.1)" />
    <circle cx="600" cy="80" r="60" fill="rgba(0,0,0,0.05)" />

    <!-- Title -->
    <text x="30" y="160" font-family="Arial, sans-serif" font-size="32" font-weight="bold" fill="white" text-anchor="start" word-wrap="break-word">
        <tspan x="30" dy="0" font-size="28">{$displayTitle}</tspan>
    </text>

    <!-- Category badge background -->
    <rect x="30" y="280" width="200" height="45" fill="rgba(255,255,255,0.25)" rx="8" />

    <!-- Category text -->
    <text x="50" y="310" font-family="Arial, sans-serif" font-size="14" font-weight="600" fill="white" text-anchor="start">
        {$displayCategory}
    </text>

    <!-- Decorative elements -->
    <line x1="30" y1="340" x2="570" y2="340" stroke="rgba(255,255,255,0.3)" stroke-width="2" />
</svg>
SVG;

        return $svg;
    }

    /**
     * Map Tailwind color names to hex values
     */
    private static function getColorHex(string $colorClass): string
    {
        $colors = [
            // Blues
            'from-blue-500' => '#3b82f6',
            'to-cyan-600' => '#06b6d4',
            'from-blue-600' => '#2563eb',
            'to-blue-600' => '#2563eb',

            // Greens
            'from-green-500' => '#22c55e',
            'to-emerald-600' => '#059669',
            'from-green-600' => '#16a34a',
            'from-lime-600' => '#65a30d',

            // Purples
            'from-purple-500' => '#a855f7',
            'to-pink-600' => '#ec4899',
            'from-purple-600' => '#9333ea',
            'from-indigo-500' => '#6366f1',
            'to-purple-600' => '#9333ea',
            'from-indigo-600' => '#4f46e5',
            'from-violet-600' => '#7c3aed',

            // Oranges & Reds
            'from-orange-500' => '#f97316',
            'to-red-600' => '#dc2626',
            'from-orange-600' => '#ea580c',
            'from-yellow-600' => '#ca8a04',
            'from-red-600' => '#dc2626',
            'to-orange-600' => '#ea580c',

            // Cyans & Teals
            'from-cyan-600' => '#0891b2',
            'to-blue-600' => '#2563eb',

            // Additional
            'from-teal-600' => '#0d9488',
            'to-teal-600' => '#0d9488',
        ];

        return $colors[$colorClass] ?? '#3b82f6';
    }

    /**
     * Get a unique seed for placeholder images
     */
    public static function getImageSeed(string $title): string
    {
        return (string) crc32($title);
    }
}
