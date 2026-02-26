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
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('session_token', 64)->unique();
            $table->dateTime('password_changed_at')->nullable();
            $table->string('browser_info')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->dateTime('expires_at');
            $table->longText('data')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('session_token');
            $table->index('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
