<?php

namespace App\Filament\Resources\TaskDocuments\Pages;

use App\Filament\Resources\TaskDocuments\TaskDocumentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTaskDocument extends EditRecord
{
    protected static string $resource = TaskDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
