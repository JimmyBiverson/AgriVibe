<?php

namespace App\Filament\Resources\VetAppointments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VetAppointmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('farmer_id')
                    ->relationship('farmer', 'name')
                    ->required(),
                Select::make('vet_id')
                    ->relationship('vet', 'name')
                    ->required(),
                Select::make('farm_id')
                    ->relationship('farm', 'name'),
                Select::make('animal_id')
                    ->relationship('animal', 'name'),
                TextInput::make('service_type')
                    ->required()
                    ->default('telemedicine'),
                DateTimePicker::make('scheduled_at')
                    ->required(),
                TextInput::make('status')
                    ->required()
                    ->default('confirmed'),
                TextInput::make('urgency')
                    ->required()
                    ->default('normal'),
                Textarea::make('symptoms_description')
                    ->columnSpanFull(),
                Textarea::make('diagnosis')
                    ->columnSpanFull(),
                Textarea::make('prescription')
                    ->columnSpanFull(),
                TextInput::make('fee_ugx')
                    ->required()
                    ->numeric()
                    ->default(0.0),
            ]);
    }
}
