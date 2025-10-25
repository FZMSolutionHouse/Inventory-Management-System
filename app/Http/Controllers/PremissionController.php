<?php

namespace App\Http\Controllers;

use App\Models\createuser;  // Import your createuser model
use Illuminate\Http\Request;

class PremissionController extends Controller
{
    public function viewpremission(){
       
       // Use the createuser model to fetch all users
       $createuser = createuser::all();
       
       return view('Premission', compact("createuser"));
    }

    public function delete($id) {
    try {
        $user = createuser::find($id);
        
        if (!$user) {
            session()->flash('error', 'User not found.');
            return redirect()->back();
        }
        
        $user->delete();
        session()->flash('success', 'User deleted successfully.');
        
    } catch (\Exception $e) {
        session()->flash('error', 'Error deleting user: ' . $e->getMessage());
    }
    
    return redirect()->back();
}
}