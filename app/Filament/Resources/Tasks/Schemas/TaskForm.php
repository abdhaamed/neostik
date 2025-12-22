<?php

namespace App\Filament\Resources\Tasks\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('task_number')
                    ->required(),
                TextInput::make('driver_id')
                    ->required()
                    ->numeric(),
                TextInput::make('fleet_id')
                    ->required()
                    ->numeric(),
                DatePicker::make('delivery_date')
                    ->required(),
                TextInput::make('origin')
                    ->required(),
                TextInput::make('destination')
                    ->required(),
                TextInput::make('goods_type')
                    ->required(),
                Select::make('status')
                    ->options([
            'pending' => 'Pending',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'completed' => 'Completed',
        ])
                    ->default('pending')
                    ->required(),
                TextInput::make('created_by')
                    ->required()
                    ->numeric(),
            ]);
    }
}
