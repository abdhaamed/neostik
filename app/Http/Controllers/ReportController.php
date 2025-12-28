<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Fleet;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
// app/Http/Controllers/ReportController.php
public function routeHistory(Request $request)
{
    $query = Task::with(['driver', 'fleet']);

    // Filter by fleet
    if ($request->has('fleet')) {
        $query->where('fleet_id', $request->fleet);
    }

    // Filter by driver
    if ($request->has('driver')) {
        $query->where('driver_id', $request->driver);
    }

    // Filter by status
    if ($request->has('status')) {
        $query->where('status', $request->status);
    }

    $tasks = $query->orderBy('created_at', 'desc')->paginate(10);

    // ✅ KIRIM DATA UNTUK FILTER
    $fleets = Fleet::orderBy('fleet_id')->get();
    $drivers = User::where('role', 'driver')->orderBy('name')->get();

    return view('admin-dashboard.report.route-history', compact(
        'tasks', 
        'fleets', 
        'drivers'
    ));
}

    public function operationalReport()
    {
        // Hitung statistik berdasarkan data real
        $stats = [
            'total_tasks' => Task::count(),
            'active_fleets' => Fleet::whereIn('status', ['Assigned', 'En Route'])->count(),
            'completed_tasks' => Task::where('status', 'completed')->count(),
            'pending_assignments' => Fleet::where('status', 'Unassigned')->count(),
        ];

        // Hitung distribusi status task
        $taskStatusCounts = Task::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Hitung distribusi status fleet
        $fleetStatusCounts = Fleet::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Ambil recent tasks
        $recentTasks = Task::with(['driver', 'fleet'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('admin-dashboard.report.operational-report', compact(
            'stats',
            'taskStatusCounts',
            'fleetStatusCounts',
            'recentTasks'
        ));
    }
}
