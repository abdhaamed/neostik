<?php

namespace App\Filament\Resources\DeviceActivityLogs\Pages;

use App\Filament\Resources\DeviceActivityLogs\DeviceActivityLogResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDeviceActivityLog extends CreateRecord
{
    protected static string $resource = DeviceActivityLogResource::class;
}
