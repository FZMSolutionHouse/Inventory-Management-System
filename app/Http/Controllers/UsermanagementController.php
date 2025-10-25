<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsermanagementController extends Controller
{
    public function management(){
        return view('UserManagement');
    }
}
