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
        if (!Schema::hasTable('lesson_completions')) {
            Schema::create('lesson_completions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('lesson_id');
                $table->timestamp('completed_at')->nullable();
                $table->integer('score')->nullable();
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('lesson_id')->references('id')->on('course_lessons')->onDelete('cascade');
                $table->unique(['user_id', 'lesson_id']);
                $table->index(['user_id', 'lesson_id']);
            });
        } else if (!Schema::hasColumn('lesson_completions', 'user_id')) {
            Schema::table('lesson_completions', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->after('id');
                $table->unsignedBigInteger('lesson_id')->after('user_id');
                $table->timestamp('completed_at')->nullable()->after('lesson_id');
                $table->integer('score')->nullable()->after('completed_at');

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('lesson_id')->references('id')->on('course_lessons')->onDelete('cascade');
                $table->unique(['user_id', 'lesson_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_completions');
    }
};
