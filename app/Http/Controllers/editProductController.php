<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;

class editProductController extends Controller
{
     public function edproduct($id){
        $user = product::find($id);
        
        if (!$user) {
            return redirect()->route('product')->with('error', 'User not found');
        }
        
        return view('Editproduct', compact('user'));
    }
    
    // Add this new method
    public function updateproduct(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'detail'=>'required|string|max:255',
        ]);
        
        $user = product::find($id);
        
        if (!$user) {
            return redirect()->route('product')->with('error', 'User not found');
        }
        
        $user->name = $request->name;
        $user->detail = $request->detail;
        
       
        $user->save();
        
        return redirect()->route('Premission')->with('success', 'User updated successfully!');
    }
}
