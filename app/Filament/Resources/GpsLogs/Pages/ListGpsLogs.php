<?php

namespace App\Filament\Resources\GpsLogs\Pages;

use App\Filament\Resources\GpsLogs\GpsLogResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGpsLogs extends ListRecords
{
    protected static string $resource = GpsLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
