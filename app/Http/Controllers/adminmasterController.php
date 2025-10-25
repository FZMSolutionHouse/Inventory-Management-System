<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class adminmasterController extends Controller
{
    public function __construct()
    {
        // Share user data with all views that extend adminmaster
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $userData = $this->getUserData();
                $view->with('userData', $userData);
            }
        });
    }

    public function showadminmaster()
    {
        $userData = $this->getUserData();
        return view('layouts.adminmaster', compact('userData'));
    }

    private function getUserData()
    {
        $userData = [
            'name' => 'Guest User',
            'role' => 'Guest',
            'image' => 'https://i.pravatar.cc/40',
            'hasProfile' => false
        ];
        
        if (Auth::check()) {
            $user = Auth::user();
            
            try {
                // Direct DB query to userprofile table (as seen in your screenshot)
                $userProfile = DB::table('userprofile')
                    ->where('user_id', $user->id)
                    ->first();
                
                Log::info('AdminMaster getUserData:', [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'profile_found' => $userProfile ? 'Yes' : 'No',
                    'profile_data' => $userProfile ? (array)$userProfile : null
                ]);
                
                if ($userProfile) {
                    $userData = [
                        'name' => !empty($userProfile->name) ? $userProfile->name : $user->name,
                        'role' => !empty($userProfile->role) ? $userProfile->role : 'No Role',
                        'image' => !empty($userProfile->image) 
                            ? asset('storage/' . $userProfile->image) 
                            : 'https://i.pravatar.cc/40',
                        'hasProfile' => true
                    ];
                } else {
                    // Fallback to user table data
                    $userData = [
                        'name' => $user->name,
                        'role' => 'No Role',
                        'image' => 'https://i.pravatar.cc/40',
                        'hasProfile' => false
                    ];
                }
                
                Log::info('Final userData for top bar:', $userData);
                
            } catch (\Exception $e) {
                Log::error('Error fetching user profile: ' . $e->getMessage());
                
                // Fallback to basic user data
                $userData = [
                    'name' => $user->name,
                    'role' => 'No Role', 
                    'image' => 'https://i.pravatar.cc/40',
                    'hasProfile' => false
                ];
            }
        }
        
        return $userData;
    }
}