<?php

namespace App\Filament\Resources\FleetCategories\Pages;

use App\Filament\Resources\FleetCategories\FleetCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFleetCategories extends ListRecords
{
    protected static string $resource = FleetCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
