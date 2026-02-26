<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Community\DiscussionCategory;
use App\Models\Community\Discussion;
use App\Models\Community\DiscussionReply;
use Carbon\Carbon;

class ImportMyBBData extends Command
{
    protected $signature = 'import:mybb
                           {--database=noccea : MyBB database name}
                           {--dry-run : Run without actually importing data}
                           {--users : Import users only}
                           {--categories : Import categories/forums only}
                           {--discussions : Import discussions/threads only}
                           {--replies : Import replies/posts only}';

    protected $description = 'Import data from MyBB forum to Laravel community system';

    protected $mybbDb;
    protected $isDryRun = false;
    protected $userMappings = [];
    protected $categoryMappings = [];
    protected $discussionMappings = [];

    public function handle()
    {
        $this->mybbDb = $this->option('database');
        $this->isDryRun = $this->option('dry-run');

        $this->info('Starting MyBB data import from database: ' . $this->mybbDb);
        if ($this->isDryRun) {
            $this->warn('DRY RUN MODE - No data will be actually imported');
        }

        // Check database connection
        if (!$this->checkMyBBDatabase()) {
            return 1;
        }

        // Determine what to import
        $importUsers = $this->option('users') || (!$this->option('categories') && !$this->option('discussions') && !$this->option('replies'));
        $importCategories = $this->option('categories') || (!$this->option('users') && !$this->option('discussions') && !$this->option('replies'));
        $importDiscussions = $this->option('discussions') || (!$this->option('users') && !$this->option('categories') && !$this->option('replies'));
        $importReplies = $this->option('replies') || (!$this->option('users') && !$this->option('categories') && !$this->option('discussions'));

        // Import in order
        if ($importUsers) {
            $this->importUsers();
        }

        if ($importCategories) {
            $this->importCategories();
        }

        if ($importDiscussions) {
            $this->importDiscussions();
        }

        if ($importReplies) {
            $this->importReplies();
        }

        $this->info('MyBB import completed!');
        return 0;
    }

    protected function checkMyBBDatabase(): bool
    {
        try {
            $tables = DB::select("SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = ?", [$this->mybbDb]);
            $tableNames = collect($tables)->pluck('TABLE_NAME')->toArray();

            $requiredTables = ['users', 'forums', 'threads', 'posts'];
            $missingTables = array_diff($requiredTables, $tableNames);

            if (!empty($missingTables)) {
                $this->error('Missing required MyBB tables: ' . implode(', ', $missingTables));
                return false;
            }

            return true;
        } catch (\Exception $e) {
            $this->error('Cannot connect to MyBB database: ' . $e->getMessage());
            return false;
        }
    }

