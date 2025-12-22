<?php

namespace App\Filament\Resources\Drivers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DriverForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('driver_code')
                    ->required(),
                TextInput::make('rating')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('total_completed')
                    ->required()
                    ->numeric()
                    ->default(0),
                Select::make('availability')
                    ->options(['available' => 'Available', 'on_leave' => 'On leave'])
                    ->default('available')
                    ->required(),
                Select::make('current_status')
                    ->options(['no_task' => 'No task', 'assigned' => 'Assigned', 'en_route' => 'En route'])
                    ->default('no_task')
                    ->required(),
            ]);
    }
}
