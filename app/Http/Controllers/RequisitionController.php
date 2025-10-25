<?php

namespace App\Http\Controllers;

use App\Models\Requisition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class RequisitionController extends Controller
{
    /**
     * Show the recognition form
     */
    public function index()
    {
        return view('Recognition');
    }

    /**
     * Handle recognition form submission
     */
    public function storeRecognition(Request $request)
    {
        $validatedData = $request->validate([
            'subject' => 'required|string|max:100',
            'content' => 'required|string',
             'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
        ]);

        Requisition::create([
            'name' => $validatedData['name'],
            'designation' => $validatedData['designation'],
            'subject' => $validatedData['subject'],
            'content' => $validatedData['content'],
            'file_path' => null, // Set to null since Recognition form doesn't have file
            'user_ip' => $request->ip(),
        ]);

        // Add notification to session
        $this->addNotification('New requisition submitted: ' . $validatedData['subject']);

        return redirect()->back()->with('success', 'Recognition submitted successfully!');
    }

    /**
     * Show the upload file form
     */
    public function showUploadForm()
    {
        return view('uploadfile');
    }

    /**
     * Handle upload file form submission
     */
    public function storeUploadFile(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'upload' => 'nullable|file|mimes:pdf,doc,docx,txt,jpg,png,jpeg|max:10240',
        ]);

        $filePath = null;
        if ($request->hasFile('upload')) {
            $filePath = $request->file('upload')->store('requisitions', 'public');
        }

        Requisition::create([
            'name' => $validatedData['name'],
            'designation' => $validatedData['designation'],
            'subject' => $validatedData['subject'],
            'file_path' => $filePath,
            'user_ip' => $request->ip(),
        ]);

        // Add notification to session
        $this->addNotification('New file requisition submitted: ' . $validatedData['subject']);

        return redirect()->back()->with('success', 'File uploaded successfully!');
    }

    /**
     * Add notification to session
     */
    private function addNotification($message)
    {
        $notifications = Session::get('notifications', []);
        $notifications[] = [
            'id' => uniqid(),
            'message' => $message,
            'time' => now()->format('H:i'),
            'read' => false
        ];
        Session::put('notifications', $notifications);
    }

    /**
     * Get notifications via AJAX
     */
    public function getNotifications()
    {
        $notifications = Session::get('notifications', []);
        return response()->json($notifications);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(Request $request)
    {
        $notificationId = $request->input('id');
        $notifications = Session::get('notifications', []);
        
        foreach ($notifications as &$notification) {
            if ($notification['id'] == $notificationId) {
                $notification['read'] = true;
                break;
            }
        }
        
        Session::put('notifications', $notifications);
        return response()->json(['success' => true]);
    }

    /**
     * Clear all notifications
     */
    public function clearNotifications()
    {
        Session::forget('notifications');
        return response()->json(['success' => true]);
    }
}