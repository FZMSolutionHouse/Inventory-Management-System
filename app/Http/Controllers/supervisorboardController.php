<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class supervisorboardController extends Controller
{
    public function showboard(){
        return view('supervisorboard');
    }
}
