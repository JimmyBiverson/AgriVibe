<?php

namespace App\Filament\Resources\Animals\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AnimalForm
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
                TextInput::make('tag_number')
                    ->required(),
                TextInput::make('rfid_code'),
                TextInput::make('name'),
                TextInput::make('gender')
                    ->required()
                    ->default('female'),
                DatePicker::make('date_of_birth'),
                TextInput::make('weight_kg')
                    ->numeric(),
                TextInput::make('health_status')
                    ->required()
                    ->default('healthy'),
                TextInput::make('reproductive_status')
                    ->required()
                    ->default('open'),
                TextInput::make('housing_location'),
                TextInput::make('estimated_value')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
