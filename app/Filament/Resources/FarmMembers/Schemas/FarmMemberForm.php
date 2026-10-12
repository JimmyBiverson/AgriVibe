<?php

namespace App\Filament\Resources\FarmMembers\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FarmMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('farm_id')
                    ->relationship('farm', 'name')
                    ->required(),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('role')
                    ->required()
                    ->default('viewer'),
                TextInput::make('permissions'),
                TextInput::make('status')
                    ->required()
                    ->default('active'),
                TextInput::make('invited_by')
                    ->numeric(),
                DateTimePicker::make('invited_at'),
                DateTimePicker::make('joined_at'),
            ]);
    }
}
