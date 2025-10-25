<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class adminrequistionrecordController extends Controller
{
    public function recordshow()
    {
        try {
            // Fetch all requisitions with their data
            $requisitions = DB::table('requisition')
                ->select(
                    'id as req_id',
                    'name',
                    'designation',
                    'subject',
                    'file_path',
                    'content',
                    'status',
                    'remarks',
                    'created_at'
                )
                ->orderBy('created_at', 'desc')
                ->get();

            // Calculate statistics
            $stats = [
                'total' => $requisitions->count(),
                'pending' => $requisitions->where('status', 'pending')->count(),
                'approved' => $requisitions->where('status', 'approved')->count(),
                'rejected' => $requisitions->where('status', 'rejected')->count(),
            ];

            return view('adminrequisitionrecord', compact('requisitions', 'stats'));
            
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Database error in recordshow: ' . $e->getMessage());
            
            // Handle database errors
            $error_message = "Database error: " . $e->getMessage();
            $requisitions = collect();
            $stats = [
                'total' => 0,
                'pending' => 0,
                'approved' => 0,
                'rejected' => 0,
            ];
            return view('adminrequisitionrecord', compact('requisitions', 'stats', 'error_message'));
        }
    }

    public function updateStatus(Request $request)
    {
        try {
            // Log the incoming request for debugging
            Log::info('Update status request:', $request->all());

            // Validate the request
            $validatedData = $request->validate([
                'requisition_id' => 'required|integer',
                'status' => 'required|in:pending,approved,rejected',
                'remarks' => 'nullable|string|max:1000'
            ]);

            // Check if requisition exists
            $requisition = DB::table('requisition')->where('id', $validatedData['requisition_id'])->first();
            
            if (!$requisition) {
                return response()->json([
                    'success' => false,
                    'message' => 'Requisition not found'
                ], 404);
            }

            // Update the requisition status and remarks
            $updated = DB::table('requisition')
                ->where('id', $validatedData['requisition_id'])
                ->update([
                    'status' => $validatedData['status'],
                    'remarks' => $validatedData['remarks'],
                    'updated_at' => now()
                ]);

            if ($updated) {
                Log::info('Requisition updated successfully:', [
                    'id' => $validatedData['requisition_id'],
                    'status' => $validatedData['status']
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Requisition status updated successfully',
                    'data' => [
                        'id' => $validatedData['requisition_id'],
                        'status' => $validatedData['status'],
                        'remarks' => $validatedData['remarks']
                    ]
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No changes made to the requisition'
                ], 400);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error updating requisition status: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error updating status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function bulkUpdateStatus(Request $request)
    {
        try {
            // Log the incoming request for debugging
            Log::info('Bulk update status request:', $request->all());

            // Validate the request
            $validatedData = $request->validate([
                'requisition_ids' => 'required|array|min:1',
                'requisition_ids.*' => 'integer',
                'status' => 'required|in:pending,approved,rejected',
                'remarks' => 'nullable|string|max:1000'
            ]);

            // Check if any requisitions exist with the given IDs
            $existingCount = DB::table('requisition')
                ->whereIn('id', $validatedData['requisition_ids'])
                ->count();

            if ($existingCount === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No valid requisitions found with the provided IDs'
                ], 404);
            }

            // Update all selected requisitions
            $updated = DB::table('requisition')
                ->whereIn('id', $validatedData['requisition_ids'])
                ->update([
                    'status' => $validatedData['status'],
                    'remarks' => $validatedData['remarks'],
                    'updated_at' => now()
                ]);

            Log::info('Bulk update completed:', [
                'ids' => $validatedData['requisition_ids'],
                'status' => $validatedData['status'],
                'updated_count' => $updated
            ]);

            return response()->json([
                'success' => true,
                'message' => "Successfully updated {$updated} requisition(s)",
                'data' => [
                    'updated_count' => $updated,
                    'status' => $validatedData['status'],
                    'remarks' => $validatedData['remarks']
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error in bulk update: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error updating status: ' . $e->getMessage()
            ], 500);
        }
    }
}