<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\UserProfile;
use App\Models\User;
use App\Models\EmailTemplate;
use App\Models\EmailLog;
use App\Mail\CustomEmail;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class SettingController extends Controller
{
    /**
     * Display the settings page
     */
    public function index()
    {
        $user = Auth::user();
        $userProfile = null;
        $employees = [];
        
        if ($user) {
            // Get user profile data
            $userProfile = UserProfile::where('user_id', $user->id)->first();
            
            // Get all employees for email functionality - FOR SUGGESTIONS ONLY
            $employees = User::select('id', 'name', 'email')
                ->where('id', '!=', $user->id) // Exclude current user
                ->whereNotNull('email') // Ensure email exists
                ->where('email', '!=', '') // Ensure email is not empty
                ->orderBy('name')
                ->get()
                ->map(function($employee) {
                    // Generate avatar initials
                    $nameParts = explode(' ', trim($employee->name));
                    $initials = '';
                    if (count($nameParts) >= 2) {
                        $initials = strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[1], 0, 1));
                    } else {
                        $initials = strtoupper(substr($employee->name, 0, 2));
                    }
                    
                    return [
                        'id' => $employee->id,
                        'name' => $employee->name,
                        'email' => $employee->email,
                        'avatar' => $initials
                    ];
                });
            
            Log::info('Settings page data:', [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'profile_exists' => $userProfile ? true : false,
                'employees_count' => $employees->count(),
            ]);
        }
        
        return view('setting', compact('userProfile', 'employees'));
    }

    /**
     * Send email to any email address - UPDATED TO ALLOW ANY EMAIL
     */
    public function sendEmail(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->back()->with('error', 'User not authenticated.');
        }
        
        // Debug incoming request
        Log::info('Email send request:', [
            'recipients' => $request->input('recipients'),
            'subject' => $request->input('subject'),
            'content_length' => strlen($request->input('content', '')),
        ]);
        
        // Validate the request
        $validatedData = $request->validate([
            'recipients' => 'required|string|min:1',
            'subject' => 'required|string|max:255|min:1',
            'content' => 'required|string|min:1'
        ], [
            'recipients.required' => 'Please select at least one recipient.',
            'recipients.min' => 'Please select at least one recipient.',
            'subject.required' => 'Subject is required.',
            'subject.min' => 'Subject cannot be empty.',
            'content.required' => 'Message content is required.',
            'content.min' => 'Message content cannot be empty.'
        ]);

        try {
            // Parse and validate recipients - ALLOW ANY VALID EMAIL
            $recipientEmails = array_filter(
                array_map('trim', explode(',', $validatedData['recipients'])), 
                function($email) {
                    return !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL);
                }
            );
            
            Log::info('Parsed recipient emails:', $recipientEmails);
            
            if (empty($recipientEmails)) {
                return redirect()->back()
                    ->with('error', 'No valid email addresses found. Please check the recipient emails.')
                    ->withInput();
            }

            // Prepare email data
            $emailData = [
                'sender_name' => $user->name,
                'sender_email' => $user->email,
                'subject' => $validatedData['subject'],
                'content' => $validatedData['content']
            ];

            // Send emails to all valid email addresses
            $successCount = 0;
            $failedCount = 0;
            $failedEmails = [];

            foreach ($recipientEmails as $recipientEmail) {
                try {
                    Mail::to($recipientEmail)->send(new CustomEmail($emailData));
                    $successCount++;
                    Log::info('Email sent successfully to: ' . $recipientEmail);
                    
                    // Optional: Log email activity
                    $this->logEmailActivity($user->id, $recipientEmail, $validatedData['subject'], 'sent');
                    
                } catch (\Exception $emailError) {
                    Log::error('Failed to send email to: ' . $recipientEmail, [
                        'error' => $emailError->getMessage(),
                        'user_id' => $user->id
                    ]);
                    $failedCount++;
                    $failedEmails[] = $recipientEmail;
                    
                    // Optional: Log email failure
                    $this->logEmailActivity($user->id, $recipientEmail, $validatedData['subject'], 'failed');
                }
            }

            // Prepare response message
            if ($successCount > 0) {
                $message = "Successfully sent email to {$successCount} recipient(s).";
                if ($failedCount > 0) {
                    $message .= " Failed to send to {$failedCount} recipient(s): " . implode(', ', $failedEmails);
                }
                return redirect()->back()->with('success', $message);
            } else {
                return redirect()->back()
                    ->with('error', 'Failed to send email to any recipients. Please check your email configuration.')
                    ->withInput();
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Email Send Error: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'stack_trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->with('error', 'Failed to send email. Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Log email activity (optional)
     */
    private function logEmailActivity($userId, $recipientEmail, $subject, $status)
    {
        try {
            // You can create an EmailLog model to track email activities
            // For now, just using Laravel's log
            Log::info('Email Activity:', [
                'user_id' => $userId,
                'recipient' => $recipientEmail,
                'subject' => $subject,
                'status' => $status,
                'timestamp' => now()
            ]);
        } catch (\Exception $e) {
            // Don't fail the main operation if logging fails
            Log::warning('Failed to log email activity: ' . $e->getMessage());
        }
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->back()->with('error', 'User not authenticated.');
        }
        
        // Validate the request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required', 
                'email', 
                Rule::unique('userprofile', 'email')->ignore($user->id, 'user_id')
            ],
            'phonenumber' => 'required|string|max:20',
            'role' => 'required|string|max:100',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);

        try {
            // Prepare data for saving
            $profileData = [
                'user_id' => $user->id,
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'phonenumber' => $validatedData['phonenumber'],
                'role' => $validatedData['role'],
            ];

            // Handle profile image upload
            if ($request->hasFile('profile_image')) {
                // Find existing profile to delete old image
                $existingProfile = UserProfile::where('user_id', $user->id)->first();
                
                if ($existingProfile && $existingProfile->image && Storage::disk('public')->exists($existingProfile->image)) {
                    Storage::disk('public')->delete($existingProfile->image);
                }
                
                // Store new image
                $imagePath = $request->file('profile_image')->store('profile_images', 'public');
                $profileData['image'] = $imagePath;
            }

            // Use updateOrCreate to handle both insert and update
            $userProfile = UserProfile::updateOrCreate(
                ['user_id' => $user->id], // Search condition
                $profileData // Data to update or insert
            );
            
            if ($userProfile) {
                Log::info('Profile saved successfully for user_id: ' . $user->id, $profileData);
                return redirect()->back()->with('success', 'Profile updated successfully!');
            } else {
                Log::error('Failed to save profile for user_id: ' . $user->id);
                return redirect()->back()->with('error', 'Failed to save profile data.');
            }
            
        } catch (\Exception $e) {
            Log::error('Profile Update Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Failed to update profile. Error: ' . $e->getMessage());
        }
    }


    /* Toggle functionality*/ 

  public function toggleTwoFactor(Request $request)
{
    $user = Auth::user();
    
    if (!$user) {
        return redirect()->back()->with('error', 'User not authenticated.');
    }
    
    try {
        // Validate input
        $request->validate([
            'enable_2fa' => 'required|in:0,1'
        ]);
        
        $enable2FA = $request->input('enable_2fa') === '1';
        
        // Use DB transaction for safety
        DB::beginTransaction();
        
        try {
            // THIS IS THE KEY LINE - MUST BE 'createuser' NOT 'users'
            $updated = DB::table('createuser')
                ->where('id', $user->id)
                ->update([
                    'two_factor_enabled' => $enable2FA,
                    'two_factor_enabled_at' => $enable2FA ? now() : null,
                    'updated_at' => now()
                ]);
            
            if (!$updated) {
                throw new \Exception('Failed to update 2FA status in database');
            }
            
            DB::commit();
            
            // Log the activity
            Log::info('2FA Status Changed:', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'enabled' => $enable2FA,
                'timestamp' => now()
            ]);
            
            if ($enable2FA) {
                return redirect()->back()->with('success', 'Two-Step Verification has been enabled successfully!');
            } else {
                return redirect()->back()->with('success', 'Two-Step Verification has been disabled.');
            }
            
        } catch (\Exception $dbError) {
            DB::rollBack();
            throw $dbError;
        }
        
    } catch (\Exception $e) {
        Log::error('2FA Toggle Error: ' . $e->getMessage(), [
            'user_id' => $user->id,
            'stack_trace' => $e->getTraceAsString()
        ]);
        
        return redirect()->back()->with('error', 'Failed to update Two-Step Verification settings: ' . $e->getMessage());
    }
}
}