<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fleet;
use App\Models\Device;
use App\Models\DeviceHistory;
use Illuminate\Support\Facades\Storage;

class FleetDeviceController extends Controller
{
    // List all fleets with devices
    public function index()
    {
        $fleets = Fleet::with('device')->get();
        return view('admin-dashboard.manager.fleet-device', compact('fleets'));
    }

    // Show fleet detail
    public function showFleet($id)
    {
        $fleet = Fleet::with('device')->findOrFail($id);
        return view('admin-dashboard.manager.fleet-detail', compact('fleet'));
    }

    // Show device detail
    public function showDevice($id)
    {
        $device = Device::with(['fleet', 'histories'])->findOrFail($id);
        return view('admin-dashboard.manager.device-detail', compact('device'));
    }

    // Store new fleet and device
    public function store(Request $request)
    {
        $request->validate([
            'fleet_id' => 'required|unique:fleets,fleet_id',
            'status' => 'required|in:Unassigned,Assigned,En Route,Completed',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'weight' => 'nullable|numeric|min:0',

            'device_id' => 'required|unique:devices,device_id',
            'imei' => 'required|unique:devices,imei',
            'sim_card' => 'nullable|string',

            // Bukti Operasional
            'unassigned_recipient' => 'nullable|string',
            'unassigned_description' => 'nullable|string',
            'assigned_recipient' => 'nullable|string',
            'assigned_description' => 'nullable|string',
            'enroute_recipient' => 'nullable|string',
            'enroute_description' => 'nullable|string',
            'completed_recipient' => 'nullable|string',
            'completed_description' => 'nullable|string',
        ]);

        // Handle image upload
        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('fleets', $imageName, 'public');
        }

        // Create fleet
        $fleet = Fleet::create([
            'fleet_id' => $request->fleet_id,
            'status' => $request->status,
            'image' => $imageName,
            'weight' => $request->weight,
            'unassigned_recipient' => $request->unassigned_recipient,
            'unassigned_description' => $request->unassigned_description,
            'assigned_recipient' => $request->assigned_recipient,
            'assigned_description' => $request->assigned_description,
            'enroute_recipient' => $request->enroute_recipient,
            'enroute_description' => $request->enroute_description,
            'completed_recipient' => $request->completed_recipient,
            'completed_description' => $request->completed_description,
        ]);

        // Create device
        // Create device
        Device::create([
            'fleet_id' => $fleet->id,
            'device_id' => $request->device_id,
            'imei' => $request->imei,
            'sim_card' => $request->sim_card,
            'connection_status' => 'Disconnected',
            'signal_strength' => 'Good',
            // Koordinat default (Jakarta)
            'latitude' => -6.2088,
            'longitude' => 106.8456,
        ]);
        return response()->json([
            'success' => true,
            'fleet' => $fleet->load('device')
        ]);
    }

    // Update fleet
    public function updateFleet(Request $request, $id)
    {
        $fleet = Fleet::findOrFail($id);

        $request->validate([
            'fleet_id' => 'required|unique:fleets,fleet_id,' . $id,
            'status' => 'required|in:Unassigned,Assigned,En Route,Completed',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'weight' => 'nullable|numeric|min:0',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($fleet->image) {
                Storage::disk('public')->delete('fleets/' . $fleet->image);
            }

            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('fleets', $imageName, 'public');
            $fleet->image = $imageName;
        }

        $fleet->update([
            'fleet_id' => $request->fleet_id,
            'status' => $request->status,
            'weight' => $request->weight,
            'unassigned_recipient' => $request->unassigned_recipient,
            'unassigned_description' => $request->unassigned_description,
            'assigned_recipient' => $request->assigned_recipient,
            'assigned_description' => $request->assigned_description,
            'enroute_recipient' => $request->enroute_recipient,
            'enroute_description' => $request->enroute_description,
            'completed_recipient' => $request->completed_recipient,
            'completed_description' => $request->completed_description,
        ]);

        return response()->json([
            'success' => true,
            'fleet' => $fleet->load('device')
        ]);
    }

    // Update device location and status
    public function updateDevice(Request $request, $id)
    {
        $device = Device::findOrFail($id);

        $request->validate([
            'connection_status' => 'nullable|in:Connected,Disconnected,Idle',
            'signal_strength' => 'nullable|in:Weak,Fair,Good,Strong,Excellent',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'speed' => 'nullable|numeric|min:0',
            'address' => 'nullable|string',
        ]);

        $device->update([
            'connection_status' => $request->connection_status ?? $device->connection_status,
            'signal_strength' => $request->signal_strength ?? $device->signal_strength,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'speed' => $request->speed,
            'address' => $request->address,
            'last_update' => now(),
        ]);

        return response()->json([
            'success' => true,
            'device' => $device
        ]);
    }

    // Add device history entry
    public function addDeviceHistory(Request $request, $deviceId)
    {
        $request->validate([
            'event_type' => 'required|string',
            'location' => 'nullable|string',
            'status' => 'required|in:Active,Started,Idle,Stopped,Connected,Disconnected',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $history = DeviceHistory::create([
            'device_id' => $deviceId,
            'event_timestamp' => now(),
            'event_type' => $request->event_type,
            'location' => $request->location,
            'status' => $request->status,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return response()->json([
            'success' => true,
            'history' => $history
        ]);
    }

    // Get device histories for AJAX
    public function getDeviceHistories($deviceId)
    {
        $device = Device::findOrFail($deviceId);
        $histories = $device->histories()->take(10)->get();

        return response()->json([
            'success' => true,
            'histories' => $histories
        ]);
    }

    // Delete fleet and its device
    public function destroy($id)
    {
        $fleet = Fleet::findOrFail($id);

        // Delete image if exists
        if ($fleet->image) {
            Storage::disk('public')->delete('fleets/' . $fleet->image);
        }

        $fleet->delete(); // Will cascade delete device and histories

        return response()->json([
            'success' => true,
            'message' => 'Fleet deleted successfully'
        ]);
    }
}
