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
        Schema::table('users', function (Blueprint $table) {
            // Add facebook_id if it doesn't exist
            if (!Schema::hasColumn('users', 'facebook_id')) {
                $table->string('facebook_id')->nullable()->after('github_id');
            }

            // Add twitter_id if it doesn't exist
            if (!Schema::hasColumn('users', 'twitter_id')) {
                $table->string('twitter_id')->nullable()->after('facebook_id');
            }

            // Add linkedin_id if it doesn't exist
            if (!Schema::hasColumn('users', 'linkedin_id')) {
                $table->string('linkedin_id')->nullable()->after('twitter_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'facebook_id')) {
                $table->dropColumn('facebook_id');
            }
            if (Schema::hasColumn('users', 'twitter_id')) {
                $table->dropColumn('twitter_id');
            }
            if (Schema::hasColumn('users', 'linkedin_id')) {
                $table->dropColumn('linkedin_id');
            }
        });
    }
};
