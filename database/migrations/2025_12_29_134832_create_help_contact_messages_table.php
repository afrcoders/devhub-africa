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
        Schema::create('help_contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->enum('type', ['support', 'business', 'legal', 'other'])->default('support');
            $table->string('subject');
            $table->longText('message');
            $table->enum('status', ['open', 'replied', 'resolved', 'spam'])->default('open');
            $table->text('admin_notes')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->json('meta')->nullable(); // For additional metadata like referrer, etc.
            $table->timestamps();

            $table->index(['status', 'type']);
            $table->index('created_at');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('help_contact_messages');
    }
};
