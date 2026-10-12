<?php

namespace App\Filament\Resources\Farms\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FarmForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('uuid')
                    ->label('UUID')
                    ->required(),
                Select::make('owner_id')
                    ->relationship('owner', 'name')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('type')
                    ->required()
                    ->default('individual'),
                TextInput::make('country_code')
                    ->required()
                    ->default('UG'),
                Select::make('location_id')
                    ->relationship('location', 'name'),
                TextInput::make('district'),
                TextInput::make('sub_county'),
                TextInput::make('parish'),
                TextInput::make('village'),
                TextInput::make('address'),
                TextInput::make('latitude')
                    ->numeric(),
                TextInput::make('longitude')
                    ->numeric(),
                TextInput::make('acreage')
                    ->numeric(),
                TextInput::make('land_tenure'),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('logo'),
                FileUpload::make('cover_image')
                    ->image(),
                TextInput::make('water_sources'),
                Toggle::make('has_electricity')
                    ->required(),
                Textarea::make('infrastructure')
                    ->columnSpanFull(),
                TextInput::make('workers_count')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('emergency_contacts'),
                Select::make('assigned_vet_id')
                    ->relationship('assignedVet', 'name'),
                TextInput::make('preferred_language')
                    ->required()
                    ->default('en'),
                TextInput::make('preferred_contact')
                    ->required()
                    ->default('sms'),
                TextInput::make('visibility')
                    ->required()
                    ->default('private'),
                TextInput::make('status')
                    ->required()
                    ->default('active'),
                DateTimePicker::make('verified_at'),
            ]);
    }
}
