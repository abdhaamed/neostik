<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fleet;
use App\Models\Driver;
use App\Models\Task;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with fleet data
     */
    public function index(Request $request)
    {
        // Get all fleets with their relationships
        $fleetsQuery = Fleet::with([
            'category',
            'device.gpsLogs' => function ($query) {
                $query->latest()->limit(1);
            },
            'tasks' => function ($query) {
                $query->whereIn('status', ['approved', 'pending'])
                      ->with('driver.user');
            }
        ]);

        // Apply filters if any
        if ($request->has('category') && $request->category != '') {
            $fleetsQuery->where('category_id', $request->category);
        }

        if ($request->has('status') && $request->status != '') {
            $fleetsQuery->where('current_status', $request->status);
        }

        if ($request->has('search') && $request->search != '') {
            $fleetsQuery->where(function ($q) use ($request) {
                $q->where('license_plate', 'like', '%' . $request->search . '%')
                  ->orWhere('serial_number', 'like', '%' . $request->search . '%');
            });
        }

        $fleets = $fleetsQuery->orderBy('license_plate', 'asc')->get();

        // Get selected fleet detail if fleet_id is provided
        $selectedFleet = null;
        if ($request->has('fleet_id')) {
            $selectedFleet = Fleet::with([
                'category',
                'device.gpsLogs' => function ($query) {
                    $query->latest()->limit(10);
                },
                'device.activityLogs' => function ($query) {
                    $query->latest()->limit(10);
                },
                'tasks' => function ($query) {
                    $query->whereIn('status', ['approved', 'pending'])
                          ->with('driver.user');
                }
            ])->find($request->fleet_id);
        }

        // Get statistics for badges
        $statistics = $this->getStatistics();

        // Get all fleet categories for filter
        $fleetCategories = \App\Models\FleetCategory::all();

        return view('pages.dashboard', compact(
            'fleets',
            'selectedFleet',
            'statistics',
            'fleetCategories'
        ));
    }

    /**
     * Get fleet detail via AJAX
     */
    public function getFleetDetail($id)
    {
        $fleet = Fleet::with([
            'category',
            'device.gpsLogs' => function ($query) {
                $query->latest()->limit(10);
            },
            'device.activityLogs' => function ($query) {
                $query->latest()->limit(10);
            },
            'tasks' => function ($query) {
                $query->whereIn('status', ['approved', 'pending'])
                      ->with('driver.user');
            }
        ])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'fleet' => $fleet,
                'active_task' => $fleet->tasks->first(),
                'driver' => $fleet->tasks->first()?->driver?->user,
                'latest_gps' => $fleet->device?->gpsLogs->first(),
                'device_status' => $fleet->device?->connection_status ?? 'disconnected'
            ]
        ]);
    }

    /**
     * Get statistics for dashboard badges
     */
    private function getStatistics()
    {
        return [
            'total_fleets' => Fleet::count(),
            'active_fleets' => Fleet::whereIn('current_status', ['assigned', 'en_route'])->count(),
            'available_fleets' => Fleet::where('current_status', 'unassigned')->count(),
            'total_drivers' => Driver::count(),
            'available_drivers' => Driver::where('current_status', 'no_task')
                                        ->where('availability', 'available')
                                        ->count(),
            'active_tasks' => Task::whereIn('status', ['approved', 'pending'])->count(),
            'completed_today' => Task::where('status', 'completed')
                                    ->whereDate('updated_at', today())
                                    ->count(),
            'connected_devices' => Device::where('connection_status', 'connected')->count(),
            'disconnected_devices' => Device::where('connection_status', 'disconnected')->count()
        ];
    }

    /**
     * Get GPS tracking data for map markers
     */
    public function getGpsData(Request $request)
    {
        $fleets = Fleet::with([
            'category',
            'device.gpsLogs' => function ($query) {
                $query->latest()->limit(1);
            },
            'tasks' => function ($query) {
                $query->whereIn('status', ['approved', 'pending'])
                      ->with('driver.user');
            }
        ])->whereHas('device.gpsLogs')->get();

        $markers = $fleets->map(function ($fleet) {
            $latestGps = $fleet->device?->gpsLogs->first();
            $activeTask = $fleet->tasks->first();
            
            if (!$latestGps) {
                return null;
            }

            return [
                'id' => $fleet->id,
                'license_plate' => $fleet->license_plate,
                'latitude' => (float) $latestGps->latitude,
                'longitude' => (float) $latestGps->longitude,
                'speed' => $latestGps->speed ?? 0,
                'address' => $latestGps->address ?? 'Unknown location',
                'status' => $fleet->current_status,
                'category' => $fleet->category?->name ?? 'Unknown',
                'driver_name' => $activeTask?->driver?->user?->name ?? 'No driver',
                'last_update' => $latestGps->timestamp->format('Y-m-d H:i:s')
            ];
        })->filter()->values();

        return response()->json([
            'success' => true,
            'markers' => $markers
        ]);
    }

    /**
     * Get route history for playback
     */
    public function getRouteHistory(Request $request, $fleetId)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $fleet = Fleet::with('device')->findOrFail($fleetId);

        if (!$fleet->device) {
            return response()->json([
                'success' => false,
                'message' => 'Device not found for this fleet'
            ], 404);
        }

        $gpsLogs = $fleet->device->gpsLogs()
            ->whereBetween('timestamp', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ])
            ->orderBy('timestamp', 'asc')
            ->get()
            ->map(function ($log) {
                return [
                    'latitude' => (float) $log->latitude,
                    'longitude' => (float) $log->longitude,
                    'speed' => $log->speed ?? 0,
                    'address' => $log->address ?? '',
                    'timestamp' => $log->timestamp->format('Y-m-d H:i:s')
                ];
            });

        return response()->json([
            'success' => true,
            'route' => $gpsLogs,
            'total_points' => $gpsLogs->count()
        ]);
    }
}