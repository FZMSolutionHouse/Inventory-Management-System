<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\upload_requisation_form;
use App\Models\Recognition;

class RecognitionPage extends Controller
{
   public function index(){
    return view('/RecognitionPage');
   }
}