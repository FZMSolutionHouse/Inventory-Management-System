<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BalanceSheet extends Model
{
    use HasFactory;

    protected $table = 'balance_sheet';

    protected $fillable = [
        'financial_year',
        'total_inventory_value',
        'office_equipment_cost',
        'rent_expenses',
        'utility_expenses',
        'marketing_expenses',
        'maintenance_cost',
        'other_expenses',
        'total_yearly_fund',
        'total_salary_expenses',
        'calculated_total_cost',
        'remaining_balance',
        'notes'
    ];

    protected $casts = [
        'total_inventory_value' => 'decimal:2',
        'office_equipment_cost' => 'decimal:2',
        'rent_expenses' => 'decimal:2',
        'utility_expenses' => 'decimal:2',
        'marketing_expenses' => 'decimal:2',
        'maintenance_cost' => 'decimal:2',
        'other_expenses' => 'decimal:2',
        'total_yearly_fund' => 'decimal:2',
        'total_salary_expenses' => 'decimal:2',
        'calculated_total_cost' => 'decimal:2',
        'remaining_balance' => 'decimal:2'
    ];

    /**
     * Get current inventory value from additem table
     */
    public static function getCurrentInventoryValue()
    {
       // CORRECT - just sum the prices
return DB::table('additem')->sum('price');
    }

    /**
     * Calculate total costs automatically
     */
    public function calculateTotalCost()
    {
        return $this->total_inventory_value + 
               $this->office_equipment_cost + 
               $this->rent_expenses + 
               $this->utility_expenses + 
               $this->marketing_expenses + 
               $this->maintenance_cost + 
               $this->other_expenses + 
               $this->total_salary_expenses;
    }

    /**
     * Calculate remaining balance automatically
     */
    public function calculateRemainingBalance()
    {
        return $this->total_yearly_fund - $this->calculateTotalCost();
    }

    /**
     * Save with automatic calculations
     */
    public function save(array $options = [])
    {
        $this->calculated_total_cost = $this->calculateTotalCost();
        $this->remaining_balance = $this->calculateRemainingBalance();
        
        return parent::save($options);
    }
}