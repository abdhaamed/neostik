<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Driver;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    /**
     * Display the user management page
     */
    public function index(Request $request)
    {
        // Build driver query with relationships
        $driversQuery = Driver::with([
            'user',
            'tasks' => function ($query) {
                $query->whereIn('status', ['approved', 'pending'])
                      ->latest()
                      ->limit(1);
            }
        ]);

        // Apply availability filter
        if ($request->has('availability') && $request->availability != '') {
            $driversQuery->where('availability', $request->availability);
        }

        // Apply status filter
        if ($request->has('status') && $request->status != '') {
            $driversQuery->where('current_status', $request->status);
        }

        // Apply search filter
        if ($request->has('search') && $request->search != '') {
            $driversQuery->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            })->orWhere('driver_code', 'like', '%' . $request->search . '%');
        }

        // Get drivers with sorting
        $drivers = $driversQuery->orderBy('created_at', 'desc')->get();

        // Get statistics
        $statistics = $this->getStatistics();

        return view('pages.manager.user-management', compact(
            'drivers',
            'statistics'
        ));
    }

    /**
     * Get driver detail via AJAX
     */
    public function getDriverDetail($id)
    {
        $driver = Driver::with([
            'user',
            'tasks' => function ($query) {
                $query->with(['fleet.category', 'fleet.device.gpsLogs'])
                      ->latest()
                      ->limit(10);
            }
        ])->findOrFail($id);

        $activeTask = $driver->tasks->firstWhere('status', 'approved');

        return response()->json([
            'success' => true,
            'data' => [
                'driver' => $driver,
                'user' => $driver->user,
                'active_task' => $activeTask,
                'task_history' => $driver->tasks,
                'performance' => [
                    'total_completed' => $driver->total_completed,
                    'rating' => $driver->rating,
                    'completion_rate' => $driver->total_completed > 0 
                        ? round(($driver->total_completed / $driver->tasks->count()) * 100, 2) 
                        : 0
                ]
            ]
        ]);
    }

    /**
     * Store new driver (create user + driver)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'driver_code' => 'required|string|unique:drivers,driver_code'
        ]);

        // Create user first
        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'driver'
        ];

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $userData['profile_photo_path'] = $request->file('profile_photo')
                ->store('profile-photos', 'public');
        }

        $user = User::create($userData);

        // Create driver profile
        $driver = Driver::create([
            'user_id' => $user->id,
            'driver_code' => $validated['driver_code'],
            'rating' => 0.00,
            'total_completed' => 0,
            'availability' => 'available',
            'current_status' => 'no_task'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Driver created successfully',
            'data' => $driver->load('user')
        ]);
    }

    /**
     * Update driver information
     */
    public function update(Request $request, $id)
    {
        $driver = Driver::with('user')->findOrFail($id);
        $user = $driver->user;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'driver_code' => ['required', 'string', Rule::unique('drivers')->ignore($driver->id)],
            'availability' => 'nullable|in:available,on_leave'
        ]);

        // Update user information
        $userData = [
            'name' => $validated['name'],
            'email' => $validated['email']
        ];

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            $userData['profile_photo_path'] = $request->file('profile_photo')
                ->store('profile-photos', 'public');
        }

        $user->update($userData);

        // Update driver information
        $driver->update([
            'driver_code' => $validated['driver_code'],
            'availability' => $validated['availability'] ?? $driver->availability
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Driver updated successfully',
            'data' => $driver->load('user')
        ]);
    }

    /**
     * Update driver password
     */
    public function updatePassword(Request $request, $id)
    {
        $driver = Driver::with('user')->findOrFail($id);

        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed'
        ]);

        $driver->user->update([
            'password' => Hash::make($validated['password'])
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully'
        ]);
    }

    /**
     * Update driver availability
     */
    public function updateAvailability(Request $request, $id)
    {
        $driver = Driver::findOrFail($id);

        $validated = $request->validate([
            'availability' => 'required|in:available,on_leave'
        ]);

        $driver->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Availability updated successfully',
            'data' => $driver
        ]);
    }

    /**
     * Delete driver (soft delete user)
     */
    public function destroy($id)
    {
        $driver = Driver::with('user')->findOrFail($id);

        // Check if driver has active tasks
        $hasActiveTasks = $driver->tasks()
            ->whereIn('status', ['approved', 'pending'])
            ->exists();

        if ($hasActiveTasks) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete driver with active tasks'
            ], 422);
        }

        // Delete profile photo if exists
        if ($driver->user->profile_photo_path) {
            Storage::disk('public')->delete($driver->user->profile_photo_path);
        }

        // Delete driver and user
        $driver->delete();
        $driver->user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Driver deleted successfully'
        ]);
    }

    /**
     * Get driver task history
     */
    public function getTaskHistory($id)
    {
        $driver = Driver::findOrFail($id);

        $tasks = $driver->tasks()
            ->with(['fleet.category', 'creator'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $tasks
        ]);
    }

    /**
     * Get statistics for badges
     */
    private function getStatistics()
    {
        return [
            'total_drivers' => Driver::count(),
            'available_drivers' => Driver::where('availability', 'available')
                                        ->where('current_status', 'no_task')
                                        ->count(),
            'active_drivers' => Driver::whereIn('current_status', ['assigned', 'en_route'])
                                     ->count(),
            'on_leave' => Driver::where('availability', 'on_leave')->count(),
            'total_completed_deliveries' => Driver::sum('total_completed'),
            'average_rating' => round(Driver::avg('rating'), 2)
        ];
    }

    /**
     * Get assignment requests (pending tasks)
     */
    public function getAssignmentRequests(Request $request)
    {
        $tasksQuery = Task::with([
            'fleet.category',
            'driver.user',
            'creator'
        ])->where('status', 'pending');

        // Apply filters
        if ($request->has('search') && $request->search != '') {
            $tasksQuery->where(function ($q) use ($request) {
                $q->where('task_number', 'like', '%' . $request->search . '%')
                  ->orWhere('origin', 'like', '%' . $request->search . '%')
                  ->orWhere('destination', 'like', '%' . $request->search . '%');
            });
        }

        $tasks = $tasksQuery->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $tasks
        ]);
    }

    /**
     * Approve assignment request
     */
    public function approveAssignment($taskId)
    {
        $task = Task::with(['driver', 'fleet'])->findOrFail($taskId);

        // Update task status
        $task->update(['status' => 'approved']);

        // Update driver status
        $task->driver->update(['current_status' => 'assigned']);

        // Update fleet status
        $task->fleet->update(['current_status' => 'assigned']);

        return response()->json([
            'success' => true,
            'message' => 'Assignment approved successfully',
            'data' => $task
        ]);
    }

    /**
     * Reject assignment request
     */
    public function rejectAssignment(Request $request, $taskId)
    {
        $task = Task::with(['driver', 'fleet'])->findOrFail($taskId);

        $validated = $request->validate([
            'reason' => 'nullable|string|max:500'
        ]);

        // Update task status
        $task->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['reason'] ?? null
        ]);

        // Reset driver and fleet status
        $task->driver->update(['current_status' => 'no_task']);
        $task->fleet->update(['current_status' => 'unassigned']);

        return response()->json([
            'success' => true,
            'message' => 'Assignment rejected successfully',
            'data' => $task
        ]);
    }
}