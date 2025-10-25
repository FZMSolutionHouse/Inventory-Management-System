<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Psy\CodeCleaner\ReturnTypePass;

class logoutController extends Controller
{
    public function rollback(){
        return view('/logout');
    }
}
