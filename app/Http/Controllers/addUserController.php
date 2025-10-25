<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\registration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class addUserController extends Controller
{
    public function showForm(){
        return view('registration');
    }
    
    public function add(RegistrationRequest $request) {
        try {
            // Step 1: Check database connection
            DB::connection()->getPdo();
            
            // Step 2: Check if table exists
            if (!Schema::hasTable('registration')) {
                return back()->withErrors(['error' => 'Database table "registration" does not exist. Please run migrations.'])->withInput();
            }
            
            // Step 3: Check if email already exists (manually)
            $existingUser = DB::table('registration')->where('email', $request->email)->first();
            if ($existingUser) {
                return back()->withErrors(['email' => 'This email is already registered.'])->withInput();
            }
            
            // Step 4: Prepare data
            $userData = [
                'fullname' => $request->fullname,
                'email' => $request->email,
                'password' => Hash::make($request->password), 
                'ConfirmedPassword' => Hash::make($request->confirmedPassword),
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            // Step 5: Try to insert using DB facade first
            $inserted = DB::table('registration')->insert($userData);
            
            if ($inserted) {
                return redirect()->route('registration.form')->with('success', 'Registration successful! You can now login with your credentials.');
            } else {
                return back()->withErrors(['error' => 'Failed to insert data into database.'])->withInput();
            }
            
        } catch (\PDOException $e) {
            // Database connection error
            return back()->withErrors(['error' => 'Database connection failed: ' . $e->getMessage()])->withInput();
            
        } catch (\Illuminate\Database\QueryException $e) {
            // SQL query error
            return back()->withErrors(['error' => 'Database query failed: ' . $e->getMessage()])->withInput();
            
        } catch (\Exception $e) {
            // General error with detailed message for debugging
            return back()->withErrors(['error' => 'Registration failed: ' . $e->getMessage() . ' (Line: ' . $e->getLine() . ')'])->withInput();
        }
    }
    
    public function login(Request $request){
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->route('adminmaster');
        }
        
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
    
    public function adminpage(){
        if(Auth::check()){
            return view('layouts.adminmaster');
        } else {
            return redirect()->route('login');
        }
    }
}