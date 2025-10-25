<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
class supervisorController extends Controller
{
    public function superview(){
        return view('layouts.supervisormaster');
    }
}
