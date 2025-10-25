<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class intervalchartController extends Controller
{
    public function interval(){
        // Fetch data from additem table, ordered by quantity descending to show highest stock items first
        $items = DB::table('additem')
                   ->select('id', 'item_name', 'quantity', 'minimum_stock', 'category', 'price', 'location', 'supplier')
                   ->where('quantity', '>', 0) // Only show items with stock
                   ->orderBy('quantity', 'desc')
                   ->limit(10) // Limit to top 10 items for better visualization
                   ->get();
        
        return view('charts.intervalchart', compact('items'));
    }
    
    // Optional: API endpoint to get stock analysis
    public function getStockAnalysis() {
        $analysis = DB::table('additem')
                     ->select(
                         DB::raw('COUNT(*) as total_items'),
                         DB::raw('SUM(quantity) as total_stock'),
                         DB::raw('AVG(quantity) as avg_stock'),
                         DB::raw('COUNT(CASE WHEN quantity <= minimum_stock THEN 1 END) as low_stock_items'),
                         DB::raw('SUM(quantity * price) as total_value')
                     )
                     ->first();
        
        return response()->json($analysis);
    }
}