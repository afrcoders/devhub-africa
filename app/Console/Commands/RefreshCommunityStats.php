<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Community\DiscussionCategory;
use App\Models\Community\Discussion;
use App\Models\Community\DiscussionReply;
use Illuminate\Support\Facades\DB;

class RefreshCommunityStats extends Command
{
    protected $signature = 'refresh:community-stats {--dry-run : Show what would be updated without making changes}';
    protected $description = 'Refresh all community statistics (discussions, replies, categories)';

    public function handle()
    {
        $isDryRun = $this->option('dry-run');

        if ($isDryRun) {
            $this->info('DRY RUN MODE - No changes will be made');
        }

        $this->info('Refreshing community statistics...');

        // 1. Update discussion reply counts
        $this->info('Updating discussion reply counts...');
        $discussions = Discussion::all();
        $discussionUpdates = 0;

        foreach ($discussions as $discussion) {
            $actualReplies = $discussion->replies()->count();
            if ($discussion->replies_count != $actualReplies) {
                $this->info("Discussion '{$discussion->title}': {$discussion->replies_count} → {$actualReplies} replies");

                if (!$isDryRun) {
                    $discussion->update(['replies_count' => $actualReplies]);
                    $discussionUpdates++;
                }
            }
        }

        // 2. Update category discussion and reply counts
        $this->info('Updating category statistics...');
        $categories = DiscussionCategory::all();
        $categoryUpdates = 0;

        foreach ($categories as $category) {
            $actualDiscussions = $category->discussions()->count();
            $actualReplies = $category->discussions()->withCount('replies')->get()->sum('replies_count');

            $needsUpdate = false;
            $changes = [];

            if ($category->discussions_count != $actualDiscussions) {
                $changes[] = "discussions: {$category->discussions_count} → {$actualDiscussions}";
                $needsUpdate = true;
            }

            if ($category->replies_count != $actualReplies) {
                $changes[] = "replies: {$category->replies_count} → {$actualReplies}";
                $needsUpdate = true;
            }

            if ($needsUpdate) {
                $this->info("Category '{$category->name}': " . implode(', ', $changes));

                if (!$isDryRun) {
                    $category->update([
                        'discussions_count' => $actualDiscussions,
                        'replies_count' => $actualReplies
                    ]);
                    $categoryUpdates++;
                }
            }
        }

        // 3. Update last_activity_at for discussions based on latest reply
        $this->info('Updating discussion activity timestamps...');
        $activityUpdates = 0;

        foreach ($discussions as $discussion) {
            $latestReply = $discussion->replies()->latest('created_at')->first();
            $latestActivity = $latestReply ? $latestReply->created_at : $discussion->created_at;

            if ($discussion->last_activity_at->ne($latestActivity)) {
                $this->info("Discussion '{$discussion->title}': activity updated to {$latestActivity}");

                if (!$isDryRun) {
                    $discussion->update(['last_activity_at' => $latestActivity]);
                    $activityUpdates++;
                }
            }
        }

        // 4. Check for and fix any data integrity issues
        $this->info('Checking data integrity...');

        // Check for replies without valid discussions
        $orphanedReplies = DiscussionReply::whereDoesntHave('discussion')->count();
        if ($orphanedReplies > 0) {
            $this->warn("Found {$orphanedReplies} orphaned replies without valid discussions");
            if (!$isDryRun) {
                DiscussionReply::whereDoesntHave('discussion')->delete();
                $this->info("Deleted {$orphanedReplies} orphaned replies");
            }
        }

        // Check for discussions without valid categories
        $orphanedDiscussions = Discussion::whereDoesntHave('category')->count();
        if ($orphanedDiscussions > 0) {
            $this->warn("Found {$orphanedDiscussions} orphaned discussions without valid categories");
            if (!$isDryRun) {
                $uncategorizedCategory = DiscussionCategory::firstOrCreate([
                    'slug' => 'uncategorized'
                ], [
                    'name' => 'Uncategorized',
                    'description' => 'Discussions that could not be properly categorized',
                    'color' => 'gray',
                    'icon' => '❓',
                    'sort_order' => 999,
                    'is_active' => true,
                    'discussions_count' => 0,
                    'replies_count' => 0
                ]);

                Discussion::whereDoesntHave('category')->update([
                    'category_id' => $uncategorizedCategory->id
                ]);

                $this->info("Moved {$orphanedDiscussions} orphaned discussions to 'Uncategorized'");
            }
        }

        if ($isDryRun) {
            $this->info('Summary of changes that would be made:');
            $this->info("- Discussion reply counts: {$discussionUpdates} updates");
            $this->info("- Category statistics: {$categoryUpdates} updates");
            $this->info("- Discussion activity timestamps: {$activityUpdates} updates");
            $this->info("- Orphaned replies: {$orphanedReplies} would be deleted");
            $this->info("- Orphaned discussions: {$orphanedDiscussions} would be moved");
            $this->info('Run without --dry-run to apply these changes');
        } else {
            $this->info('✅ Community statistics refreshed successfully!');
            $this->info("Updated {$discussionUpdates} discussions, {$categoryUpdates} categories, {$activityUpdates} activity timestamps");
        }

        return 0;
    }
}
