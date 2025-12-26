<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fleet;
use App\Models\Device;

class FleetDeviceController extends Controller
{
    public function index()
    {
        $fleets = Fleet::with('device')->get();
        return view('admin-dashboard.manager.fleet-device', compact('fleets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fleet_id' => 'required|unique:fleets,fleet_id',
            'device_id' => 'required|unique:devices,device_id',
            'imei' => 'required|unique:devices,imei',
            'sim_card' => 'nullable',
            'status' => 'required|in:Unassigned,Assigned,En Route,Completed',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('fleets', $imageName, 'public');
        }

        $fleet = Fleet::create([
            'fleet_id' => $request->fleet_id,
            'status' => $request->status,
            'image' => $imageName,
        ]);

        Device::create([
            'fleet_id' => $fleet->id,
            'device_id' => $request->device_id,
            'imei' => $request->imei,
            'sim_card' => $request->sim_card,
        ]);

        return response()->json([
            'success' => true,
            'fleet' => $fleet->load('device')
        ]);
    }
}
