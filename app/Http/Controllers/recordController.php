<?php

namespace App\Http\Controllers;

use App\Models\additem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;




class recordController extends Controller
{
    public function Showrecord(){
        try {
            // Debug: Check if we can connect to database
            $items = additem::all();
            
            // Debug: Add this to see what's being retrieved
            // dd($items); // Uncomment this line to debug
            
            // Calculate statistics
            $totalItems = $items->count();
            $inStockCount = 0;
            $lowStockCount = 0;
            $outOfStockCount = 0;
            
            foreach ($items as $item) {
                if ($item->quantity <= 0) {
                    $outOfStockCount++;
                } elseif ($item->quantity <= $item->minimumStock) {
                    $lowStockCount++;
                } else {
                    $inStockCount++;
                }
            }
            
            return view('records', compact('items', 'totalItems', 'inStockCount', 'lowStockCount', 'outOfStockCount'));
            
        } catch (\Exception $e) {
            // Debug: Show error if something goes wrong
            dd('Error: ' . $e->getMessage());
        }
    }
    
    public function index() {
        return $this->Showrecord();
    }


//Delete Function

    public  function delete_record($id){

                     // additem::destory($id);   work from model
                     
                        DB::table('additem')->where('id',$id)->delete();
                      
                      return back();
    }
    
    //Edit Record

    public function edit_record($id){

        $data = additem::find($id);

        return  view('edit_form',compact('data'));

    }
    
    // Update Data Function - This was incomplete in your original code
    public function update_data(Request $request, $id){
        
        // Validate the request
        $request->validate([
            'itemName' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'minimumStock' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'supplier' => 'required|string|max:255',
        ]);

        try {
            // Find the record
            $data = additem::find($id);
            
            if (!$data) {
                return back()->with('error', 'Item not found');
            }

            // Update the record
            $data->itemName = $request->itemName;
            $data->category = $request->category;
            $data->quantity = $request->quantity;
            $data->minimumStock = $request->minimumStock;
            $data->price = $request->price;
            $data->supplier = $request->supplier;
            
            // Save the updated data
            $data->save();
            
            return redirect('/records')->with('success', 'Item updated successfully!');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating item: ' . $e->getMessage());
        }
    }


/*
     public function shoerecord(){
      
     $records = additem ::all();
      return view('records',compact('records'));

     
     }
    
   */
}