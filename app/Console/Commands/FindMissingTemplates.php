<?php

namespace App\Console\Commands;

use App\Models\KortexTool;
use Illuminate\Console\Command;

class FindMissingTemplates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:find-missing-templates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find and disable tools that have no template files';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $templateDir = base_path('resources/views/africoders/kortextools/tools');
        $tools = KortexTool::all();

        $missing = [];

        foreach ($tools as $tool) {
            $templateFile = $templateDir . '/' . $tool->slug . '.blade.php';

            if (!file_exists($templateFile)) {
                $missing[] = [
                    'id' => $tool->id,
                    'slug' => $tool->slug,
                    'name' => $tool->name,
                    'is_active' => $tool->is_active
                ];
            }
        }

        if (count($missing) > 0) {
            $this->line('');
            $this->error('Found ' . count($missing) . ' tools without template files:');
            $this->line(str_repeat("=", 80));

            foreach ($missing as $tool) {
                $status = $tool['is_active'] ? 'ACTIVE' : 'INACTIVE';
                $this->info("[$status] {$tool['slug']} - {$tool['name']} (ID: {$tool['id']})");
            }

            $this->line(str_repeat("=", 80));

            if ($this->confirm('Disable these tools?', true)) {
                $slugs = array_column($missing, 'slug');
                $updated = KortexTool::whereIn('slug', $slugs)->update(['is_active' => false]);

                $this->line('');
                $this->info("✅ Disabled $updated tools");
                $this->info("📊 Active tools remaining: " . KortexTool::where('is_active', true)->count());
                $this->line('');
            }
        } else {
            $this->info('✅ All tools have corresponding template files!');
            $this->info('📊 Total active tools: ' . KortexTool::where('is_active', true)->count());
        }
    }
}
