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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('long_description')->nullable();
            $table->string('category');
            $table->string('level'); // Beginner, Intermediate, Advanced
            $table->string('instructor')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->decimal('rating', 3, 1)->default(0);
            $table->integer('reviews')->default(0);
            $table->integer('students')->default(0);
            $table->string('duration')->nullable();
            $table->integer('lessons')->default(0);
            $table->string('image_color')->nullable();
            $table->string('slug')->unique();
            $table->timestamps();

            $table->index('category');
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
