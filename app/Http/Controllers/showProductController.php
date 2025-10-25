<?php

namespace App\Http\Controllers;
use App\Models\product;
use Illuminate\Http\Request;

class showProductController extends Controller
{
     public function sshowrecordpro($id){
        // findOrFail will automatically return a 404 page if the ID is not found.
        $product = product::findOrFail($id);
        
        return view('ShowProduct', ['product' => $product]);
    }
}