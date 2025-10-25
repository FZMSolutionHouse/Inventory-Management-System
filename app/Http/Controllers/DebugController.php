<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\UserProfile;

class DebugController extends Controller
{
    public function checkUserData()
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Not authenticated']);
        }

        // Check what tables exist
        $tables = DB::select('SHOW TABLES');
        $tableNames = array_map(function($table) {
            return array_values((array)$table)[0];
        }, $tables);

        // Try to find user profile data
        $profileData = null;
        $tableUsed = null;
        
        $possibleTables = ['userprofile', 'user_profiles', 'profiles'];
        
        foreach ($possibleTables as $tableName) {
            if (in_array($tableName, $tableNames)) {
                try {
                    $profileData = DB::table($tableName)->where('user_id', $user->id)->first();
                    if ($profileData) {
                        $tableUsed = $tableName;
                        break;
                    }
                } catch (\Exception $e) {
                    // Continue to next table
                }
            }
        }

        // Also try using the model
        $modelData = null;
        try {
            $modelData = UserProfile::where('user_id', $user->id)->first();
        } catch (\Exception $e) {
            $modelData = ['error' => $e->getMessage()];
        }

        return response()->json([
            'authenticated_user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'available_tables' => $tableNames,
            'profile_data_from_db' => $profileData,
            'table_used' => $tableUsed,
            'model_data' => $modelData,
            'model_table_name' => (new UserProfile())->getTable(),
        ]);
    }
    
}