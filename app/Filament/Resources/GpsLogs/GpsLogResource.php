<?php

namespace App\Filament\Resources\GpsLogs;

use App\Filament\Resources\GpsLogs\Pages\CreateGpsLog;
use App\Filament\Resources\GpsLogs\Pages\EditGpsLog;
use App\Filament\Resources\GpsLogs\Pages\ListGpsLogs;
use App\Filament\Resources\GpsLogs\Schemas\GpsLogForm;
use App\Filament\Resources\GpsLogs\Tables\GpsLogsTable;
use App\Models\GpsLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GpsLogResource extends Resource
{
    protected static ?string $model = GpsLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'longitude';

    public static function form(Schema $schema): Schema
    {
        return GpsLogForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GpsLogsTable::configure($table);
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
            'index' => ListGpsLogs::route('/'),
            'create' => CreateGpsLog::route('/create'),
            'edit' => EditGpsLog::route('/{record}/edit'),
        ];
    }
}
