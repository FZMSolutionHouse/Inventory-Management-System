<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class vegachartController extends Controller
{
    public function vega(){
        return view('charts.vegachart');
    }
}
