<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class admininventoryController extends Controller
{
    public function adminpage(){
        return view ('admininventory');
    }
}
