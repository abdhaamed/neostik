<?php

namespace App\Filament\Resources\DeviceActivityLogs\Pages;

use App\Filament\Resources\DeviceActivityLogs\DeviceActivityLogResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDeviceActivityLog extends EditRecord
{
    protected static string $resource = DeviceActivityLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
