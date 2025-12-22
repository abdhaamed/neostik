<?php

namespace App\Filament\Resources\DeviceActivityLogs\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DeviceActivityLogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('device_id')
                    ->required()
                    ->numeric(),
                TextInput::make('event')
                    ->required(),
                TextInput::make('location')
                    ->default(null),
                TextInput::make('latitude')
                    ->numeric()
                    ->default(null),
                TextInput::make('longitude')
                    ->numeric()
                    ->default(null),
                TextInput::make('speed')
                    ->numeric()
                    ->default(null),
                TextInput::make('status')
                    ->default(null),
                DateTimePicker::make('timestamp')
                    ->required(),
            ]);
    }
}
