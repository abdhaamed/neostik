<?php

namespace App\Filament\Resources\TaskEvidence\Pages;

use App\Filament\Resources\TaskEvidence\TaskEvidenceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTaskEvidence extends EditRecord
{
    protected static string $resource = TaskEvidenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
