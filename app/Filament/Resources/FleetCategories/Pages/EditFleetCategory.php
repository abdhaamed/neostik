<?php

namespace App\Filament\Resources\FleetCategories\Pages;

use App\Filament\Resources\FleetCategories\FleetCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFleetCategory extends EditRecord
{
    protected static string $resource = FleetCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
