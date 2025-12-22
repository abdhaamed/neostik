<?php

namespace App\Filament\Resources\TaskEvidence\Pages;

use App\Filament\Resources\TaskEvidence\TaskEvidenceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTaskEvidence extends ListRecords
{
    protected static string $resource = TaskEvidenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
