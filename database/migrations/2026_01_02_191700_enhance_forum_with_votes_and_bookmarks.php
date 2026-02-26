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
        if (!Schema::hasColumn('forum_questions', 'slug')) {
            Schema::table('forum_questions', function (Blueprint $table) {
                $table->string('slug')->unique()->after('title');
            });
        }

        if (!Schema::hasTable('forum_votes')) {
            Schema::create('forum_votes', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->morphs('voteable');
                $table->integer('vote'); // 1 for upvote, -1 for downvote
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->unique(['user_id', 'voteable_id', 'voteable_type']);
            });
        }

        if (!Schema::hasTable('forum_bookmarks')) {
            Schema::create('forum_bookmarks', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('question_id');
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('question_id')->references('id')->on('forum_questions')->onDelete('cascade');
                $table->unique(['user_id', 'question_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('forum_questions', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
        Schema::dropIfExists('forum_votes');
        Schema::dropIfExists('forum_bookmarks');
    }
};
