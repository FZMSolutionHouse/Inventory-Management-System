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
        Schema::create('balance_sheet', function (Blueprint $table) {
            $table->id();
            $table->string('financial_year', 10); // e.g., "2024-2025"
            $table->decimal('total_inventory_value', 15, 2)->default(0);
            $table->decimal('office_equipment_cost', 15, 2)->default(0);
            $table->decimal('rent_expenses', 15, 2)->default(0);
            $table->decimal('utility_expenses', 15, 2)->default(0);
            $table->decimal('marketing_expenses', 15, 2)->default(0);
            $table->decimal('maintenance_cost', 15, 2)->default(0);
            $table->decimal('other_expenses', 15, 2)->default(0);
            $table->decimal('total_yearly_fund', 15, 2)->default(0);
            $table->decimal('total_salary_expenses', 15, 2)->default(0);
            $table->decimal('calculated_total_cost', 15, 2)->default(0);
            $table->decimal('remaining_balance', 15, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balance_sheet');
    }
};