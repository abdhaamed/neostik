<?php

namespace App\Filament\Resources\FleetStatusLogs\Pages;

use App\Filament\Resources\FleetStatusLogs\FleetStatusLogResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFleetStatusLog extends CreateRecord
{
    protected static string $resource = FleetStatusLogResource::class;
}
