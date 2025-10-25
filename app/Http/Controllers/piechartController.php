<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class piechartController extends Controller
{
    public function pie(){
        // Fetch data from additem table
        $items = DB::table('additem')
                   ->select('item_name', 'quantity')
                   ->where('quantity', '>', 0) // Only show items with quantity > 0
                   ->get();
        
        return view('charts.piechart', compact('items'));
    }
    
    // Optional: API endpoint to get item details when clicked
    public function getItemDetails($itemName) {
        $itemDetails = DB::table('additem')
                        ->where('item_name', $itemName)
                        ->first();
        
        return response()->json($itemDetails);
    }
}