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
            productlocation::create([
                'name' => $request->name,
                'product_name' => $request->product_name,
                'description' => $request->description,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);

            return redirect()->route('loactionproduct')->with('success', 'Product added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}