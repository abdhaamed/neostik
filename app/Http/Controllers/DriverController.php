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

        $stats = [
            'active_shipments' => 0,
            'completed_today' => 0,
            'pending_pickups' => 0,
        ];

        return view('driver.dashboard', compact('driver', 'stats'));
    }

    public function shipments()
    {
        $driver = Auth::user();

        // Gunakan Task tanpa namespace penuh
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
