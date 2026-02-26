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
        Schema::create('africoders_ventures', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->longText('content')->nullable();
            $table->string('logo')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('website_url')->nullable();
            $table->text('mission')->nullable();
            $table->text('vision')->nullable();
            $table->string('status')->default('active'); // active, incubating, launched, exited
            $table->integer('launch_year')->nullable();
            $table->text('team_members')->nullable(); // JSON
            $table->text('tech_stack')->nullable(); // JSON
            $table->text('metrics')->nullable(); // JSON for key metrics
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->boolean('featured')->default(false);
            $table->boolean('published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();

            $table->index('slug');
            $table->index('status');
            $table->index('published');
            $table->index('featured');
            $table->index('order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('africoders_ventures');
    }
};
