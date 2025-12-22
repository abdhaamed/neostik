<?php

namespace App\Filament\Resources\GpsLogs\Pages;

use App\Filament\Resources\GpsLogs\GpsLogResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGpsLog extends EditRecord
{
    protected static string $resource = GpsLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
