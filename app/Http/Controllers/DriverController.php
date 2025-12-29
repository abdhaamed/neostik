<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class DriverController extends Controller
{
    public function dashboard()
    {
        /** @var User $driver */
        $driver = Auth::user();

        // JANGAN DIUBAH (SESUSAI PERMINTAAN)
        $stats = [
            'active_shipments' => 0,
            'completed_today' => 0,
            'pending_pickups' => 0,
        ];

        return view('driver.dashboard', compact('driver', 'stats'));
    }

    /**
     * DATA REALTIME DASHBOARD (METHOD BARU, TIDAK MENGUBAH DASHBOARD)
     */
    public function dashboardData()
    {
        /** @var User $driver */
        $driver = Auth::user();

        $stats = [
            'active_shipments' => Task::where('driver_id', $driver->id)
                ->whereIn('status', ['assigned', 'en_route'])
                ->count(),

            'completed_today' => Task::where('driver_id', $driver->id)
                ->where('status', 'completed')
                ->whereDate('updated_at', today())
                ->count(),

            'pending_pickups' => Task::where('driver_id', $driver->id)
                ->where('status', 'assigned')
                ->count(),
        ];

        $recentTasks = Task::with('fleet.device')
            ->where('driver_id', $driver->id)
            ->latest()
            ->take(5)
            ->get();

        return response()->json([
            'success' => true,
            'stats' => $stats,
            'recentTasks' => $recentTasks,
        ]);
    }

    public function shipments()
    {
        $driver = Auth::user();

        $tasks = Task::with('fleet.device')
            ->where('driver_id', $driver->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('driver.shipments', compact('tasks'));
    }

    public function profile()
    {
        /** @var User $driver */
        $driver = Auth::user();

        return view('driver.profile', compact('driver'));
    }

    public function updateProfile(Request $request)
    {
        /** @var User $driver */
        $driver = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:500',
            'date_of_birth' => 'nullable|date|before:today',
        ]);

        $driver->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'data' => $driver->fresh(),
        ]);
    }

    public function updatePassword(Request $request)
    {
        /** @var User $driver */
        $driver = Auth::user();

        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => ['required', 'confirmed', Password::min(6)],
        ]);

        if (!Hash::check($validated['current_password'], $driver->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect',
            ], 422);
        }

        $driver->update([
            'password' => Hash::make($validated['new_password']),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully',
        ]);
    }

    public function updateVehicle(Request $request)
    {
        /** @var User $driver */
        $driver = Auth::user();

        $validated = $request->validate([
            'vehicle_type' => 'required|string|max:100',
            'vehicle_plate' => 'required|string|max:20',
            'license_number' => 'required|string|max:50',
        ]);

        $driver->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Vehicle information updated successfully',
            'data' => $driver->fresh(),
        ]);
    }
}
