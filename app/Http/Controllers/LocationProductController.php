<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\productlocation;
use App\Http\Requests\productlocationRequest;

class LocationProductController extends Controller
{
    // Display all products
    public function local()
    {
        $products = productlocation::all();
        return view('loactionproduct', compact('products'));
    }
 
    // Store new product
    public function store(productlocationRequest $request)
{
    try {
        // Store coordinates with full precision (up to 8 decimal places)
        $latitude = round((float) $request->latitude, 8);
        $longitude = round((float) $request->longitude, 8);
        
        productlocation::create([
            'name' => $request->name,
            'product_name' => $request->product_name,
            'description' => $request->description,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);

        return redirect()->route('loactionproduct')->with('success', 'Product added successfully!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
    }
}
}