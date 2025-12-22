<?php

namespace App\Filament\Resources\DeviceActivityLogs;

use App\Filament\Resources\DeviceActivityLogs\Pages\CreateDeviceActivityLog;
use App\Filament\Resources\DeviceActivityLogs\Pages\EditDeviceActivityLog;
use App\Filament\Resources\DeviceActivityLogs\Pages\ListDeviceActivityLogs;
use App\Filament\Resources\DeviceActivityLogs\Schemas\DeviceActivityLogForm;
use App\Filament\Resources\DeviceActivityLogs\Tables\DeviceActivityLogsTable;
use App\Models\DeviceActivityLog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DeviceActivityLogResource extends Resource
{
    protected static ?string $model = DeviceActivityLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'event';

    public static function form(Schema $schema): Schema
    {
        return DeviceActivityLogForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DeviceActivityLogsTable::configure($table);
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
            'index' => ListDeviceActivityLogs::route('/'),
            'create' => CreateDeviceActivityLog::route('/create'),
            'edit' => EditDeviceActivityLog::route('/{record}/edit'),
        ];
    }
}
