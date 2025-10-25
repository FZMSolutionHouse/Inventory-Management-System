<?php

namespace App\Http\Controllers;

use App\Models\createuser;
use Illuminate\Http\Request;

class editshowpremissionController extends Controller
{
    public function edpremission($id){
        $user = createuser::find($id);
        
        if (!$user) {
            return redirect()->route('Premission')->with('error', 'User not found');
        }
        
        return view('Editpremission', compact('user'));
    }
    
    // Add this new method
    public function updatepremission(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:createuser,email,' . $id,
            'password' => 'nullable|min:8'
        ]);
        
        $user = createuser::find($id);
        
        if (!$user) {
            return redirect()->route('Premission')->with('error', 'User not found');
        }
        
        $user->name = $request->name;
        $user->email = $request->email;
        
        // Only update password if provided
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        
        $user->save();
        
        return redirect()->route('Premission')->with('success', 'User updated successfully!');
    }
}