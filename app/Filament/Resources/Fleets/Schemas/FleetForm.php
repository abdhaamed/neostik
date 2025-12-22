<?php

namespace App\Filament\Resources\Fleets\Schemas;

use App\Models\FleetCategory;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FleetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2) // opsional: tata layout jadi 2 kolom
            ->components([
                // Serial Number
                TextInput::make('serial_number')
                    ->label('Serial Number')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                // License Plate
                TextInput::make('license_plate')
                    ->label('License Plate')
                    ->required()
                    ->maxLength(20)
                    ->unique(ignoreRecord: true),

                // Category (diperbaiki dari TextInput jadi Select)
                Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->label('Category Name')
                            ->required()
                            ->maxLength(255)
                            ->unique(),
                    ])
                    ->required(),

                // Capacity
                TextInput::make('capacity')
                    ->label('Capacity (tons)')
                    ->required()
                    ->numeric()
                    ->minValue(0),

                // Image Upload (diperbaiki)
                FileUpload::make('image')
                    ->label('Fleet Photo')
                    ->disk('public')
                    ->directory('fleets')
                    ->image()
                    ->imageEditor()
                    ->maxSize(2048) // 2MB
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                    ->helperText('Max 2MB. Recommended: square photo.'),

                // Status
                Select::make('current_status')
                    ->label('Current Status')
                    ->options([
                        'unassigned' => 'Unassigned',
                        'assigned' => 'Assigned',
                        'en_route' => 'En Route',
                        'completed' => 'Completed',
                    ])
                    ->default('unassigned')
                    ->required()
                    ->selectablePlaceholder(false),
            ]);
    }
}