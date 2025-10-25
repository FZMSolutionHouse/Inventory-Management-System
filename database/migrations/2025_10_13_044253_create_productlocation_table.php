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
        Schema::create('productlocation', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('product_name');
            $table->text('description')->nullable();
            $table->decimal('latitude', 10, 8);  // Allows range -90 to 90
            $table->decimal('longitude', 11, 8); // Allows range -180 to 180
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productlocation');
    }
};
