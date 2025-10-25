<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\productlocation;
use App\Http\Requests\productlocationRequest;

class addlocationproduceController extends Controller
{
    public function addproduct(){
        return view('addlocationproduct');
    }

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

            return redirect()->back()->with('success', 'Product added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}