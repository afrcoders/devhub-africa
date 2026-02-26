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
        if (!Schema::hasTable('course_lessons')) {
            Schema::create('course_lessons', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('module_id');
                $table->string('title');
                $table->text('content');
                $table->string('video_url')->nullable();
                $table->integer('duration_minutes')->default(0);
                $table->integer('order')->default(0);
                $table->timestamps();

                $table->foreign('module_id')->references('id')->on('course_modules')->onDelete('cascade');
                $table->index('module_id');
            });
        } else if (!Schema::hasColumn('course_lessons', 'module_id')) {
            Schema::table('course_lessons', function (Blueprint $table) {
                $table->unsignedBigInteger('module_id')->after('id');
                $table->string('title')->after('module_id');
                $table->text('content')->after('title');
                $table->string('video_url')->nullable()->after('content');
                $table->integer('duration_minutes')->default(0)->after('video_url');
                $table->integer('order')->default(0)->after('duration_minutes');

                $table->foreign('module_id')->references('id')->on('course_modules')->onDelete('cascade');
                $table->index('module_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_lessons');
    }
};
