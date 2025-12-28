<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Fleet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DriverTaskController extends Controller
{
    public function show(Task $task)
    {
        if ($task->driver_id !== Auth::id()) {
            abort(403);
        }
        $task->load('fleet');
        return view('driver.task-detail', compact('task'));
    }

    // Driver: Submit evidence for "Assigned" → move to "En Route"
    public function submitEnRouteEvidence(Request $request, Task $task)
    {
        if (!$task->relationLoaded('fleet')) {
            $task->load('fleet');
        }

        if ($task->driver_id !== Auth::id() || $task->status !== 'assigned') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized or invalid task status.'
            ], 403);
        }

        if (!$task->fleet) {
            return response()->json([
                'success' => false,
                'message' => 'Fleet not found for this task.'
            ], 400);
        }

        $request->validate([
            'recipient' => 'required|string',
            'description' => 'nullable|string',
            'report' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        Log::info('Submit En Route evidence request', [
            'task_id' => $task->id,
            'fleet_id' => $task->fleet_id,
            'recipient' => $request->recipient,
            'has_file' => $request->hasFile('report'),
            'description' => $request->description,
        ]);

        $fleet = $task->fleet;

        if ($fleet->status !== 'Assigned') {
            return response()->json([
                'success' => false,
                'message' => 'Fleet is not in Assigned status.'
            ], 400);
        }

        $reportPath = null;
        if ($request->hasFile('report')) {
            $reportPath = $request->file('report')->store('reports', 'public');
        }

        // ✅ Update bukti untuk status "Assigned" → "En Route"
        if (!$fleet->updateBuktiOperasional([
            'enroute_recipient' => $request->recipient,
            'enroute_description' => $request->description,
            'enroute_report' => $reportPath,
        ])) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save evidence. Please try again.'
            ], 500);
        }

        $fleet->update(['status' => 'En Route']);
        $task->update(['status' => 'en_route']);

        return response()->json([
            'success' => true,
            'message' => 'Evidence submitted successfully. Status changed to En Route.'
        ]);
    }

    // Driver: Submit evidence for "En Route" → move to "Completed"
    public function submitCompletedEvidence(Request $request, Task $task)
    {
        if (!$task->relationLoaded('fleet')) {
            $task->load('fleet');
        }

        if ($task->driver_id !== Auth::id() || $task->status !== 'en_route') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized or invalid task status.'
            ], 403);
        }

        if (!$task->fleet) {
            return response()->json([
                'success' => false,
                'message' => 'Fleet not found for this task.'
            ], 400);
        }

        $request->validate([
            'recipient' => 'required|string',
            'description' => 'nullable|string',
            'report' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        Log::info('Submit Completed evidence request', [
            'task_id' => $task->id,
            'fleet_id' => $task->fleet_id,
            'recipient' => $request->recipient,
            'has_file' => $request->hasFile('report'),
            'description' => $request->description,
        ]);

        $fleet = $task->fleet;

        if ($fleet->status !== 'En Route') {
            return response()->json([
                'success' => false,
                'message' => 'Fleet is not in En Route status.'
            ], 400);
        }

        $reportPath = null;
        if ($request->hasFile('report')) {
            $reportPath = $request->file('report')->store('reports', 'public');
        }

        // ✅ PERBAIKAN: Gunakan prefix "completed_" bukan "enroute_"
        $buktiData = [
            'completed_recipient' => $request->recipient,
            'completed_description' => $request->description,
            'completed_report' => $reportPath,
        ];

        if (!$fleet->updateBuktiOperasional($buktiData)) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save evidence. Please try again.'
            ], 500);
        }

        $fleet->update(['status' => 'Completed']);
        $task->update(['status' => 'completed']);

        return response()->json([
            'success' => true,
            'message' => 'Task completed successfully. Waiting for admin approval.'
        ]);
    }
}