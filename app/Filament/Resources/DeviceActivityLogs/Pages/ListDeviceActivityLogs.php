<?php

namespace App\Filament\Resources\DeviceActivityLogs\Pages;

use App\Filament\Resources\DeviceActivityLogs\DeviceActivityLogResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDeviceActivityLogs extends ListRecords
{
    protected static string $resource = DeviceActivityLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
