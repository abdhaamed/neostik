<?php

namespace App\Http\Controllers;

use App\Models\Fleet;

class AdminController extends Controller
{
    public function dashboard()
    {
        $fleetCounts = $this->getFleetCounts();
        return view('admin-dashboard.dashboard', compact('fleetCounts'));
    }

    public function message()
    {
        $fleetCounts = $this->getFleetCounts();
        return view('admin-dashboard.command.message', compact('fleetCounts'));
    }

    public function broadcast()
    {
        $fleetCounts = $this->getFleetCounts();
        return view('admin-dashboard.command.broadcast', compact('fleetCounts'));
    }

    public function auditLogs()
    {
        $fleetCounts = $this->getFleetCounts();
        return view('admin-dashboard.audit-logs', compact('fleetCounts'));
    }

    public function alert()
    {
        $fleetCounts = $this->getFleetCounts();
        return view('admin-dashboard.alert', compact('fleetCounts'));
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