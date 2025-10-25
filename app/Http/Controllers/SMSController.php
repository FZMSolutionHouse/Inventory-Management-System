<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Notifications\WelcomeSmsNotification;
use App\Models\AppUser; // Changed from User to AppUser
use App\Models\SmsNotification;

class SmsController extends Controller
{
    /**
     * Send welcome SMS to a user by user ID
     */
    public function sendWelcomeSmsToUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:app_users,id', // Updated table reference
            'message' => 'nullable|string|max:160',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = AppUser::find($request->user_id); // Changed to AppUser
            
            if (!$user->phone_number) { // Updated field name
                return response()->json([
                    'success' => false,
                    'message' => 'User does not have a phone number'
                ], 400);
            }

            $message = $request->message ?? 'Welcome to our platform! We are excited to have you.';
            
            // Create SMS log entry
            $smsLog = SmsNotification::create([
                'user_id' => $user->id,
                'phone_number' => $user->phone_number, // Updated field name
                'message' => $message,
                'notification_type' => 'welcome',
                'status' => 'pending',
            ]);

            try {
                $user->notify(new WelcomeSmsNotification($message));
                
                // Mark as sent (you can add message ID if Vonage provides it)
                $smsLog->markAsSent();

                return response()->json([
                    'success' => true,
                    'message' => 'Welcome SMS sent successfully!',
                    'data' => [
                        'user' => $user->name,
                        'phone' => $user->phone_number,
                        'sms_id' => $smsLog->id
                    ]
                ]);

            } catch (\Exception $e) {
                // Mark as failed
                $smsLog->markAsFailed($e->getMessage());
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('Failed to send welcome SMS', [
                'user_id' => $request->user_id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to send SMS: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send SMS to any phone number
     */
    public function sendSmsToNumber(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|min:10|max:15',
            'message' => 'required|string|max:160',
            'type' => 'nullable|string|in:general,otp,reminder,notification',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $phone = $this->formatPhoneNumber($request->phone);
            $type = $request->type ?? 'general';
            
            // Create SMS log entry
            $smsLog = SmsNotification::create([
                'user_id' => null,
                'phone_number' => $phone,
                'message' => $request->message,
                'notification_type' => $type,
                'status' => 'pending',
            ]);

            try {
                Notification::route('vonage', $phone)
                    ->notify(new WelcomeSmsNotification($request->message));
                
                // Mark as sent
                $smsLog->markAsSent();

                return response()->json([
                    'success' => true,
                    'message' => 'SMS sent successfully!',
                    'data' => [
                        'phone' => $phone,
                        'sms_id' => $smsLog->id
                    ]
                ]);

            } catch (\Exception $e) {
                $smsLog->markAsFailed($e->getMessage());
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('Failed to send SMS to phone number', [
                'phone' => $request->phone,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to send SMS: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send bulk SMS to multiple users
     */
    public function sendBulkSms(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:app_users,id', // Updated table reference
            'message' => 'required|string|max:160',
            'type' => 'nullable|string|in:general,announcement,reminder',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $users = AppUser::whereIn('id', $request->user_ids) // Changed to AppUser
                        ->whereNotNull('phone_number') // Updated field name
                        ->get();

            if ($users->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No users found with valid phone numbers'
                ], 400);
            }

            $type = $request->type ?? 'general';
            $successCount = 0;
            $failedCount = 0;
            $smsLogs = [];

            foreach ($users as $user) {
                // Create SMS log entry for each user
                $smsLog = SmsNotification::create([
                    'user_id' => $user->id,
                    'phone_number' => $user->phone_number, // Updated field name
                    'message' => $request->message,
                    'notification_type' => $type,
                    'status' => 'pending',
                ]);

                try {
                    $user->notify(new WelcomeSmsNotification($request->message));
                    $smsLog->markAsSent();
                    $successCount++;
                } catch (\Exception $e) {
                    $smsLog->markAsFailed($e->getMessage());
                    $failedCount++;
                }

                $smsLogs[] = $smsLog->id;
            }

            return response()->json([
                'success' => true,
                'message' => 'Bulk SMS processing completed!',
                'data' => [
                    'total_users' => count($users),
                    'successful_sends' => $successCount,
                    'failed_sends' => $failedCount,
                    'sms_log_ids' => $smsLogs
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send bulk SMS', [
                'user_ids' => $request->user_ids,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to send bulk SMS: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get SMS history/logs
     */
    public function getSmsHistory(Request $request)
    {
        $query = SmsNotification::with('appUser:id,name,email') // Updated relationship name
                    ->orderBy('created_at', 'desc');

        // Filter by status if provided
        if ($request->has('status')) {
            $query->byStatus($request->status);
        }

        // Filter by type if provided
        if ($request->has('type')) {
            $query->byType($request->type);
        }

        // Filter by user if provided
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by date range
        if ($request->has('days')) {
            $query->recent($request->days);
        }

        $smsLogs = $query->paginate(50);

        return response()->json([
            'success' => true,
            'data' => $smsLogs,
            'summary' => [
                'total' => SmsNotification::count(),
                'sent' => SmsNotification::byStatus('sent')->count(),
                'failed' => SmsNotification::byStatus('failed')->count(),
                'pending' => SmsNotification::byStatus('pending')->count(),
            ]
        ]);
    }

    /**
     * Get SMS statistics
     */
    public function getSmsStats(Request $request)
    {
        $days = $request->get('days', 30);
        
        $stats = [
            'total_sent' => SmsNotification::recent($days)->byStatus('sent')->count(),
            'total_failed' => SmsNotification::recent($days)->byStatus('failed')->count(),
            'total_pending' => SmsNotification::recent($days)->byStatus('pending')->count(),
            'by_type' => SmsNotification::recent($days)
                ->selectRaw('notification_type, count(*) as count')
                ->groupBy('notification_type')
                ->get(),
            'daily_stats' => SmsNotification::recent($days)
                ->selectRaw('DATE(created_at) as date, status, count(*) as count')
                ->groupBy(['date', 'status'])
                ->orderBy('date', 'desc')
                ->get(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Test SMS functionality
     */
    public function testSms()
    {
        try {
            $testPhone = '+923313220256';
            $testMessage = 'Test SMS from Laravel at ' . now()->format('Y-m-d H:i:s');

            // Create SMS log
            $smsLog = SmsNotification::create([
                'user_id' => null,
                'phone_number' => $testPhone,
                'message' => $testMessage,
                'notification_type' => 'test',
                'status' => 'pending',
            ]);

            try {
                Notification::route('vonage', $testPhone)
                    ->notify(new WelcomeSmsNotification($testMessage));
                
                $smsLog->markAsSent();

                return response()->json([
                    'success' => true,
                    'message' => 'Test SMS sent successfully!',
                    'data' => [
                        'phone' => $testPhone,
                        'message' => $testMessage,
                        'sms_id' => $smsLog->id
                    ]
                ]);

            } catch (\Exception $e) {
                $smsLog->markAsFailed($e->getMessage());
                throw $e;
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Test SMS failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Format phone number to international format
     */
    private function formatPhoneNumber($phone)
    {
        $phone = preg_replace('/[^0-9+]/', '', $phone);
        
        if (!str_starts_with($phone, '+')) {
            if (str_starts_with($phone, '0')) {
                $phone = '+92' . substr($phone, 1);
            } else {
                $phone = '+92' . $phone;
            }
        }
        
        return $phone;
    }
}