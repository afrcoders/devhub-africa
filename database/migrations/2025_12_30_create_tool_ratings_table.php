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
        Schema::create('tool_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('tool_slug');
            $table->integer('rating')->unsigned(); // 1-5 stars
            $table->timestamps();

            // Composite unique constraint - one rating per user per tool
            $table->unique(['user_id', 'tool_slug']);

            // Index for faster lookups
            $table->index('tool_slug');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tool_ratings');
    }
};
