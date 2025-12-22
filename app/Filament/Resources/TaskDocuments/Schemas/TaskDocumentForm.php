<?php

namespace App\Filament\Resources\TaskDocuments\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TaskDocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('task_id')
                    ->required()
                    ->numeric(),
                TextInput::make('document_type')
                    ->required(),
                TextInput::make('file_path')
                    ->required(),
            ]);
    }
}
