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
        Schema::create('requisition', function (Blueprint $table) {
            $table->id();
            
            // Page 1 fields (from uploadfile.blade.php)
            $table->string('name');
            $table->string('designation');
            $table->string('subject');
            $table->string('file_path')->nullable(); // for uploaded file
            
            // Page 2 fields (if you have a second form)
            $table->text('content')->nullable(); // for rich text content
            $table->text('description')->nullable(); // additional description
            $table->string('status')->default('pending'); // pending, approved, rejected
            
            // Progress tracking
            $table->boolean('page1_completed')->default(false);
            $table->boolean('page2_completed')->default(false);
            $table->boolean('fully_completed')->default(false);
            
            // User tracking (optional)
            $table->string('email')->nullable();
            $table->string('user_ip')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requisition');
    }
};