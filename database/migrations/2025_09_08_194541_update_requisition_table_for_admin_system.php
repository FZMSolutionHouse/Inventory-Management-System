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
            // Check and modify status column if needed
            if (!Schema::hasColumn('requisition', 'status')) {
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            }
            
            // Check and add remarks column if needed
            if (!Schema::hasColumn('requisition', 'remarks')) {
                $table->text('remarks')->nullable();
            }
            
            // Ensure updated_at column exists
            if (!Schema::hasColumn('requisition', 'updated_at')) {
                $table->timestamp('updated_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requisition', function (Blueprint $table) {
            // Remove columns added in up() method
            if (Schema::hasColumn('requisition', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('requisition', 'remarks')) {
                $table->dropColumn('remarks');
            }
            if (Schema::hasColumn('requisition', 'updated_at')) {
                $table->dropColumn('updated_at');
            }
        });
    }
};