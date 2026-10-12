<?php

namespace App\Filament\Resources\Species\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SpeciesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('enterprise_type_id')
                    ->relationship('enterpriseType', 'name'),
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('kingdom')
                    ->required()
                    ->default('animal'),
                TextInput::make('category'),
                TextInput::make('scientific_name'),
                Textarea::make('description')
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->image(),
                TextInput::make('gestation_days')
                    ->numeric(),
                TextInput::make('incubation_days')
                    ->numeric(),
                TextInput::make('maturity_weeks')
                    ->numeric(),
                Toggle::make('is_active')
                    ->required(),
                TextInput::make('sort')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
