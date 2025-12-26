<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\Fleet;

class UserController extends Controller
{
    /**
     * Display a listing of drivers
     */
    public function index()
    {
        $drivers = User::where('role', 'driver')
            ->orderBy('created_at', 'desc')
            ->get();
        $fleets = Fleet::where('status', 'Unassigned')->with('device')->get(); // hanya fleet yang tersedia

        return view('admin-dashboard.manager.user-management', compact('drivers', 'fleets'));
    }

    /**
     * Show single driver
     */
    public function show(User $user)
    {
        return response()->json([
            'success' => true,
            'data' => $user,
        ]);
    }

    /**
     * Store a newly created driver
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|string|max:20',
                'license_number' => 'required|string|max:50',
                'vehicle_type' => 'nullable|string|max:100',
                'vehicle_plate' => 'nullable|string|max:20',
                'address' => 'nullable|string',
                'date_of_birth' => 'nullable|date|before:today',
            ]);

            // Generate password from name (first part of email)
            $emailUsername = explode('@', $validated['email'])[0];
            $password = $emailUsername;

            // Create driver
            $driver = User::create([
                'driver_id' => User::generateDriverId(),
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($password),
                'phone' => $validated['phone'],
                'license_number' => $validated['license_number'],
                'vehicle_type' => $validated['vehicle_type'] ?? null,
                'vehicle_plate' => $validated['vehicle_plate'] ?? null,
                'address' => $validated['address'] ?? null,
                'date_of_birth' => $validated['date_of_birth'] ?? null,
                'role' => 'driver',
                'status' => 'active',
                'availability' => 'available',
                'rating' => 0,
                'completed_deliveries' => 0,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Driver created successfully',
                'data' => $driver,
                'credentials' => [
                    'email' => $driver->email,
                    'password' => $password,
                ]
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create driver: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified driver
     */
    public function update(Request $request, User $user)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
                'phone' => 'required|string|max:20',
                'license_number' => 'required|string|max:50',
                'vehicle_type' => 'nullable|string|max:100',
                'vehicle_plate' => 'nullable|string|max:20',
                'address' => 'nullable|string',
                'date_of_birth' => 'nullable|date|before:today',
                'status' => 'required|in:active,inactive,suspended',
                'availability' => 'required|in:available,on_duty,on_leave',
            ]);

            $user->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Driver updated successfully',
                'data' => $user->fresh(),
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update driver: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified driver
     */
    public function destroy(User $user)
    {
        if ($user->role !== 'driver') {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete non-driver user',
            ], 403);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Driver deleted successfully',
        ]);
    }

    /**
     * Search drivers
     */
    public function search(Request $request)
    {
        $query = $request->get('query');

        $drivers = User::where('role', 'driver')
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%")
                    ->orWhere('driver_id', 'like', "%{$query}%")
                    ->orWhere('phone', 'like', "%{$query}%");
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $drivers,
        ]);
    }
}
