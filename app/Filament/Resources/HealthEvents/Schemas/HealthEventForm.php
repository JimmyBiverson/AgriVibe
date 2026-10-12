<?php

namespace App\Filament\Resources\HealthEvents\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class HealthEventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('farm_id')
                    ->relationship('farm', 'name')
                    ->required(),
                Select::make('animal_id')
                    ->relationship('animal', 'name'),
                TextInput::make('animal_batch_id')
                    ->numeric(),
                Select::make('vet_id')
                    ->relationship('vet', 'name'),
                TextInput::make('event_type')
                    ->required(),
                TextInput::make('title')
                    ->required(),
                TextInput::make('medicine_name'),
                TextInput::make('dosage'),
                DatePicker::make('administered_date')
                    ->required(),
                TextInput::make('withdrawal_period_days')
                    ->required()
                    ->numeric()
                    ->default(0),
                DatePicker::make('safe_consumption_date'),
                TextInput::make('status')
                    ->required()
                    ->default('completed'),
                Textarea::make('clinical_notes')
                    ->columnSpanFull(),
            ]);
    }
}
