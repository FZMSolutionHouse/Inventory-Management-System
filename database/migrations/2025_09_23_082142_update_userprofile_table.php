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
        Schema::table('userprofile', function (Blueprint $table) {
            // Add user_id column if it doesn't exist
            if (!Schema::hasColumn('userprofile', 'user_id')) {
                $table->unsignedBigInteger('user_id')->after('id');
                $table->index('user_id');
            }
            
            // Add timestamps if they don't exist
            if (!Schema::hasColumn('userprofile', 'created_at')) {
                $table->timestamps();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('userprofile', function (Blueprint $table) {
            $table->dropColumn(['user_id']);
            $table->dropTimestamps();
        });
    }
};