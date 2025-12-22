<?php

namespace App\Filament\Resources\TaskCosts\Pages;

use App\Filament\Resources\TaskCosts\TaskCostResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTaskCosts extends ListRecords
{
    protected static string $resource = TaskCostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
