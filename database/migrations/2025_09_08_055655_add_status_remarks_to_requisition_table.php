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
        Schema::table('requisition', function (Blueprint $table) {
            // Add remarks column if it doesn't exist
            if (!Schema::hasColumn('requisition', 'remarks')) {
                $table->text('remarks')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requisition', function (Blueprint $table) {
            if (Schema::hasColumn('requisition', 'remarks')) {
                $table->dropColumn('remarks');
            }
        });
    }
};