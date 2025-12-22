<?php

namespace App\Filament\Resources\Devices\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DeviceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('fleet_id')
                    ->required()
                    ->numeric(),
                TextInput::make('device_code')
                    ->required(),
                TextInput::make('imei_number')
                    ->required(),
                TextInput::make('sim_card_number')
                    ->default(null),
                Select::make('connection_status')
                    ->options(['connected' => 'Connected', 'disconnected' => 'Disconnected'])
                    ->default('disconnected')
                    ->required(),
                TextInput::make('signal_strength')
                    ->default(null),
                DateTimePicker::make('last_update'),
            ]);
    }
}
