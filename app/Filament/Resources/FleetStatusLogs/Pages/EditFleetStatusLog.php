<?php

namespace App\Filament\Resources\FleetStatusLogs\Pages;

use App\Filament\Resources\FleetStatusLogs\FleetStatusLogResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFleetStatusLog extends EditRecord
{
    protected static string $resource = FleetStatusLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
