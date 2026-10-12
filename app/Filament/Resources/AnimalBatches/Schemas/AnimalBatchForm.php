<?php

namespace App\Filament\Resources\AnimalBatches\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AnimalBatchForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('farm_id')
                    ->relationship('farm', 'name')
                    ->required(),
                Select::make('species_id')
                    ->relationship('species', 'name'),
                Select::make('breed_id')
                    ->relationship('breed', 'name'),
                TextInput::make('batch_code')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('type')
                    ->required()
                    ->default('poultry'),
                TextInput::make('initial_quantity')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('current_quantity')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('mortality_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                DatePicker::make('start_date')
                    ->required(),
                DatePicker::make('expected_end_date'),
                TextInput::make('average_weight_kg')
                    ->numeric(),
                TextInput::make('target_fcr')
                    ->required()
                    ->numeric()
                    ->default(1.5),
                TextInput::make('housing_unit'),
                TextInput::make('status')
                    ->required()
                    ->default('active'),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
