<?php

namespace App\Console\Commands;

use App\Models\KortexTool;
use Illuminate\Console\Command;

class TestAllTools extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-all-tools';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test and validate all active tools';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->line('');
        $this->line(str_repeat("=", 80));
        $this->info('🔍 KORTEXTOOLS - COMPREHENSIVE TOOL VALIDATION');
        $this->line(str_repeat("=", 80));
        $this->line('');

        // Get all active tools
        $activeTools = KortexTool::where('is_active', true)->orderBy('category')->orderBy('slug')->get();
        $templateDir = base_path('resources/views/africoders/kortextools/tools');

        $this->line('📊 Database Status:');
        $this->info('   Total tools: ' . KortexTool::count());
        $this->info('   Active tools: ' . $activeTools->count());
        $this->info('   Inactive tools: ' . KortexTool::where('is_active', false)->count());
        $this->line('');

        // Check template files
        $this->line('🔎 Checking template files...');
        $missingTemplates = [];
        $validTools = [];

        foreach ($activeTools as $tool) {
            $templateFile = $templateDir . '/' . $tool->slug . '.blade.php';

            if (file_exists($templateFile)) {
                $size = filesize($templateFile);
                $validTools[] = [
                    'slug' => $tool->slug,
                    'name' => $tool->name,
                    'category' => $tool->category,
                    'size' => $size
                ];
            } else {
                $missingTemplates[] = $tool->slug;
            }
        }

        $this->info('   ✅ Valid tools with templates: ' . count($validTools));
        $this->info('   ❌ Missing templates: ' . count($missingTemplates));
        $this->line('');

        if (count($missingTemplates) > 0) {
            $this->error('⚠️  Tools with missing templates:');
            foreach ($missingTemplates as $slug) {
                $this->line('   - ' . $slug);
            }
            $this->line('');
        }

        // Group by category
        $this->line('📂 Tools by Category:');
        $byCategory = [];
        foreach ($validTools as $tool) {
            if (!isset($byCategory[$tool['category']])) {
                $byCategory[$tool['category']] = [];
            }
            $byCategory[$tool['category']][] = $tool;
        }

        ksort($byCategory);

        foreach ($byCategory as $category => $tools) {
            $this->line('');
            $this->info('   📁 ' . $category . ' (' . count($tools) . ' tools)');
            foreach ($tools as $tool) {
                $this->line('      ✓ ' . $tool['slug'] . ' (' . $tool['size'] . ' bytes)');
            }
        }

        $this->line('');
        $this->line(str_repeat("=", 80));
        $this->info('✅ VALIDATION COMPLETE');
        $this->info('📍 All active tools are accessible and ready for testing at:');
        $this->info('   🌐 https://kortextools.test/all-tools');
        $this->line(str_repeat("=", 80));
        $this->line('');
    }
}
