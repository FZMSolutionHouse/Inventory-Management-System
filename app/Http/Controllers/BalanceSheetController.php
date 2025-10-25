<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BalanceSheet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BalanceSheetController extends Controller
{
    /**
     * Display the balance sheet
     */
    public function index()
    {
        try {
            $currentYear = date('Y') . '-' . (date('Y') + 1);
            
            // Get or create current year's balance sheet
            $balanceSheet = BalanceSheet::where('financial_year', $currentYear)->first();
            
            if (!$balanceSheet) {
                $balanceSheet = new BalanceSheet();
                $balanceSheet->financial_year = $currentYear;
                $balanceSheet->total_inventory_value = BalanceSheet::getCurrentInventoryValue();
                $balanceSheet->save();
            } else {
                // Update inventory value dynamically
                $balanceSheet->total_inventory_value = BalanceSheet::getCurrentInventoryValue();
                $balanceSheet->save();
            }

            // Get inventory items for reference
            $inventoryItems = DB::table('additem')
                ->select('item_name', 'quantity', 'price', 'category')
                ->get();

            return view('balance-sheet', compact('balanceSheet', 'inventoryItems'));

        } catch (\Exception $e) {
            Log::error('Balance Sheet Error: ' . $e->getMessage());
            
            return view('balance-sheet', [
                'balanceSheet' => new BalanceSheet(),
                'inventoryItems' => collect([]),
                'error' => 'Unable to load balance sheet data'
            ]);
        }
    }

    /**
     * Update balance sheet
     */
    public function update(Request $request)
    {
        try {
            $request->validate([
                'financial_year' => 'required|string',
                'office_equipment_cost' => 'numeric|min:0',
                'rent_expenses' => 'numeric|min:0',
                'utility_expenses' => 'numeric|min:0',
                'marketing_expenses' => 'numeric|min:0',
                'maintenance_cost' => 'numeric|min:0',
                'other_expenses' => 'numeric|min:0',
                'total_yearly_fund' => 'numeric|min:0',
                'total_salary_expenses' => 'numeric|min:0',
                'notes' => 'nullable|string|max:1000'
            ]);

            $balanceSheet = BalanceSheet::where('financial_year', $request->financial_year)->first();
            
            if (!$balanceSheet) {
                $balanceSheet = new BalanceSheet();
                $balanceSheet->financial_year = $request->financial_year;
            }

            // Always update inventory value dynamically
            $balanceSheet->total_inventory_value = BalanceSheet::getCurrentInventoryValue();
            
            // Update other fields
            $balanceSheet->office_equipment_cost = $request->office_equipment_cost ?? 0;
            $balanceSheet->rent_expenses = $request->rent_expenses ?? 0;
            $balanceSheet->utility_expenses = $request->utility_expenses ?? 0;
            $balanceSheet->marketing_expenses = $request->marketing_expenses ?? 0;
            $balanceSheet->maintenance_cost = $request->maintenance_cost ?? 0;
            $balanceSheet->other_expenses = $request->other_expenses ?? 0;
            $balanceSheet->total_yearly_fund = $request->total_yearly_fund ?? 0;
            $balanceSheet->total_salary_expenses = $request->total_salary_expenses ?? 0;
            $balanceSheet->notes = $request->notes;

            $balanceSheet->save(); // This will trigger automatic calculations

            return redirect()->route('balance-sheet.index')
                ->with('success', 'Balance sheet updated successfully!');

        } catch (\Exception $e) {
            Log::error('Balance Sheet Update Error: ' . $e->getMessage());
            
            return redirect()->route('balance-sheet.index')
                ->with('error', 'Failed to update balance sheet. Please try again.');
        }
    }
}