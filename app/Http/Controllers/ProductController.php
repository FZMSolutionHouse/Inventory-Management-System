<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        $products = Product::all();
        return view('Product', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('createproduct');
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'detail' => 'required|string|max:1000',
        ]);

        Product::create([
            'name' => $request->name,
            'detail' => $request->detail,
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified product.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('showProduct', compact('product'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'detail' => 'required|string|max:1000',
        ]);

        $product = Product::findOrFail($id);
        $product->update([
            'name' => $request->name,
            'detail' => $request->detail,
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}