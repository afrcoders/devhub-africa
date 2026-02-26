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
        // First, drop the primary key on email
        \DB::statement('ALTER TABLE password_reset_tokens DROP PRIMARY KEY');

        Schema::table('password_reset_tokens', function (Blueprint $table) {
            // Add new columns
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('password_reset_tokens', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            if (Schema::hasColumn('password_reset_tokens', 'id')) {
                $table->dropColumn('id');
            }
            if (Schema::hasColumn('password_reset_tokens', 'user_id')) {
                $table->dropColumn('user_id');
            }
            if (Schema::hasColumn('password_reset_tokens', 'expires_at')) {
                $table->dropColumn('expires_at');
            }
            if (Schema::hasColumn('password_reset_tokens', 'updated_at')) {
                $table->dropColumn('updated_at');
            }
        });

        // Restore email as primary key
        \DB::statement('ALTER TABLE password_reset_tokens ADD PRIMARY KEY (email)');
    }
};
