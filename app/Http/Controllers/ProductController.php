<?php

namespace App\Http\Controllers;

use App\Models\product;  // Import your createuser model
use Illuminate\Http\Request;

class ProductController extends Controller
{
    
    public function viewproduct(){

     
       // Use the  model to fetch all users
       $products = product::all();
       
       return view('product', compact("products"));
    }

    
    public function delete($id) {
    try {
        $products = product::find($id);
        
        if (!$products) {
            session()->flash('error', 'User not found.');
            return redirect()->back();
        }
        
        $products->delete();
        session()->flash('success', 'User deleted successfully.');
        
    } catch (\Exception $e) {
        session()->flash('error', 'Error deleting user: ' . $e->getMessage());
    }
    
    return redirect()->back();
    
}
}