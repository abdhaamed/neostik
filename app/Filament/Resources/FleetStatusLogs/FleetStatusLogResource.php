<?php

namespace App\Filament\Resources\FleetStatusLogs;

use App\Filament\Resources\FleetStatusLogs\Pages\CreateFleetStatusLog;
use App\Filament\Resources\FleetStatusLogs\Pages\EditFleetStatusLog;
use App\Filament\Resources\FleetStatusLogs\Pages\ListFleetStatusLogs;
use App\Filament\Resources\FleetStatusLogs\Schemas\FleetStatusLogForm;
use App\Filament\Resources\FleetStatusLogs\Tables\FleetStatusLogsTable;
use App\Models\FleetStatusLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FleetStatusLogResource extends Resource
{
    protected static ?string $model = FleetStatusLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'status';

    public static function form(Schema $schema): Schema
    {
        return FleetStatusLogForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FleetStatusLogsTable::configure($table);
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
            'index' => ListFleetStatusLogs::route('/'),
            'create' => CreateFleetStatusLog::route('/create'),
            'edit' => EditFleetStatusLog::route('/{record}/edit'),
        ];
    }
}
