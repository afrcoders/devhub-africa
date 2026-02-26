<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Discussion categories
        Schema::create('discussion_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->text('description')->nullable();
            $table->string('icon', 100)->nullable();
            $table->integer('order_index')->default(0);
            $table->integer('discussions_count')->default(0);
            $table->integer('replies_count')->default(0);
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamps();
        });

        // Discussions/topics
        Schema::create('discussions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('category_id')->constrained('discussion_categories')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('body');
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_locked')->default(false);
            $table->integer('views_count')->default(0);
            $table->integer('replies_count')->default(0);
            $table->integer('upvotes_count')->default(0);
            $table->integer('downvotes_count')->default(0);
            $table->unsignedBigInteger('best_reply_id')->nullable();
            $table->timestamp('last_activity_at');
            $table->timestamps();

            $table->index(['category_id', 'is_pinned', 'last_activity_at']);
            $table->fullText(['title', 'body']);
        });

        // Discussion replies
        Schema::create('discussion_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discussion_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('discussion_replies')->onDelete('cascade');
            $table->text('body');
            $table->integer('upvotes_count')->default(0);
            $table->integer('downvotes_count')->default(0);
            $table->boolean('is_best_answer')->default(false);
            $table->timestamps();

            $table->index(['discussion_id', 'created_at']);
        });

        // Votes for discussions and replies
        Schema::create('discussion_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('votable_type'); // 'discussion' or 'reply'
            $table->unsignedBigInteger('votable_id');
            $table->enum('vote_type', ['upvote', 'downvote']);
            $table->timestamps();

            $table->unique(['user_id', 'votable_type', 'votable_id']);
            $table->index(['votable_type', 'votable_id']);
        });

        // User reputation and points
        Schema::create('user_community_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('points')->default(0);
            $table->integer('discussions_count')->default(0);
            $table->integer('replies_count')->default(0);
            $table->integer('upvotes_received')->default(0);
            $table->integer('downvotes_received')->default(0);
            $table->integer('best_answers_count')->default(0);
            $table->timestamps();

            $table->unique('user_id');
        });

        // User badges/achievements
        Schema::create('community_badges', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->text('description');
            $table->string('icon', 255);
            $table->integer('points_required')->default(0);
            $table->string('criteria_type')->default('points'); // points, discussions, replies, etc.
            $table->integer('criteria_value')->default(0);
            $table->timestamps();
        });

        // User earned badges
        Schema::create('user_community_badges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('badge_id')->constrained('community_badges')->onDelete('cascade');
            $table->timestamp('awarded_at');

            $table->unique(['user_id', 'badge_id']);
        });

        // Discussion bookmarks/favorites
        Schema::create('discussion_bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('discussion_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['user_id', 'discussion_id']);
        });

        // Add foreign key constraint for best_reply_id after discussion_replies table exists
        Schema::table('discussions', function (Blueprint $table) {
            $table->foreign('best_reply_id')->references('id')->on('discussion_replies')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discussion_bookmarks');
        Schema::dropIfExists('user_community_badges');
        Schema::dropIfExists('community_badges');
        Schema::dropIfExists('user_community_stats');
        Schema::dropIfExists('discussion_votes');
        Schema::dropIfExists('discussion_replies');
        Schema::dropIfExists('discussions');
        Schema::dropIfExists('discussion_categories');
    }
};
