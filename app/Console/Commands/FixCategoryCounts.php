<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Community\DiscussionCategory;
use App\Models\Community\Discussion;

class FixCategoryCounts extends Command
{
    protected $signature = 'fix:category-counts {--dry-run : Show issues without fixing}';
    protected $description = 'Fix category discussion counts and sanitize data';

    public function handle()
    {
        $isDryRun = $this->option('dry-run');

        if ($isDryRun) {
            $this->info('DRY RUN MODE - No changes will be made');
        }

        $this->info('Checking category discussion counts...');

        $categories = DiscussionCategory::all();
        $fixedCount = 0;
        $emptyCategories = 0;

        foreach ($categories as $category) {
            $actualCount = $category->discussions()->count();
            $storedCount = $category->discussions_count;

            if ($storedCount > 0 && $actualCount == 0) {
                $this->warn("EMPTY CATEGORY: {$category->name} - Shows {$storedCount} discussions but has {$actualCount}");
                $emptyCategories++;

                if (!$isDryRun) {
                    $category->update(['discussions_count' => 0]);
                    $fixedCount++;
                }
            } elseif ($storedCount != $actualCount) {
                $this->info("MISMATCH: {$category->name} - Stored: {$storedCount}, Actual: {$actualCount}");

                if (!$isDryRun) {
                    $category->update(['discussions_count' => $actualCount]);
                    $fixedCount++;
                }
            }
        }

        // Check for orphaned discussions
        $this->info('Checking for orphaned discussions...');
        $orphanedDiscussions = Discussion::whereDoesntHave('category')->count();

        if ($orphanedDiscussions > 0) {
            $this->warn("Found {$orphanedDiscussions} orphaned discussions without valid categories");

            if (!$isDryRun) {
                // Create a "Uncategorized" category for orphaned discussions
                $uncategorizedCategory = DiscussionCategory::firstOrCreate([
                    'slug' => 'uncategorized'
                ], [
                    'name' => 'Uncategorized',
                    'description' => 'Discussions that could not be properly categorized during import',
                    'color' => 'gray',
                    'icon' => '❓',
                    'sort_order' => 999,
                    'is_active' => true,
                    'discussions_count' => 0
                ]);

                // Move orphaned discussions to uncategorized
                $movedCount = Discussion::whereDoesntHave('category')
                    ->update(['category_id' => $uncategorizedCategory->id]);

                // Update the uncategorized category count
                $uncategorizedCategory->update([
                    'discussions_count' => $uncategorizedCategory->discussions()->count()
                ]);

                $this->info("Moved {$movedCount} orphaned discussions to 'Uncategorized' category");
            }
        }

        // Recalculate reply counts for all categories
        if (!$isDryRun) {
            $this->info('Recalculating reply counts for categories...');
            foreach ($categories as $category) {
                $totalReplies = $category->discussions()
                    ->withCount('replies')
                    ->get()
                    ->sum('replies_count');

                $category->update(['replies_count' => $totalReplies]);
            }
        }

        if ($isDryRun) {
            $this->info("Issues found: {$fixedCount} count mismatches, {$emptyCategories} empty categories showing counts, {$orphanedDiscussions} orphaned discussions");
            $this->info('Run without --dry-run to fix these issues');
        } else {
            $this->info("Fixed {$fixedCount} category count issues");
            if ($orphanedDiscussions > 0) {
                $this->info("Handled {$orphanedDiscussions} orphaned discussions");
            }
            $this->success('Category sanitization completed!');
        }

        return 0;
    }
}
