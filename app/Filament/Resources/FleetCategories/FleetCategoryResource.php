<?php

namespace App\Filament\Resources\FleetCategories;

use App\Filament\Resources\FleetCategories\Pages\CreateFleetCategory;
use App\Filament\Resources\FleetCategories\Pages\EditFleetCategory;
use App\Filament\Resources\FleetCategories\Pages\ListFleetCategories;
use App\Filament\Resources\FleetCategories\Schemas\FleetCategoryForm;
use App\Filament\Resources\FleetCategories\Tables\FleetCategoriesTable;
use App\Models\FleetCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FleetCategoryResource extends Resource
{
    protected static ?string $model = FleetCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return FleetCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FleetCategoriesTable::configure($table);
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
            'index' => ListFleetCategories::route('/'),
            'create' => CreateFleetCategory::route('/create'),
            'edit' => EditFleetCategory::route('/{record}/edit'),
        ];
    }
}
