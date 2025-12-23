<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Task;
use App\Models\Driver;
use App\Models\Fleet;
use App\Models\FleetStatusLog;
use Carbon\Carbon;

class DriverController extends Controller
{
    /**
     * Display driver dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Pastikan user adalah driver
        if ($user->role !== 'driver') {
            abort(403, 'Unauthorized access');
        }

        // Ambil data driver
        $driver = Driver::where('user_id', $user->id)->first();
        
        if (!$driver) {
            return view('driver.dashboard', [
                'activeShipments' => 0,
                'completedToday' => 0,
                'pendingPickups' => 0,
                'availableTasks' => collect([]),
                'myActiveTasks' => collect([]),
                'driver' => null
            ]);
        }

        // Hitung statistik
        $activeShipments = Task::where('driver_id', $driver->id)
            ->whereIn('status', ['assigned', 'approved'])
            ->count();

        $completedToday = Task::where('driver_id', $driver->id)
            ->where('status', 'completed')
            ->whereDate('updated_at', Carbon::today())
            ->count();

        $pendingPickups = Task::where('driver_id', $driver->id)
            ->where('status', 'assigned')
            ->count();

        // Ambil task yang BELUM diambil driver manapun (status pending, belum ada driver)
        $availableTasks = Task::whereNull('driver_id')
            ->where('status', 'pending')
            ->with(['fleet.category', 'creator'])
            ->orderBy('delivery_date', 'asc')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Ambil task yang sudah diambil driver ini
        $myActiveTasks = Task::where('driver_id', $driver->id)
            ->whereIn('status', ['assigned', 'approved'])
            ->with(['fleet.category', 'creator'])
            ->orderBy('delivery_date', 'asc')
            ->get();

        return view('driver.dashboard', compact(
            'activeShipments',
            'completedToday', 
            'pendingPickups',
            'availableTasks',
            'myActiveTasks',
            'driver'
        ));
    }

    /**
     * Driver mengambil task (claim task)
     */
    public function claimTask(Request $request, $id)
    {
        $user = Auth::user();
        $driver = Driver::where('user_id', $user->id)->first();
        
        if (!$driver) {
            return back()->with('error', 'Driver profile not found');
        }

        // Cek apakah driver sedang available
        if ($driver->availability !== 'available') {
            return back()->with('error', 'You are currently on leave and cannot claim tasks');
        }

        try {
            DB::beginTransaction();

            // Ambil task yang belum ada driver dan status pending
            $task = Task::whereNull('driver_id')
                ->where('id', $id)
                ->where('status', 'pending')
                ->with('fleet')
                ->lockForUpdate()
                ->first();

            if (!$task) {
                DB::rollBack();
                return back()->with('error', 'Task not available or already claimed by another driver');
            }

            // Assign task ke driver ini dan ubah status jadi assigned
            $task->update([
                'driver_id' => $driver->id,
                'status' => 'assigned'
            ]);

            // Update driver status
            $driver->update([
                'current_status' => 'assigned'
            ]);

            // Update fleet status jadi assigned
            if ($task->fleet) {
                $task->fleet->update([
                    'current_status' => 'assigned'
                ]);

                // Log status fleet
                FleetStatusLog::create([
                    'fleet_id' => $task->fleet_id,
                    'task_id' => $task->id,
                    'status' => 'assigned',
                    'description' => 'Task assigned to driver: ' . $user->name,
                    'uploaded_by' => $user->id
                ]);
            }

            DB::commit();

            return redirect()->route('driver.dashboard')->with('success', 'Task claimed successfully! You can now start the delivery.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to claim task: ' . $e->getMessage());
        }
    }

