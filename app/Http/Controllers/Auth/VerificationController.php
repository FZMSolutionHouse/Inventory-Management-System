<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeMail;
use Carbon\Carbon;

class VerificationController extends Controller
{
    /**
     * Show verification code form
     */
    public function show()
    {
        // Check if there's a user pending verification
        if (!session('user_id_pending_verification')) {
            return redirect()->route('login')
                ->with('error', 'No verification pending. Please login first.');
        }

        return view('auth.verify');
    }

    /**
     * Verify the code
     */
    public function verify(Request $request)
    {
        $request->validate([
            'verification_code' => 'required|numeric|digits:6',
        ]);

        $userId = session('user_id_pending_verification');
        
        if (!$userId) {
            return redirect()->route('login')
                ->with('error', 'Session expired. Please login again.');
        }

        // Get user from createuser table
        $user = DB::table('createuser')->where('id', $userId)->first();

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'User not found. Please login again.');
        }

        // Check if code has expired
        if (Carbon::now()->greaterThan(Carbon::parse($user->verification_code_expires_at))) {
            return back()->with('error', 'Verification code has expired. Please login again.');
        }

        // Verify the code
        if ($user->verification_code == $request->verification_code) {
            // Mark as verified
            DB::table('createuser')
                ->where('id', $user->id)
                ->update([
                    'is_verified' => true,
                    'verification_code' => null,
                    'verification_code_expires_at' => null,
                    'updated_at' => Carbon::now()
                ]);

            // Log the user in manually
            Auth::loginUsingId($user->id);
            
            // Clear session
            session()->forget('user_id_pending_verification');
            
                return redirect('/admindashboard')->with('success', 'Login successful!');
        }

        return back()->with('error', 'Invalid verification code. Please try again.');
    }

    /**
     * Resend verification code
     */
    public function resend(Request $request)
    {
        $userId = session('user_id_pending_verification');
        
        if (!$userId) {
            return redirect()->route('login')
                ->with('error', 'Session expired. Please login again.');
        }

        // Get user from createuser table
        $user = DB::table('createuser')->where('id', $userId)->first();

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'User not found. Please login again.');
        }

        // Generate new verification code
        $verificationCode = rand(100000, 999999);
        
        // Update user with new code
        DB::table('createuser')
            ->where('id', $user->id)
            ->update([
                'verification_code' => $verificationCode,
                'verification_code_expires_at' => Carbon::now()->addMinutes(10),
                'updated_at' => Carbon::now()
            ]);
        
        // Send new code via email
        try {
            Mail::to($user->email)->send(new VerificationCodeMail($verificationCode, $user));
            return back()->with('success', 'New verification code sent to your email!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send verification code. Please try again.');
        }
    }
}