<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Fleet;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        // Tidak digunakan — assignment panel dibuka dari halaman driver
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'driver_id' => 'required|exists:users,id',
            'fleet_id' => 'required|exists:fleets,id',
            'origin' => 'required|string',
            'destination' => 'required|string',
            'cargo_type' => 'nullable|string',
            'cargo_volume' => 'nullable|string',
            'vehicle_plate' => 'nullable|string',
            'operating_cost' => 'nullable|numeric|min:0',
        ]);

        // Cek apakah fleet masih "Unassigned"
        $fleet = Fleet::findOrFail($validated['fleet_id']);
        if ($fleet->status !== 'Unassigned') {
            return response()->json([
                'success' => false,
                'message' => 'Fleet is already assigned or in use.'
            ], 422);
        }

        // Buat tugas
        $task = Task::create([
            'driver_id' => $validated['driver_id'],
            'fleet_id' => $validated['fleet_id'],
            'task_number' => Task::generateTaskNumber(),
            'origin' => $validated['origin'],
            'destination' => $validated['destination'],
            'cargo_type' => $validated['cargo_type'],
            'cargo_volume' => $validated['cargo_volume'],
            'vehicle_plate' => $validated['vehicle_plate'],
            'operating_cost' => $validated['operating_cost'],
            'status' => 'assigned',
        ]);

        // Update status fleet → Assigned
        $fleet->update(['status' => 'Assigned']);

        // (Opsional) Update driver availability → on_duty
        $driver = User::findOrFail($validated['driver_id']);
        $driver->update(['availability' => 'on_duty']);

        return response()->json([
            'success' => true,
            'message' => 'Task assigned successfully',
            'task' => $task->load('driver', 'fleet'),
        ]);
    }
}