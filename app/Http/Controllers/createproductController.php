<?php

namespace App\Http\Controllers;
use App\Models\product;
use App\Http\Requests\productRequest;
use Illuminate\Http\Request;

class createproductController extends Controller
{

    
      public function producview(){

        return view('createproduct');
    }
// In ProductController.php
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'detail' => 'required|string',
    ]);
    
    Product::create([
        'name' => $request->name,
        'detail' => $request->detail,
    ]);
    
    return redirect()->route('products.index')->with('success', 'Product created successfully!');
}
}
