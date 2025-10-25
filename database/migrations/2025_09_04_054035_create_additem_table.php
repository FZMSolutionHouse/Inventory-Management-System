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
        Schema::create('additem', function (Blueprint $table) {
            $table->id();
            $table->string('item_name');
            $table->string('requisition_id')->nullable();
            $table->string('category');
            $table->json('category_type')->nullable(); // Changed from ENUM to JSON
            $table->string('location')->nullable();
            $table->integer('quantity');
            $table->integer('minimum_stock');
            $table->decimal('price', 10, 2);
            $table->text('issue')->nullable();
            $table->string('supplier');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('additem');
    }
};