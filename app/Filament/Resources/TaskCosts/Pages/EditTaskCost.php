<?php

namespace App\Filament\Resources\TaskCosts\Pages;

use App\Filament\Resources\TaskCosts\TaskCostResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTaskCost extends EditRecord
{
    protected static string $resource = TaskCostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
