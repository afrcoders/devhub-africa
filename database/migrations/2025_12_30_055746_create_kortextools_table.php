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
        Schema::create('kortextools', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('category');
            $table->text('description');
            $table->string('icon')->default('fas fa-tools');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->integer('popularity')->default(0);
            $table->decimal('rating', 3, 1)->default(0.0);
            $table->integer('rating_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->json('properties')->nullable(); // For storing original database properties
            $table->timestamps();

            $table->index(['category', 'is_active']);
            $table->index(['popularity', 'rating']);
            $table->index('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kortextools');
    }
};
