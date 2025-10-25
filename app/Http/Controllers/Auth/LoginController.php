<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\VerificationCodeMail;
use Carbon\Carbon;

class LoginController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login attempt
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Find user in createuser table
        $user = DB::table('createuser')
            ->where('email', $request->email)
            ->first();

        // Check if user exists and password is correct
        if ($user && Hash::check($request->password, $user->password)) {
            
            // Check if two-factor authentication is enabled
            if ($user->two_factor_enabled) {
                // Generate 6-digit verification code
                $verificationCode = rand(100000, 999999);
                
                // Update user with verification code
                DB::table('createuser')
                    ->where('id', $user->id)
                    ->update([
                        'verification_code' => $verificationCode,
                        'verification_code_expires_at' => Carbon::now()->addMinutes(10),
                        'is_verified' => false,
                        'updated_at' => Carbon::now()
                    ]);
                
                // Send verification code via email
                try {
                    Mail::to($user->email)->send(new VerificationCodeMail($verificationCode, $user));
                } catch (\Exception $e) {
                    return back()->with('error', 'Failed to send verification code. Please check your email configuration.');
                }
                
                // Store user ID in session for verification
                session(['user_id_pending_verification' => $user->id]);
                
                return redirect()->route('verification.show')
                    ->with('success', 'Verification code sent to your email!');
            } else {
                // Two-factor is disabled, log in directly
                Auth::loginUsingId($user->id);
                
                // Set last activity time for session timeout
                session(['last_activity' => time()]);
                
                return redirect('/admindashboard')->with('success', 'Login successful!');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }

    /**
     * Check if session is still active
     */
    public function checkSession(Request $request)
    {
        if (Auth::check()) {
            $lastActivity = session('last_activity', time());
            $timeout = config('session.lifetime') * 60; // Convert minutes to seconds
            
            if ((time() - $lastActivity) > $timeout) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return response()->json(['status' => 'expired']);
            }
            
            // Update last activity
            session(['last_activity' => time()]);
            return response()->json(['status' => 'active']);
        }
        
        return response()->json(['status' => 'unauthenticated']);
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login');
    }
}