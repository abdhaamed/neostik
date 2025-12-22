<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fleet;
use App\Models\Driver;
use App\Models\Task;
use App\Models\GpsLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil statistik utama
        $totalFleets = Fleet::count();
        $totalDrivers = Driver::count();
        $totalTasks = Task::count();
        $activeFleets = Fleet::where('current_status', '!=','unassigned')->count();

        // Ambil data fleet terbaru untuk ditampilkan di sidebar kanan (mockup)
        $fleets = Fleet::with('category', 'device', 'tasks.driver.user', 'device.gpsLogs')
            ->limit(5)
            ->get();

        // Ambil data GPS terbaru untuk peta (misalnya 10 titik terakhir dari semua device)
        $latestGpsLogs = GpsLog::with('device.fleet')
            ->orderBy('timestamp', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($log) {
                return [
                    'fleet_id' => $log->device->fleet_id,
                    'license_plate' => $log->device->fleet->license_plate ?? 'Unknown',
                    'latitude' => (float) $log->latitude,
                    'longitude' => (float) $log->longitude,
                    'speed' => $log->speed ?? 0,
                    'address' => $log->address ?? 'Unknown location',
                    'timestamp' => $log->timestamp->format('d-m-Y H:i'),
                ];
            })
            ->values();

        return view('pages.dashboard', compact(
            'totalFleets',
            'totalDrivers',
            'totalTasks',
            'activeFleets',
            'fleets',
            'latestGpsLogs'
        ));
    }
}