<?php

namespace App\Http\Controllers;

class GeneralController extends AdminBaseController
{
    public function dashboard()
    {
        $fleetCounts = $this->getFleetCounts();
        return view('admin-dashboard.dashboard', compact('fleetCounts'));
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

    public function commandMessage()
    {
        $fleetCounts = $this->getFleetCounts();
        return view('admin-dashboard.command.message', compact('fleetCounts'));
    }

    public function commandBroadcast()
    {
        $fleetCounts = $this->getFleetCounts();
        return view('admin-dashboard.command.broadcast', compact('fleetCounts'));
    }
}