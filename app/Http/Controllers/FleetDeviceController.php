<?php

namespace App\Http\Controllers;

use App\Models\Fleet;
use App\Models\FleetCategory;
use Illuminate\Http\Request;

class FleetDeviceController extends Controller
{
    /**
     * Display fleet device management page
     */
    public function index(Request $request)
    {
        // Get filter parameters
        $status = $request->get('status');
        $category = $request->get('category');
        $search = $request->get('search');

        // Query fleets with relationships
        $fleets = Fleet::with([
            'category',
            'device.gpsLogs' => function($query) {
                $query->latest()->limit(1);
            },
            'device.activityLogs' => function($query) {
                $query->latest()->limit(10);
            },
            'tasks' => function($query) {
                $query->whereIn('status', ['pending', 'approved'])
                      ->latest()
                      ->with('driver.user');
            },
            'statusLogs' => function($query) {
                $query->latest()->limit(10)->with('uploader');
            }
        ])
        ->when($status, function($query, $status) {
            return $query->where('current_status', $status);
        })
        ->when($category, function($query, $category) {
            return $query->where('category_id', $category);
        })
        ->when($search, function($query, $search) {
            return $query->where(function($q) use ($search) {
                $q->where('serial_number', 'like', "%{$search}%")
                  ->orWhere('license_plate', 'like', "%{$search}%");
            });
        })
        ->orderBy('created_at', 'desc')
        ->get();

        // Transform data untuk view
        $fleets = $fleets->map(function($fleet) {
            $currentTask = $fleet->tasks->first();
            $latestGps = $fleet->device?->gpsLogs->first();

            return [
                'id' => $fleet->id,
                'serial_number' => $fleet->serial_number,
                'license_plate' => $fleet->license_plate,
                'category' => $fleet->category->name,
                'capacity' => $fleet->capacity,
                'current_status' => $fleet->current_status,
                'image' => $fleet->image,
                'device' => $fleet->device ? [
                    'id' => $fleet->device->id,
                    'device_code' => $fleet->device->device_code,
                    'imei_number' => $fleet->device->imei_number,
                    'sim_card_number' => $fleet->device->sim_card_number,
                    'connection_status' => $fleet->device->connection_status,
                    'signal_strength' => $fleet->device->signal_strength,
                    'last_update' => $fleet->device->last_update?->format('d M Y, H:i'),
                    'gps' => $latestGps ? [
                        'latitude' => $latestGps->latitude,
                        'longitude' => $latestGps->longitude,
                        'speed' => $latestGps->speed,
                        'address' => $latestGps->address,
                    ] : null,
                    'activity_logs' => $fleet->device->activityLogs->map(function($log) {
                        return [
                            'timestamp' => $log->timestamp->format('d M Y, H:i'),
                            'event' => $log->event,
                            'location' => $log->location,
                            'status' => $log->status,
                        ];
                    }),
                ] : null,
                'current_task' => $currentTask ? [
                    'task_number' => $currentTask->task_number,
                    'driver_name' => $currentTask->driver->user->name,
                    'origin' => $currentTask->origin,
                    'destination' => $currentTask->destination,
                    'goods_type' => $currentTask->goods_type,
                    'delivery_date' => $currentTask->delivery_date->format('d M Y'),
                ] : null,
                'status_logs' => $fleet->statusLogs->map(function($log) {
                    return [
                        'status' => $log->status,
                        'recipient' => $log->recipient,
                        'description' => $log->description,
                        'report_image' => $log->report_image,
                        'uploaded_by' => $log->uploader->name,
                        'created_at' => $log->created_at->format('d M Y, H:i'),
                    ];
                }),
            ];
        });

        // Get fleet categories for filter
        $categories = FleetCategory::all();

        // Get status summary for badges
        $statusSummary = [
            'total' => Fleet::count(),
            'unassigned' => Fleet::where('current_status', 'unassigned')->count(),
            'assigned' => Fleet::where('current_status', 'assigned')->count(),
            'en_route' => Fleet::where('current_status', 'en_route')->count(),
            'completed' => Fleet::where('current_status', 'completed')->count(),
        ];

        return view('pages.manager.fleet-device', compact(
            'fleets',
            'categories',
            'statusSummary'
        ));
    }
}