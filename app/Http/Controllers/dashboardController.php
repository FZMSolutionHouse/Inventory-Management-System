<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function chart(){
        try {
            // Fetch chart data for the dashboard
            $itemData = DB::table('additem')
                ->select('item_name', 'quantity', 'category', 'price', 'minimum_stock')
                ->orderBy('quantity', 'desc')
                ->get();

            // Debug: Log the raw data
            Log::info('Raw itemData from database:', ['data' => $itemData->toArray()]);

            // Check if we have data
            if ($itemData->isEmpty()) {
                Log::warning('No data found in additem table');
                
                // Return view with empty data message
                return view('admindashboard', [
                    'chartData' => [],
                    'stockStatusData' => [
                        ['name' => 'In Stock', 'value' => 0, 'color' => '#10B981'],
                        ['name' => 'Low Stock', 'value' => 0, 'color' => '#F59E0B'],
                        ['name' => 'Out of Stock', 'value' => 0, 'color' => '#EF4444']
                    ],
                    'totalItems' => 0,
                    'totalValue' => 0,
                    'lowStockItemsCount' => 0,
                    'categories' => 0,
                    'message' => 'No items found in database'
                ]);
            }

            // Prepare data for the charts
            $chartData = [];
            
            foreach($itemData as $item) {
                $chartData[] = [
                    'itemName' => $item->item_name,
                    'quantity' => (int)$item->quantity,
                    'category' => $item->category,
                    'price' => (float)$item->price,
                    'minimumStock' => (int)$item->minimum_stock
                ];
            }

            // Create stock status data for pie chart
            $stockStatusData = [];
            $inStockItems = 0;
            $lowStockItems = 0;
            $outOfStockItems = 0;
            
            foreach($chartData as $item) {
                if ($item['quantity'] <= 0) {
                    $outOfStockItems++;
                } elseif ($item['quantity'] <= $item['minimumStock']) {
                    $lowStockItems++;
                } else {
                    $inStockItems++;
                }
            }
            
            $stockStatusData = [
                ['name' => 'In Stock', 'value' => $inStockItems, 'color' => '#10B981'],
                ['name' => 'Low Stock', 'value' => $lowStockItems, 'color' => '#F59E0B'],
                ['name' => 'Out of Stock', 'value' => $outOfStockItems, 'color' => '#EF4444']
            ];

            // Calculate dashboard statistics
            $totalItems = count($chartData);
            $totalValue = array_sum(array_map(function($item) {
                return $item['quantity'] * $item['price'];
            }, $chartData));
            $lowStockItemsCount = count(array_filter($chartData, function($item) {
                return $item['quantity'] <= $item['minimumStock'] && $item['quantity'] > 0;
            }));
            $categories = count(array_unique(array_column($chartData, 'category')));

            // Debug: Log the processed data
            Log::info('Processed chartData:', ['data' => $chartData]);
            Log::info('Dashboard Statistics:', [
                'totalItems' => $totalItems,
                'totalValue' => $totalValue,
                'lowStockItems' => $lowStockItemsCount,
                'categories' => $categories
            ]);

            return view('admindashboard', compact(
                'chartData', 
                'stockStatusData',
                'totalItems', 
                'totalValue', 
                'lowStockItemsCount',
                'categories'
            ));

        } catch (\Exception $e) {
            // Log any errors
            Log::error('Dashboard Controller Error:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            // Return view with error message
            return view('admindashboard', [
                'chartData' => [],
                'stockStatusData' => [
                    ['name' => 'In Stock', 'value' => 0, 'color' => '#10B981'],
                    ['name' => 'Low Stock', 'value' => 0, 'color' => '#F59E0B'],
                    ['name' => 'Out of Stock', 'value' => 0, 'color' => '#EF4444']
                ],
                'totalItems' => 0,
                'totalValue' => 0,
                'lowStockItemsCount' => 0,
                'categories' => 0,
                'error' => 'Database connection error. Check logs for details.'
            ]);
        }
    }

    // Add this method to access balance sheet from dashboard
    public function balanceSheet()
    {
        return redirect()->route('balance-sheet.index');
    }
}