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
        if (!Schema::hasTable('course_modules')) {
            Schema::create('course_modules', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('course_id');
                $table->string('title');
                $table->text('description')->nullable();
                $table->integer('order')->default(0);
                $table->timestamps();

                $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
                $table->index('course_id');
            });
        } else if (!Schema::hasColumn('course_modules', 'course_id')) {
            Schema::table('course_modules', function (Blueprint $table) {
                $table->unsignedBigInteger('course_id')->after('id');
                $table->string('title')->after('course_id');
                $table->text('description')->nullable()->after('title');
                $table->integer('order')->default(0)->after('description');

                $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
                $table->index('course_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_modules');
    }
};
