<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fleet;
use App\Models\Device;
use App\Models\DeviceHistory;
use App\Models\Task;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class FleetDeviceController extends Controller
{
    public function index()
    {
        $fleets = Fleet::with('device')->get();
        $fleetCounts = $this->getFleetCounts(); // ✅ DITAMBAHKAN
        return view('admin-dashboard.manager.fleet-device', compact('fleets', 'fleetCounts'));
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


    public function showFleet($id)
    {
        $fleet = Fleet::with('device')->findOrFail($id);
        $fleetCounts = $this->getFleetCounts(); // ✅ DITAMBAHKAN
        return view('admin-dashboard.manager.fleet-detail', compact('fleet', 'fleetCounts'));
    }

    public function showDevice($id)
    {
        $device = Device::with(['fleet', 'histories'])->findOrFail($id);
        $fleetCounts = $this->getFleetCounts(); // ✅ DITAMBAHKAN
        return view('admin-dashboard.manager.device-detail', compact('device', 'fleetCounts'));
    }

    // ✅ INI ADALAH METHOD YANG DIPANGGIL OLEH ROUTE: POST /fleet-device
    public function store(Request $request)
    {
        $request->validate([
            'fleet_id' => 'required|unique:fleets,fleet_id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'weight' => 'nullable|numeric|min:0',
            'device_id' => 'required|unique:devices,device_id',
            'imei' => 'required|unique:devices,imei',
            'sim_card' => 'nullable|string',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('fleets', $imageName, 'public');
        }

        $fleet = Fleet::create([
            'fleet_id' => $request->fleet_id,
            'status' => 'Unassigned',
            'image' => $imageName,
            'weight' => $request->weight,
        ]);

        Device::create([
            'fleet_id' => $fleet->id,
            'device_id' => $request->device_id,
            'imei' => $request->imei,
            'sim_card' => $request->sim_card,
            'connection_status' => 'Disconnected',
            'signal_strength' => 'Good',
            'latitude' => -6.2088,
            'longitude' => 106.8456,
            'speed' => null,
            'address' => null,
            'last_update' => now(),
        ]);

        return response()->json([
            'success' => true,
            'fleet' => $fleet->load('device')
        ]);
    }

    public function updateFleet(Request $request, $id)
    {
        $fleet = Fleet::findOrFail($id);

        if (in_array($fleet->status, ['En Route', 'Completed'])) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot modify fleet that is already in progress or completed.'
            ], 403);
        }

        $request->validate([
            'fleet_id' => 'required|unique:fleets,fleet_id,' . $id,
            'status' => 'required|in:Unassigned,Assigned',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'weight' => 'nullable|numeric|min:0',
        ]);

        if ($request->hasFile('image')) {
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
        ]);

        return response()->json([
            'success' => true,
            'fleet' => $fleet->load('device')
        ]);
    }

    public function updateDevice(Request $request, $id)
    {
        $device = Device::findOrFail($id);

        $request->validate([
            'connection_status' => 'nullable|in:Connected,Disconnected,Idle',
            'signal_strength' => 'nullable|in:Weak,Fair,Good,Strong,Excellent',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
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

        return response()->json(['success' => true, 'device' => $device]);
    }

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

        return response()->json(['success' => true, 'history' => $history]);
    }

    public function getDeviceHistories($deviceId)
    {
        $histories = DeviceHistory::where('device_id', $deviceId)->latest()->take(10)->get();
        return response()->json(['success' => true, 'histories' => $histories]);
    }

    public function destroy($id)
    {
        $fleet = Fleet::findOrFail($id);

        if (in_array($fleet->status, ['Assigned', 'En Route'])) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete fleet that is currently assigned or in route.'
            ], 403);
        }

        if ($fleet->image) {
            Storage::disk('public')->delete('fleets/' . $fleet->image);
        }

        $fleet->delete();
        return response()->json(['success' => true, 'message' => 'Fleet deleted successfully']);
    }

    public function acceptCompleted(Request $request, Fleet $fleet)
    {
        if ($fleet->status !== 'Completed') {
            return response()->json([
                'success' => false,
                'message' => 'Fleet is not in Completed status.'
            ], 400);
        }

        $fleet->updateBuktiOperasional([
            'completed_recipient' => Auth::user()->name,
            'completed_description' => 'Task accepted by admin',
            'completed_report' => null,
        ]);

        $fleet->update([
            'accepted_by_admin' => true,
            'accepted_at' => now(),
            'accepted_by' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Task accepted successfully.'
        ]);
    }

    public function apiGetFleets()
    {
        $fleets = Fleet::with('device')->orderBy('fleet_id')->get();
        return response()->json([
            'success' => true,
            'fleets' => $fleets
        ]);
    }

    public function apiGetFleetTask($id)
    {
        $fleet = Fleet::findOrFail($id);
        $task = Task::with('driver')
            ->where('fleet_id', $fleet->id)
            ->whereIn('status', ['assigned', 'en_route', 'completed'])
            ->latest()
            ->first();

        return response()->json([
            'success' => true,
            'task' => $task
        ]);
    }
}
