<?php

namespace App\Filament\Resources\TaskEvidence;

use App\Filament\Resources\TaskEvidence\Pages\CreateTaskEvidence;
use App\Filament\Resources\TaskEvidence\Pages\EditTaskEvidence;
use App\Filament\Resources\TaskEvidence\Pages\ListTaskEvidence;
use App\Filament\Resources\TaskEvidence\Schemas\TaskEvidenceForm;
use App\Filament\Resources\TaskEvidence\Tables\TaskEvidenceTable;
use App\Models\TaskEvidence;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TaskEvidenceResource extends Resource
{
    protected static ?string $model = TaskEvidence::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Schema $schema): Schema
    {
        return TaskEvidenceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TaskEvidenceTable::configure($table);
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
            'index' => ListTaskEvidence::route('/'),
            'create' => CreateTaskEvidence::route('/create'),
            'edit' => EditTaskEvidence::route('/{record}/edit'),
        ];
    }
}
