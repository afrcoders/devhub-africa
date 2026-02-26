<?php

namespace Database\Seeders;

use App\Models\Community\Discussion;
use App\Models\Community\DiscussionCategory;
use App\Models\Community\DiscussionReply;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CommunitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create categories
        $categories = [
            [
                'name' => 'General Discussion',
                'slug' => 'general',
                'description' => 'General conversations and introductions',
                'icon' => '💬',
                'order_index' => 1
            ],
            [
                'name' => 'Business & Entrepreneurship',
                'slug' => 'business',
                'description' => 'Share business ideas, get feedback, and network with entrepreneurs',
                'icon' => '💼',
                'order_index' => 2
            ],
            [
                'name' => 'Learning & Development',
                'slug' => 'learning',
                'description' => 'Discuss courses, share learning resources, and study together',
                'icon' => '📚',
                'order_index' => 3
            ],
            [
                'name' => 'Technology & Programming',
                'slug' => 'technology',
                'description' => 'Tech discussions, programming help, and development insights',
                'icon' => '💻',
                'order_index' => 4
            ],
            [
                'name' => 'Career & Professional Growth',
                'slug' => 'career',
                'description' => 'Career advice, job opportunities, and professional development',
                'icon' => '🚀',
                'order_index' => 5
            ],
            [
                'name' => 'Announcements',
                'slug' => 'announcements',
                'description' => 'Official updates and important community announcements',
                'icon' => '📢',
                'order_index' => 0
            ],
            [
                'name' => 'Off-Topic',
                'slug' => 'off-topic',
                'description' => 'Casual conversations and topics outside our main focus',
                'icon' => '☕',
                'order_index' => 6
            ]
        ];

        foreach ($categories as $categoryData) {
            DiscussionCategory::create($categoryData);
        }

        // Create sample discussions if we have users
        $users = User::all();
        if ($users->count() > 0) {
            $generalCategory = DiscussionCategory::where('slug', 'general')->first();
            $businessCategory = DiscussionCategory::where('slug', 'business')->first();
            $techCategory = DiscussionCategory::where('slug', 'technology')->first();
            $announcementsCategory = DiscussionCategory::where('slug', 'announcements')->first();

            $sampleDiscussions = [
                [
                    'category_id' => $announcementsCategory->id,
                    'user_id' => $users->first()->id,
                    'title' => 'Welcome to the Noccea Community!',
                    'body' => "Welcome to our vibrant community! 🎉\n\nThis is a space where entrepreneurs, learners, and innovators come together to:\n\n• Share ideas and get feedback\n• Learn from each other's experiences\n• Build meaningful connections\n• Support each other's growth\n\nFeel free to introduce yourself and let us know what brings you here!\n\nLet's build something amazing together! 💪",
                    'is_pinned' => true
                ],
                [
                    'category_id' => $generalCategory->id,
                    'user_id' => $users->random()->id,
                    'title' => 'Introduce Yourself Here!',
                    'body' => "Hi everyone! 👋\n\nLet's get to know each other better. Please introduce yourself and share:\n\n• Your name and background\n• What you're currently working on\n• Your goals and interests\n• How you found this community\n\nI'm excited to meet all of you!",
                    'is_pinned' => true
                ],
                [
                    'category_id' => $businessCategory->id,
                    'user_id' => $users->random()->id,
                    'title' => 'Startup Ideas for 2026 - What do you think?',
                    'body' => "I've been brainstorming some startup ideas for this year and would love to get your thoughts:\n\n1. **Sustainable food delivery** - Using electric bikes and eco-friendly packaging\n2. **Remote work productivity tools** - Helping teams stay connected and productive\n3. **Local artisan marketplace** - Connecting traditional craftspeople with global buyers\n\nWhich of these resonates with you? Any feedback or suggestions?\n\nWhat startup ideas are you excited about in 2026?"
                ],
                [
                    'category_id' => $techCategory->id,
                    'user_id' => $users->random()->id,
                    'title' => 'Learning Laravel in 2026 - Best Resources?',
                    'body' => "I'm diving deep into Laravel development and looking for the best learning resources available in 2026.\n\nSo far I've found:\n• Laravel documentation (obviously!)\n• Laracasts videos\n• Laravel Daily blog\n\nWhat other resources would you recommend? Any particular YouTube channels, courses, or books that have helped you master Laravel?\n\nAlso, what's the best way to practice - personal projects, contributing to open source, or something else?"
                ],
                [
                    'category_id' => $generalCategory->id,
                    'user_id' => $users->random()->id,
                    'title' => 'Community Guidelines - Let\'s keep this space awesome!',
                    'body' => "To maintain a positive and productive community, let's agree on some basic guidelines:\n\n**✅ DO:**\n• Be respectful and constructive\n• Share knowledge and help others\n• Stay on-topic within categories\n• Search before posting duplicate questions\n• Provide context when asking for help\n\n**❌ DON'T:**\n• Spam or self-promote excessively\n• Share confidential or inappropriate content\n• Engage in personal attacks or harassment\n• Post off-topic content in wrong categories\n\nLet's make this a place where everyone feels welcome to learn and contribute! 🌟"
                ]
            ];

            foreach ($sampleDiscussions as $discussionData) {
                $discussion = Discussion::create([
                    ...$discussionData,
                    'uuid' => Str::uuid(),
                    'slug' => Str::slug($discussionData['title']),
                    'last_activity_at' => now()
                ]);

                // Update category counts
                $discussion->category()->increment('discussions_count');
                $discussion->category()->update(['last_activity_at' => now()]);

                // Add some sample replies
                if ($users->count() > 1) {
                    $replyCount = rand(2, 5);
                    for ($i = 0; $i < $replyCount; $i++) {
                        $reply = $discussion->replies()->create([
                            'user_id' => $users->random()->id,
                            'body' => $this->getRandomReply($discussion->title)
                        ]);

                        $discussion->increment('replies_count');
                        $discussion->category()->increment('replies_count');
                    }
                }
            }
        }
    }

    private function getRandomReply($title): string
    {
        $replies = [
            "Great post! Thanks for sharing this with the community.",
            "I completely agree with your points. This is very insightful.",
            "Thanks for bringing this up. I've been thinking about this too.",
            "This is exactly what I needed to read today. Much appreciated!",
            "Interesting perspective! I'd love to hear more about your experience with this.",
            "Very helpful information. Bookmarking this for future reference.",
            "Count me in! I'm excited to be part of this discussion.",
            "This resonates with me a lot. Thanks for starting this conversation.",
            "Great question! I'm looking forward to seeing what others think.",
            "Welcome to the community! Glad to have you here."
        ];

        return $replies[array_rand($replies)];
    }
}
