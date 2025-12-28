<?php
namespace App\Http\Controllers;
use App\Models\Task;
use App\Models\Fleet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function assign(Request $request)
    {
        $request->validate([
            'driver_id' => 'required|exists:users,id',
            'fleet_id' => 'required|exists:fleets,id',
            'origin' => 'required|string',
            'destination' => 'required|string',
            'cargo_type' => 'nullable|string',
            'cargo_volume' => 'nullable|string',
            'vehicle_plate' => 'nullable|string',
            'operating_cost' => 'nullable|numeric|min:0',
        ]);
        
        $fleet = Fleet::findOrFail($request->fleet_id);
        if ($fleet->status !== 'Unassigned') {
            return response()->json([
                'success' => false,
                'message' => 'Fleet is not available for assignment'
            ], 400);
        }
        
        $task = Task::create([
            'driver_id' => $request->driver_id,
            'fleet_id' => $request->fleet_id,
            'task_number' => Task::generateTaskNumber(),
            'origin' => $request->origin,
            'destination' => $request->destination,
            'cargo_type' => $request->cargo_type,
            'cargo_volume' => $request->cargo_volume,
            'vehicle_plate' => $request->vehicle_plate,
            'operating_cost' => $request->operating_cost,
            'status' => 'assigned',
        ]);
        
        // ✅ Isi bukti Unassigned secara otomatis
        $adminName = Auth::user()->name;
        $driver = User::find($request->driver_id);
        $fleet->updateBuktiOperasional([
            'unassigned_recipient' => $adminName,
            'unassigned_description' => "Task assigned to {$driver->name}",
            'unassigned_report' => null,
        ]);
        
        $fleet->update(['status' => 'Assigned']);
        
        // ✅ PERBAIKAN: Gunakan key "success" bukan "message"
        return response()->json([
            'success' => true,
            'message' => 'Task assigned successfully',
            'task' => $task
        ], 200);
    }
}