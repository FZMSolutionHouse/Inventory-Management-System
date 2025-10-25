<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class guestuserController extends Controller
{
    public function showguest(){
        return view('layouts.guestuser');
    }
}
