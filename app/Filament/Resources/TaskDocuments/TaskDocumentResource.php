<?php

namespace App\Filament\Resources\TaskDocuments;

use App\Filament\Resources\TaskDocuments\Pages\CreateTaskDocument;
use App\Filament\Resources\TaskDocuments\Pages\EditTaskDocument;
use App\Filament\Resources\TaskDocuments\Pages\ListTaskDocuments;
use App\Filament\Resources\TaskDocuments\Schemas\TaskDocumentForm;
use App\Filament\Resources\TaskDocuments\Tables\TaskDocumentsTable;
use App\Models\TaskDocument;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TaskDocumentResource extends Resource
{
    protected static ?string $model = TaskDocument::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'document_type';

    public static function form(Schema $schema): Schema
    {
        return TaskDocumentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TaskDocumentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTaskDocuments::route('/'),
            'create' => CreateTaskDocument::route('/create'),
            'edit' => EditTaskDocument::route('/{record}/edit'),
        ];
    }
}
