<?php
namespace App\Http\Controllers;
use App\Models\createuser;
use Illuminate\Http\Request;

class recordPremissionController extends Controller
{
    public function sshowrecord($id){
        $user = createuser::find($id);  // Use createuser model, store in $user variable
        return view('Showuserpremission', ['user' => $user]);
    }
}