    /**
     * Display all shipments for driver
     */
    public function shipments()
    {
        $user = Auth::user();
        
        // Pastikan user adalah driver
        if ($user->role !== 'driver') {
            abort(403, 'Unauthorized access');
        }

        // Ambil data driver
        $driver = Driver::where('user_id', $user->id)->first();
        
        if (!$driver) {
            return view('driver.shipments', [
                'tasks' => collect([]),
                'driver' => null
            ]);
        }

        // Ambil semua task driver dengan pagination
        $tasks = Task::where('driver_id', $driver->id)
            ->with(['fleet.category', 'creator', 'documents', 'evidences', 'costs'])
            ->orderBy('delivery_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('driver.shipments', compact('tasks', 'driver'));
    }

    /**
     * Display detail task
     */
    public function taskDetail($id)
    {
        $user = Auth::user();
        $driver = Driver::where('user_id', $user->id)->first();
        
        if (!$driver) {
            abort(403, 'Driver profile not found');
        }

        // Ambil task dengan validasi kepemilikan
        $task = Task::where('id', $id)
            ->where('driver_id', $driver->id)
            ->with([
                'fleet.category',
                'fleet.device',
                'creator',
                'documents',
                'evidences',
                'costs',
                'statusLogs.uploader'
            ])
            ->firstOrFail();

        return view('driver.task-detail', compact('task', 'driver'));
    }

    /**
     * Start task (mulai perjalanan)
     */
    public function startTask(Request $request, $id)
    {
        $user = Auth::user();
        $driver = Driver::where('user_id', $user->id)->first();
        
        if (!$driver) {
            return back()->with('error', 'Driver profile not found');
        }

        try {
            DB::beginTransaction();

            $task = Task::where('id', $id)
                ->where('driver_id', $driver->id)
                ->where('status', 'assigned')
                ->with('fleet')
                ->lockForUpdate()
                ->firstOrFail();

            // Update task status ke approved (sedang berjalan)
            $task->update([
                'status' => 'approved'
            ]);

            // Update driver status
            $driver->update([
                'current_status' => 'en_route'
            ]);

            // Update fleet status
            if ($task->fleet) {
                $task->fleet->update([
                    'current_status' => 'en_route'
                ]);

                // Log status fleet
                FleetStatusLog::create([
                    'fleet_id' => $task->fleet_id,
                    'task_id' => $task->id,
                    'status' => 'en_route',
                    'description' => 'Shipment started by driver: ' . $user->name,
                    'uploaded_by' => $user->id
                ]);
            }

            DB::commit();

            return back()->with('success', 'Task started! Safe journey.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to start task: ' . $e->getMessage());
        }
    }

    /**
     * Complete task (selesaikan pengiriman)
     */
    public function completeTask(Request $request, $id)
    {
        $user = Auth::user();
        $driver = Driver::where('user_id', $user->id)->first();
        
        if (!$driver) {
            return back()->with('error', 'Driver profile not found');
        }

        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'evidence_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'notes' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $task = Task::where('id', $id)
                ->where('driver_id', $driver->id)
                ->whereIn('status', ['assigned', 'approved'])
                ->with('fleet')
                ->lockForUpdate()
                ->firstOrFail();

            // Upload evidence image
            $evidencePath = $request->file('evidence_image')->store('task-evidences', 'public');

            // Simpan evidence
            $task->evidences()->create([
                'image_path' => $evidencePath,
                'description' => $request->notes ?? 'Delivery completed successfully'
            ]);

            // Update task status ke completed
            $task->update([
                'status' => 'completed'
            ]);

            // Update driver status dan total completed
            $driver->update([
                'current_status' => 'no_task',
                'total_completed' => $driver->total_completed + 1
            ]);

            // Update fleet status
            if ($task->fleet) {
                $task->fleet->update([
                    'current_status' => 'completed'
                ]);

                // Log status fleet
                FleetStatusLog::create([
                    'fleet_id' => $task->fleet_id,
                    'task_id' => $task->id,
                    'status' => 'completed',
                    'recipient' => $request->recipient_name,
                    'description' => 'Delivery completed. Recipient: ' . $request->recipient_name,
                    'report_image' => $evidencePath,
                    'uploaded_by' => $user->id
                ]);
            }

            DB::commit();

            return redirect()->route('driver.dashboard')->with('success', 'Task completed successfully! Great job!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to complete task: ' . $e->getMessage());
        }
    }

    /**
     * Cancel/Reject task (batalkan task yang sudah diambil)
     */
    public function cancelTask(Request $request, $id)
    {
        $user = Auth::user();
        $driver = Driver::where('user_id', $user->id)->first();
        
        if (!$driver) {
            return back()->with('error', 'Driver profile not found');
        }

        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $task = Task::where('id', $id)
                ->where('driver_id', $driver->id)
                ->where('status', 'assigned')
                ->with('fleet')
                ->lockForUpdate()
                ->firstOrFail();

            // Kembalikan task ke pending dan lepas driver
            $task->update([
                'driver_id' => null,
                'status' => 'pending'
            ]);

            // Update driver status
            $driver->update([
                'current_status' => 'no_task'
            ]);

            // Update fleet status
            if ($task->fleet) {
                $task->fleet->update([
                    'current_status' => 'unassigned'
                ]);

                // Log status fleet
                FleetStatusLog::create([
                    'fleet_id' => $task->fleet_id,
                    'task_id' => $task->id,
                    'status' => 'unassigned',
                    'description' => 'Task cancelled by driver: ' . $user->name . '. Reason: ' . $request->reason,
                    'uploaded_by' => $user->id
                ]);
            }

            DB::commit();

            return redirect()->route('driver.dashboard')->with('success', 'Task cancelled and returned to available tasks');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to cancel task: ' . $e->getMessage());
        }
    }

    /**
     * Upload task cost (biaya operasional)
     */
    public function uploadCost(Request $request, $id)
    {
        $user = Auth::user();
        $driver = Driver::where('user_id', $user->id)->first();
        
        if (!$driver) {
            return back()->with('error', 'Driver profile not found');
        }

        $task = Task::where('id', $id)
            ->where('driver_id', $driver->id)
            ->firstOrFail();

        $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,digital',
            'receipt_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string|max:255'
        ]);

        $data = [
            'amount' => $request->amount,
            'payment_method' => $request->payment_method
        ];

        // Upload receipt jika ada
        if ($request->hasFile('receipt_image')) {
            $data['receipt_image'] = $request->file('receipt_image')
                ->store('task-costs', 'public');
        }

        $task->costs()->create($data);

        return back()->with('success', 'Cost recorded successfully');
    }

    /**
     * View available tasks (task yang bisa diambil)
     */
    public function availableTasks()
    {
        $user = Auth::user();
        
        if ($user->role !== 'driver') {
            abort(403, 'Unauthorized access');
        }

        $driver = Driver::where('user_id', $user->id)->first();
        
        if (!$driver) {
            return view('driver.available-tasks', [
                'tasks' => collect([]),
                'driver' => null
            ]);
        }

        // Ambil semua task yang belum ada driver
        $tasks = Task::whereNull('driver_id')
            ->where('status', 'pending')
            ->with(['fleet.category', 'creator'])
            ->orderBy('delivery_date', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('driver.available-tasks', compact('tasks', 'driver'));
    }
}