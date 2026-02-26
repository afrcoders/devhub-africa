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
        if (!Schema::hasTable('forum_questions')) {
            Schema::create('forum_questions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('course_id')->nullable();
                $table->string('title');
                $table->text('body');
                $table->integer('views')->default(0);
                $table->integer('votes')->default(0);
                $table->timestamp('answered_at')->nullable();
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
                $table->index(['course_id', 'created_at']);
            });
        }

        if (!Schema::hasTable('forum_answers')) {
            Schema::create('forum_answers', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('question_id');
                $table->text('body');
                $table->integer('votes')->default(0);
                $table->boolean('is_accepted')->default(false);
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('question_id')->references('id')->on('forum_questions')->onDelete('cascade');
                $table->index(['question_id', 'is_accepted']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_answers');
        Schema::dropIfExists('forum_questions');
    }
};
