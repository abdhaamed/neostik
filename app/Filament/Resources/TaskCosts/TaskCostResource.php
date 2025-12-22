<?php

namespace App\Filament\Resources\TaskCosts;

use App\Filament\Resources\TaskCosts\Pages\CreateTaskCost;
use App\Filament\Resources\TaskCosts\Pages\EditTaskCost;
use App\Filament\Resources\TaskCosts\Pages\ListTaskCosts;
use App\Filament\Resources\TaskCosts\Schemas\TaskCostForm;
use App\Filament\Resources\TaskCosts\Tables\TaskCostsTable;
use App\Models\TaskCost;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TaskCostResource extends Resource
{
    protected static ?string $model = TaskCost::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'amount';

    public static function form(Schema $schema): Schema
    {
        return TaskCostForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TaskCostsTable::configure($table);
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
            'index' => ListTaskCosts::route('/'),
            'create' => CreateTaskCost::route('/create'),
            'edit' => EditTaskCost::route('/{record}/edit'),
        ];
    }
}
