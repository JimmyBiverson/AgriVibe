<?php

namespace App\Filament\Resources\VaccinationSchedules\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class VaccinationScheduleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('species_id')
                    ->relationship('species', 'name'),
                Select::make('vaccine_id')
                    ->relationship('vaccine', 'name'),
                TextInput::make('name')
                    ->required(),
                TextInput::make('age_days_from')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('age_days_to')
                    ->numeric(),
                TextInput::make('age_label'),
                TextInput::make('route'),
                TextInput::make('dose'),
                TextInput::make('frequency'),
                TextInput::make('production_system'),
                Textarea::make('notes')
                    ->columnSpanFull(),
                Toggle::make('is_expert_verified')
                    ->required(),
                Textarea::make('disclaimer')
                    ->columnSpanFull(),
                TextInput::make('source'),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
