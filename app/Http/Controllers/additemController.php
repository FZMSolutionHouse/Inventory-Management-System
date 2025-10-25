<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\additem;
use Illuminate\Support\Facades\Log;

class additemController extends Controller
{
    /**
     * Show the add inventory form
     */
    public function Showadd()
    {
        return view('addinventory');
    }

    /**
     * Store a new inventory item
     */
    public function item(Request $request)
    {
        try {
            // Log the incoming request data for debugging
            Log::info('Incoming request data:', $request->all());

            // Validate the request data
            $validated = $request->validate([
                'itemName' => 'required|max:100|string',
                'requisition_id' => 'nullable|max:100|string',
                'category' => 'required|max:100|string',
                'category_type' => 'nullable|array',
                'category_type.*' => 'in:Fix,Consumable',
                'location' => 'nullable|max:100|string',
                'quantity' => 'required|integer|min:0',
                'minimumStock' => 'required|integer|min:0',
                'price' => 'required|numeric|min:0',
                'issue' => 'nullable|max:255|string',
                'supplier' => 'required|max:100|string',
            ]);

            Log::info('Validated data:', $validated);

            // Map form field names to database column names
            $dataToSave = [
                'item_name' => $validated['itemName'],
                'requisition_id' => $validated['requisition_id'] ?? null,
                'category' => $validated['category'],
                'category_type' => $validated['category_type'] ?? [], // Keep as array, model will handle JSON conversion
                'location' => $validated['location'] ?? null,
                'quantity' => $validated['quantity'],
                'minimum_stock' => $validated['minimumStock'],
                'price' => $validated['price'],
                'issue' => $validated['issue'] ?? null,
                'supplier' => $validated['supplier'],
            ];

            Log::info('Data to save:', $dataToSave);

            // Create the item using the mapped data
            $item = additem::create($dataToSave);
            Log::info('Item created with ID:', ['id' => $item->id]);

            return redirect()->back()->with('success', 'Item added successfully! ID: ' . $item->id);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed:', $e->errors());
            return redirect()->back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            Log::error('Error saving item:', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Failed to add item: ' . $e->getMessage())->withInput();
        }
    }
}