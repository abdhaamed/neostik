<?php

namespace App\Filament\Resources\FleetStatusLogs\Pages;

use App\Filament\Resources\FleetStatusLogs\FleetStatusLogResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFleetStatusLogs extends ListRecords
{
    protected static string $resource = FleetStatusLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