    protected function importUsers()
    {
        $this->info('Importing users...');

        $mybbUsers = DB::select("
            SELECT uid, username, email, regdate, postnum, threadnum, lastactive, avatar
            FROM {$this->mybbDb}.users
            WHERE uid > 0
            ORDER BY uid
        ");

        $bar = $this->output->createProgressBar(count($mybbUsers));
        $bar->start();

        foreach ($mybbUsers as $mybbUser) {
            if (!$this->isDryRun) {
                // Check if user already exists
                $existingUser = User::where('email', $mybbUser->email)->first();

                if (!$existingUser) {
                    $user = User::create([
                        'name' => $mybbUser->username,
                        'full_name' => $mybbUser->username, // Use username as full_name
                        'email' => $mybbUser->email,
                        'username' => $mybbUser->username,
                        'password' => bcrypt(Str::random(32)), // Random password, they'll need to reset
                        'email_verified_at' => now(),
                        'email_verified' => true,
                        'created_at' => Carbon::createFromTimestamp($mybbUser->regdate),
                        'updated_at' => Carbon::createFromTimestamp($mybbUser->lastactive ?: $mybbUser->regdate),
                        'posts_count' => $mybbUser->postnum,
                        'discussions_count' => $mybbUser->threadnum,
                    ]);

                    $this->userMappings[$mybbUser->uid] = $user->id;
                } else {
                    $this->userMappings[$mybbUser->uid] = $existingUser->id;
                }
            }

            $bar->advance();
        }

        $bar->finish();
        $this->line('');
        $this->info('Imported ' . count($mybbUsers) . ' users');
    }

    protected function importCategories()
    {
        $this->info('Importing categories...');

        $mybbForums = DB::select("
            SELECT fid, name, description, threads, posts, disporder, pid
            FROM {$this->mybbDb}.forums
            WHERE active = 1 AND type = 'f'
            ORDER BY disporder, fid
        ");

        $bar = $this->output->createProgressBar(count($mybbForums));
        $bar->start();

        foreach ($mybbForums as $mybbForum) {
            if (!$this->isDryRun) {
                // Check if category already exists
                $existingCategory = DiscussionCategory::where('slug', Str::slug($mybbForum->name))->first();

                if (!$existingCategory) {
                    $category = DiscussionCategory::create([
                        'name' => $mybbForum->name,
                        'slug' => Str::slug($mybbForum->name),
                        'description' => $mybbForum->description ?: null,
                        'color' => 'blue', // Default color
                        'icon' => '💬', // Default icon
                        'sort_order' => $mybbForum->disporder,
                        'discussions_count' => $mybbForum->threads,
                        'replies_count' => $mybbForum->posts,
                        'is_active' => true,
                    ]);

                    $this->categoryMappings[$mybbForum->fid] = $category->id;
                } else {
                    $this->categoryMappings[$mybbForum->fid] = $existingCategory->id;
                }
            }

            $bar->advance();
        }

        $bar->finish();
        $this->line('');
        $this->info('Imported ' . count($mybbForums) . ' categories');
    }

    protected function importDiscussions()
    {
        $this->info('Importing discussions...');

        // Load user and category mappings if not already loaded
        if (empty($this->userMappings)) {
            $this->loadExistingMappings();
        }

        $mybbThreads = DB::select("
            SELECT tid, fid, subject, uid, username, dateline, firstpost, views, replies, sticky, visible, closed
            FROM {$this->mybbDb}.threads
            WHERE visible = 1
            ORDER BY dateline
        ");

        $bar = $this->output->createProgressBar(count($mybbThreads));
        $bar->start();

        foreach ($mybbThreads as $mybbThread) {
            if (!$this->isDryRun) {
                // Skip if we don't have mappings
                if (!isset($this->categoryMappings[$mybbThread->fid]) || !isset($this->userMappings[$mybbThread->uid])) {
                    $bar->advance();
                    continue;
                }

                // Get the first post content
                $firstPost = DB::selectOne("
                    SELECT message
                    FROM {$this->mybbDb}.posts
                    WHERE pid = ? AND visible = 1
                ", [$mybbThread->firstpost]);

                if (!$firstPost) {
                    $bar->advance();
                    continue;
                }

                // Check if discussion already exists
                $slug = Str::slug($mybbThread->subject);
                $existingDiscussion = Discussion::where('slug', $slug)->first();

                if (!$existingDiscussion) {
                    $discussion = Discussion::create([
                        'uuid' => Str::uuid(),
                        'category_id' => $this->categoryMappings[$mybbThread->fid],
                        'user_id' => $this->userMappings[$mybbThread->uid],
                        'title' => $mybbThread->subject,
                        'slug' => $slug,
                        'body' => $this->convertMyBBToHTML($firstPost->message),
                        'views_count' => $mybbThread->views,
                        'replies_count' => $mybbThread->replies,
                        'is_pinned' => $mybbThread->sticky == 1,
                        'is_locked' => $mybbThread->closed != '',
                        'created_at' => Carbon::createFromTimestamp($mybbThread->dateline),
                        'updated_at' => Carbon::createFromTimestamp($mybbThread->dateline),
                        'last_activity_at' => Carbon::createFromTimestamp($mybbThread->dateline),
                    ]);

                    $this->discussionMappings[$mybbThread->tid] = $discussion->id;
                } else {
                    $this->discussionMappings[$mybbThread->tid] = $existingDiscussion->id;
                }
            }

            $bar->advance();
        }

        $bar->finish();
        $this->line('');
        $this->info('Imported ' . count($mybbThreads) . ' discussions');
    }

    protected function importReplies()
    {
        $this->info('Importing replies...');

        // Load existing mappings if not already loaded
        if (empty($this->userMappings) || empty($this->discussionMappings)) {
            $this->loadExistingMappings();
        }

        $mybbPosts = DB::select("
            SELECT pid, tid, uid, username, dateline, message, replyto
            FROM {$this->mybbDb}.posts
            WHERE visible = 1 AND pid NOT IN (
                SELECT firstpost FROM {$this->mybbDb}.threads WHERE firstpost = pid
            )
            ORDER BY dateline
        ");

        $bar = $this->output->createProgressBar(count($mybbPosts));
        $bar->start();

        foreach ($mybbPosts as $mybbPost) {
            if (!$this->isDryRun) {
                // Skip if we don't have mappings
                if (!isset($this->discussionMappings[$mybbPost->tid]) || !isset($this->userMappings[$mybbPost->uid])) {
                    $bar->advance();
                    continue;
                }

                // Check if reply already exists (by content hash to avoid duplicates)
                $contentHash = md5($mybbPost->message);
                $existingReply = DiscussionReply::where('discussion_id', $this->discussionMappings[$mybbPost->tid])
                    ->where('user_id', $this->userMappings[$mybbPost->uid])
                    ->whereRaw('MD5(body) = ?', [$contentHash])
                    ->first();

                if (!$existingReply) {
                    // Handle parent reply if it's a reply to another post
                    $parentId = null;
                    if ($mybbPost->replyto > 0) {
                        // Try to find parent by matching timestamp and discussion
                        $parentReply = DiscussionReply::where('discussion_id', $this->discussionMappings[$mybbPost->tid])
                            ->where('created_at', '>', Carbon::createFromTimestamp($mybbPost->dateline)->subHours(24))
                            ->where('created_at', '<', Carbon::createFromTimestamp($mybbPost->dateline))
                            ->orderBy('created_at', 'desc')
                            ->first();

                        if ($parentReply) {
                            $parentId = $parentReply->id;
                        }
                    }

                    DiscussionReply::create([
                        'discussion_id' => $this->discussionMappings[$mybbPost->tid],
                        'user_id' => $this->userMappings[$mybbPost->uid],
                        'parent_id' => $parentId,
                        'body' => $this->convertMyBBToHTML($mybbPost->message),
                        'created_at' => Carbon::createFromTimestamp($mybbPost->dateline),
                        'updated_at' => Carbon::createFromTimestamp($mybbPost->dateline),
                    ]);
                }
            }

            $bar->advance();
        }

        $bar->finish();
        $this->line('');
        $this->info('Imported ' . count($mybbPosts) . ' replies');
    }

    protected function loadExistingMappings()
    {
        // Load user mappings
        $users = User::all();
        foreach ($users as $user) {
            // Try to find MyBB user by username/email
            $mybbUser = DB::selectOne("SELECT uid FROM {$this->mybbDb}.users WHERE username = ? OR email = ?", [$user->username, $user->email]);
            if ($mybbUser) {
                $this->userMappings[$mybbUser->uid] = $user->id;
            }
        }

        // Load category mappings
        $categories = DiscussionCategory::all();
        foreach ($categories as $category) {
            $mybbForum = DB::selectOne("SELECT fid FROM {$this->mybbDb}.forums WHERE name = ?", [$category->name]);
            if ($mybbForum) {
                $this->categoryMappings[$mybbForum->fid] = $category->id;
            }
        }

        // Load discussion mappings
        $discussions = Discussion::all();
        foreach ($discussions as $discussion) {
            $mybbThread = DB::selectOne("SELECT tid FROM {$this->mybbDb}.threads WHERE subject = ?", [$discussion->title]);
            if ($mybbThread) {
                $this->discussionMappings[$mybbThread->tid] = $discussion->id;
            }
        }
    }

    protected function convertMyBBToHTML(string $content): string
    {
        // Convert MyBB codes to HTML
        $content = html_entity_decode($content);

        // Convert basic MyBB codes
        $conversions = [
            '/\[b\](.*?)\[\/b\]/si' => '<strong>$1</strong>',
            '/\[i\](.*?)\[\/i\]/si' => '<em>$1</em>',
            '/\[u\](.*?)\[\/u\]/si' => '<u>$1</u>',
            '/\[url=(.*?)\](.*?)\[\/url\]/si' => '<a href="$1" target="_blank">$2</a>',
            '/\[url\](.*?)\[\/url\]/si' => '<a href="$1" target="_blank">$1</a>',
            '/\[img\](.*?)\[\/img\]/si' => '<img src="$1" alt="Image" class="max-w-full h-auto">',
            '/\[quote\](.*?)\[\/quote\]/si' => '<blockquote class="border-l-4 border-gray-300 pl-4 italic">$1</blockquote>',
            '/\[quote=(.*?)\](.*?)\[\/quote\]/si' => '<blockquote class="border-l-4 border-gray-300 pl-4 italic"><strong>$1 wrote:</strong><br>$2</blockquote>',
            '/\[code\](.*?)\[\/code\]/si' => '<pre class="bg-gray-100 p-4 rounded"><code>$1</code></pre>',
            '/\[color=(.*?)\](.*?)\[\/color\]/si' => '<span style="color: $1">$2</span>',
            '/\[size=(.*?)\](.*?)\[\/size\]/si' => '<span style="font-size: $1px">$2</span>',
        ];

        foreach ($conversions as $pattern => $replacement) {
            $content = preg_replace($pattern, $replacement, $content);
        }

        // Convert line breaks
        $content = nl2br($content);

        return $content;
    }
}
