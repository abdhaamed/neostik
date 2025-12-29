<?php

namespace App\Http\Controllers;

use App\Models\Fleet;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class AdminBaseController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function getFleetCounts()
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