<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubmissionController extends Controller
{
    public function mySubmissions()
    {
        $debug_info = [];
        $all_submissions = collect();
        
        try {
            // Test different table names
            $tables_to_try = ['requisition', 'requisitions', 'submissions'];
            $working_table = null;
            
            foreach ($tables_to_try as $table) {
                try {
                    $count = DB::table($table)->count();
                    $debug_info[] = "Table '$table': $count records found";
                    
                    if ($count > 0 && !$working_table) {
                        $working_table = $table;
                    }
                } catch (\Exception $e) {
                    $debug_info[] = "Table '$table': Does not exist";
                    continue;
                }
            }
            
            if ($working_table) {
                // Get the data
                $all_submissions = DB::table($working_table)
                    ->limit(10) // Limit for debugging
                    ->get();
                    
                $debug_info[] = "Using table: $working_table";
                $debug_info[] = "Retrieved: " . $all_submissions->count() . " records";
            } else {
                $debug_info[] = "No working table found with data";
            }
            
        } catch (\Exception $e) {
            $debug_info[] = "Database error: " . $e->getMessage();
        }
        
        return view('Submission.mysubmission', compact('all_submissions', 'debug_info'));
    }
}