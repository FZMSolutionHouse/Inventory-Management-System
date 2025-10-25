<?php

namespace App\Http\Controllers;

use Illuminate\Http\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function getUserData()
    {
        $user = Auth::user();
        
        if (!$user) {
            return null;
        }
        
        // Get user profile
        $userProfile = DB::table('user_profiles')
            ->where('user_id', $user->id)
            ->first();
        
        // Get user role
        $userRole = DB::table('model_has_roles')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('model_has_roles.model_id', $user->id)
            ->first();
        
        return [
            'name' => $userProfile ? $userProfile->name : $user->name,
            'role' => $userRole ? $userRole->name : 'No Role',
            'image' => $userProfile ? $userProfile->image : null,
            'email' => $userProfile ? $userProfile->email : $user->email
        ];
    }
}