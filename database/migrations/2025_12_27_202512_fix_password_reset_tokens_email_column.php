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
        Schema::table('password_reset_tokens', function (Blueprint $table) {
            // Make email column nullable
            \DB::statement('ALTER TABLE password_reset_tokens MODIFY email VARCHAR(255) NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('password_reset_tokens', function (Blueprint $table) {
            // Revert email column to non-nullable
            \DB::statement('ALTER TABLE password_reset_tokens MODIFY email VARCHAR(255) NOT NULL');
        });
    }
};
