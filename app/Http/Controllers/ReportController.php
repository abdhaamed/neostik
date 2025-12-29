<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Fleet;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function routeHistory(Request $request)
    {
        $query = Task::with(['driver', 'fleet']);

        if ($request->has('fleet')) {
            $query->where('fleet_id', $request->fleet);
        }
        if ($request->has('driver')) {
            $query->where('driver_id', $request->driver);
        }
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $tasks = $query->orderBy('created_at', 'desc')->paginate(10);
        $fleets = Fleet::orderBy('fleet_id')->get();
        $drivers = User::where('role', 'driver')->orderBy('name')->get();
        $fleetCounts = $this->getFleetCounts(); // ✅ Tambahkan ini

        return view('admin-dashboard.report.route-history', compact(
            'tasks',
            'fleets',
            'drivers',
            'fleetCounts'
        ));
    }

    public function operationalReport()
    {
        $stats = [
            'total_tasks' => Task::count(),
            'active_fleets' => Fleet::whereIn('status', ['Assigned', 'En Route'])->count(),
            'completed_tasks' => Task::where('status', 'completed')->count(),
            'pending_assignments' => Fleet::where('status', 'Unassigned')->count(),
        ];

        $taskStatusCounts = Task::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $fleetStatusCounts = Fleet::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $recentTasks = Task::with(['driver', 'fleet'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $fleetCounts = $this->getFleetCounts(); // ✅ Tambahkan ini

        return view('admin-dashboard.report.operational-report', compact(
            'stats',
            'taskStatusCounts',
            'fleetStatusCounts',
            'recentTasks',
            'fleetCounts'
        ));
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
}
