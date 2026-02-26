<?php

namespace Database\Seeders;

use App\Models\KortexTool;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddMissingToolsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tools = [
            [
                'slug' => 'css-formatter',
                'name' => 'CSS Formatter',
                'category' => 'Developer Tools',
                'description' => 'Format and beautify your CSS code with intelligent indentation',
                'icon' => 'fas fa-palette',
                'meta_title' => 'CSS Formatter - Format & Beautify CSS Code',
                'meta_description' => 'Automatically format and beautify CSS code with proper indentation and spacing.',
                'is_active' => true,
            ],
            [
                'slug' => 'html-formatter',
                'name' => 'HTML Formatter',
                'category' => 'Developer Tools',
                'description' => 'Format and beautify HTML code with proper indentation',
                'icon' => 'fas fa-code',
                'meta_title' => 'HTML Formatter - Format & Beautify HTML Code',
                'meta_description' => 'Automatically format and beautify HTML code with tag-aware indentation.',
                'is_active' => true,
            ],
            [
                'slug' => 'html-encoder',
                'name' => 'HTML Encoder',
                'category' => 'Developer Tools',
                'description' => 'Encode and decode HTML entities',
                'icon' => 'fas fa-encrypt',
                'meta_title' => 'HTML Encoder/Decoder - Convert HTML Entities',
                'meta_description' => 'Encode HTML to entities and decode entities back to HTML text.',
                'is_active' => true,
            ],
            [
                'slug' => 'html-validator',
                'name' => 'HTML Validator',
                'category' => 'Developer Tools',
                'description' => 'Validate HTML structure and syntax',
                'icon' => 'fas fa-check',
                'meta_title' => 'HTML Validator - Check HTML Syntax',
                'meta_description' => 'Validate HTML code and detect syntax errors, unclosed tags, and structural issues.',
                'is_active' => true,
            ],
            [
                'slug' => 'markdown-editor',
                'name' => 'Markdown Editor',
                'category' => 'Developer Tools',
                'description' => 'Write and preview Markdown with real-time HTML output',
                'icon' => 'fas fa-markdown',
                'meta_title' => 'Markdown Editor - Write & Preview Markdown',
                'meta_description' => 'Real-time Markdown editor with live HTML preview. Convert markdown to HTML instantly.',
                'is_active' => true,
            ],
            [
                'slug' => 'url-encoder',
                'name' => 'URL Encoder',
                'category' => 'Utilities',
                'description' => 'Encode and decode URLs and query parameters',
                'icon' => 'fas fa-link',
                'meta_title' => 'URL Encoder/Decoder - Encode URLs',
                'meta_description' => 'Encode and decode URLs, query strings, and parameters for use in web applications.',
                'is_active' => true,
            ],
            [
                'slug' => 'sql-formatter',
                'name' => 'SQL Formatter',
                'category' => 'Developer Tools',
                'description' => 'Format and beautify SQL queries',
                'icon' => 'fas fa-database',
                'meta_title' => 'SQL Formatter - Format SQL Queries',
                'meta_description' => 'Automatically format and beautify SQL queries with proper indentation and keyword handling.',
                'is_active' => true,
            ],
        ];

        foreach ($tools as $tool) {
            // Check if tool already exists
            $exists = KortexTool::where('slug', $tool['slug'])->first();
            if (!$exists) {
                KortexTool::create($tool);
                echo "✅ Added: {$tool['slug']}\n";
            } else {
                echo "⏭️  Skipped: {$tool['slug']} (already exists)\n";
            }
        }

        echo "\n📊 Total tools in database: " . KortexTool::count() . "\n";
    }
}

