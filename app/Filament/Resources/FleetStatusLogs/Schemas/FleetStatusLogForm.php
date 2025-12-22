<?php

namespace App\Filament\Resources\FleetStatusLogs\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class FleetStatusLogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('fleet_id')
                    ->required()
                    ->numeric(),
                TextInput::make('task_id')
                    ->numeric()
                    ->default(null),
                Select::make('status')
                    ->options([
            'unassigned' => 'Unassigned',
            'assigned' => 'Assigned',
            'en_route' => 'En route',
            'completed' => 'Completed',
        ])
                    ->required(),
                TextInput::make('recipient')
                    ->default(null),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                FileUpload::make('report_image')
                    ->image(),
                TextInput::make('uploaded_by')
                    ->required()
                    ->numeric(),
            ]);
    }
}
