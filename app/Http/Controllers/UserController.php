<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Fleet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $drivers = User::where('role', 'driver')
            ->orderBy('created_at', 'desc')
            ->get();

        $fleets = Fleet::where('status', 'Unassigned')
            ->with('device')
            ->orderBy('fleet_id', 'asc')
            ->get();

        $fleetCounts = $this->getFleetCounts(); // ✅ DITAMBAHKAN

        return view('admin-dashboard.manager.user-management', compact('drivers', 'fleets', 'fleetCounts'));
    }

    private function getFleetCounts()
    {
        $counts = Fleet::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $statuses = ['Unassigned', 'Assigned', 'En Route', 'Completed'];
        $fleetCounts = array_fill_keys($statuses, 0);
        
        foreach ($counts as $status => $count) {
            if (in_array($status, $statuses)) {
                $fleetCounts[$status] = $count;
            }
        }
        
        return $fleetCounts;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'license_number' => 'required|string|max:50',
            'vehicle_type' => 'nullable|string|max:100',
            'vehicle_plate' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date|before:today',
            'address' => 'nullable|string|max:500',
        ]);

        // Generate driver ID
        $validated['driver_id'] = User::generateDriverId();

        // Generate password from email (part before @)
        $emailUsername = explode('@', $validated['email'])[0];
        $validated['password'] = Hash::make($emailUsername);

        // Set defaults
        $validated['role'] = 'driver';
        $validated['status'] = 'active';
        $validated['availability'] = 'available';
        $validated['rating'] = 0;
        $validated['completed_deliveries'] = 0;

        $user = User::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Driver added successfully',
            'data' => $user,
            'credentials' => [
                'email' => $user->email,
                'password' => $emailUsername
            ]
        ], 200);
    }

    public function show(User $user)
    {
        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => 'required|string|max:20',
            'license_number' => 'required|string|max:50',
            'vehicle_type' => 'nullable|string|max:100',
            'vehicle_plate' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date|before:today',
            'address' => 'nullable|string|max:500',
            'status' => 'required|in:active,inactive,suspended',
            'availability' => 'required|in:available,on_duty,on_leave',
        ]);

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Driver updated successfully',
            'data' => $user->fresh()
        ]);
    }

    public function destroy(User $user)
    {
        if ($user->role !== 'driver') {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete non-driver user'
            ], 403);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Driver deleted successfully'
        ]);
    }

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
            ->get();

        return response()->json([
            'success' => true,
            'data' => $drivers
        ]);
    }

}
