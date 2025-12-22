<?php

namespace App\Filament\Resources\TaskDocuments\Pages;

use App\Filament\Resources\TaskDocuments\TaskDocumentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTaskDocument extends CreateRecord
{
    protected static string $resource = TaskDocumentResource::class;
}
