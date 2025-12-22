<?php

namespace App\Filament\Resources\TaskDocuments\Pages;

use App\Filament\Resources\TaskDocuments\TaskDocumentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTaskDocuments extends ListRecords
{
    protected static string $resource = TaskDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
