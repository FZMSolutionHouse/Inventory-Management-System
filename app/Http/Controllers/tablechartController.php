<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Import DB facade

class tablechartController extends Controller
{
    public function chart()
    {
        return view('charts.tablechart');
    }

    public function getTableData()
    {
        $data = DB::table('additem')
                  ->select('item_name', 'quantity', 'price')
                  ->get();

        // Format the data for Google Charts
        $formattedData = [];
        foreach ($data as $row) {
            $formattedData[] = [
                $row->item_name,
                (int)$row->quantity, // Ensure quantity is a number
                (float)$row->price, // Ensure price is a number
            ];
        }

        return response()->json($formattedData);
    }
}