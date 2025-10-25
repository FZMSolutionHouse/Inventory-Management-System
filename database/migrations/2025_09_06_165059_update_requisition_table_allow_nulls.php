<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('requisition', function (Blueprint $table) {
        $table->string('name')->nullable()->change();
        $table->string('designation')->nullable()->change();
        $table->string('file_path')->nullable()->change();
        $table->text('content')->nullable()->change();
        $table->text('description')->nullable()->change();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
