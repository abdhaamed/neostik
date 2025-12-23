<?php

namespace App\Http\Controllers;

use App\Models\Fleet;
use App\Models\FleetCategory;
use App\Models\Device;
use App\Models\Driver;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FleetDeviceController extends Controller
{
    /**
     * Display the fleet & device management page
     */
    public function index(Request $request)
    {
        // Get all fleet categories for filter
        $fleetCategories = FleetCategory::all();

        // Build fleet query with relationships
        $fleetsQuery = Fleet::with([
            'category',
            'device',
            'tasks' => function ($query) {
                $query->whereIn('status', ['approved', 'pending'])
                      ->with('driver.user');
            }
        ]);

        // Apply category filter if selected
        if ($request->has('category') && $request->category != '') {
            $fleetsQuery->where('category_id', $request->category);
        }

        // Apply status filter if selected
        if ($request->has('status') && $request->status != '') {
            $fleetsQuery->where('current_status', $request->status);
        }

        // Apply search filter
        if ($request->has('search') && $request->search != '') {
            $fleetsQuery->where(function ($q) use ($request) {
                $q->where('license_plate', 'like', '%' . $request->search . '%')
                  ->orWhere('serial_number', 'like', '%' . $request->search . '%');
            });
        }

        // Get fleets with pagination
        $fleets = $fleetsQuery->orderBy('license_plate', 'asc')->get();

        // Get selected fleet if fleet_id is provided
        $selectedFleet = null;
        if ($request->has('fleet_id')) {
            $selectedFleet = Fleet::with([
                'category',
                'device',
                'tasks' => function ($query) {
                    $query->whereIn('status', ['approved', 'pending'])
                          ->with('driver.user');
                }
            ])->find($request->fleet_id);
        }

        // Get statistics
        $statistics = $this->getStatistics();

        return view('pages.manager.fleet-device', compact(
            'fleets',
            'fleetCategories',
            'selectedFleet',
            'statistics'
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
            },
            'statusLogs' => function ($query) {
                $query->latest()->limit(10);
            }
        ])->findOrFail($id);

        // Get active task
        $activeTask = $fleet->tasks->first();

        return response()->json([
            'success' => true,
            'data' => [
                'fleet' => $fleet,
                'device' => $fleet->device,
                'active_task' => $activeTask,
                'driver' => $activeTask?->driver?->user,
                'latest_gps' => $fleet->device?->gpsLogs->first(),
                'device_status' => $fleet->device?->connection_status ?? 'disconnected',
                'status_logs' => $fleet->statusLogs
            ]
        ]);
    }

    /**
     * Get device detail via AJAX
     */
    public function getDeviceDetail($fleetId)
    {
        $fleet = Fleet::with([
            'device.gpsLogs' => function ($query) {
                $query->latest()->limit(20);
            },
            'device.activityLogs' => function ($query) {
                $query->latest()->limit(20);
            }
        ])->findOrFail($fleetId);

        $device = $fleet->device;

        if (!$device) {
            return response()->json([
                'success' => false,
                'message' => 'Device not found for this fleet'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'device' => $device,
                'gps_logs' => $device->gpsLogs,
                'activity_logs' => $device->activityLogs,
                'latest_location' => $device->gpsLogs->first()
            ]
        ]);
    }

    /**
     * Store new fleet
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'serial_number' => 'required|string|unique:fleets,serial_number',
            'license_plate' => 'required|string|unique:fleets,license_plate',
            'category_id' => 'required|exists:fleet_categories,id',
            'capacity' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('fleets', 'public');
        }

        $fleet = Fleet::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Fleet created successfully',
            'data' => $fleet
        ]);
    }

    /**
     * Update fleet
     */
    public function update(Request $request, $id)
    {
        $fleet = Fleet::findOrFail($id);

        $validated = $request->validate([
            'serial_number' => 'required|string|unique:fleets,serial_number,' . $id,
            'license_plate' => 'required|string|unique:fleets,license_plate,' . $id,
            'category_id' => 'required|exists:fleet_categories,id',
            'capacity' => 'required|string',
            'current_status' => 'nullable|in:unassigned,assigned,en_route,completed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($fleet->image) {
                Storage::disk('public')->delete($fleet->image);
            }
            $validated['image'] = $request->file('image')->store('fleets', 'public');
        }

        $fleet->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Fleet updated successfully',
            'data' => $fleet
        ]);
    }

    /**
     * Delete fleet
     */
    public function destroy($id)
    {
        $fleet = Fleet::findOrFail($id);

        // Delete image if exists
        if ($fleet->image) {
            Storage::disk('public')->delete($fleet->image);
        }

        $fleet->delete();

        return response()->json([
            'success' => true,
            'message' => 'Fleet deleted successfully'
        ]);
    }

    /**
     * Assign device to fleet
     */
    public function assignDevice(Request $request, $fleetId)
    {
        $fleet = Fleet::findOrFail($fleetId);

        $validated = $request->validate([
            'device_code' => 'required|string|unique:devices,device_code',
            'imei_number' => 'required|string|unique:devices,imei_number',
            'sim_card_number' => 'nullable|string'
        ]);

        $validated['fleet_id'] = $fleetId;

        $device = Device::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Device assigned successfully',
            'data' => $device
        ]);
    }

    /**
     * Update device
     */
    public function updateDevice(Request $request, $deviceId)
    {
        $device = Device::findOrFail($deviceId);

        $validated = $request->validate([
            'device_code' => 'required|string|unique:devices,device_code,' . $deviceId,
            'imei_number' => 'required|string|unique:devices,imei_number,' . $deviceId,
            'sim_card_number' => 'nullable|string',
            'connection_status' => 'nullable|in:connected,disconnected'
        ]);

        $device->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Device updated successfully',
            'data' => $device
        ]);
    }

    /**
     * Remove device from fleet
     */
    public function removeDevice($deviceId)
    {
        $device = Device::findOrFail($deviceId);
        $device->delete();

        return response()->json([
            'success' => true,
            'message' => 'Device removed successfully'
        ]);
    }

    /**
     * Get statistics for badges
     */
    private function getStatistics()
    {
        return [
            'total_fleets' => Fleet::count(),
            'active_fleets' => Fleet::whereIn('current_status', ['assigned', 'en_route'])->count(),
            'available_fleets' => Fleet::where('current_status', 'unassigned')->count(),
            'total_devices' => Device::count(),
            'connected_devices' => Device::where('connection_status', 'connected')->count(),
            'disconnected_devices' => Device::where('connection_status', 'disconnected')->count()
        ];
    }
}