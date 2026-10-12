<?php

namespace App\Filament\Resources\SmsLogs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SmsLogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name'),
                TextInput::make('recipient_phone')
                    ->tel()
                    ->required(),
                TextInput::make('direction')
                    ->required()
                    ->default('outgoing'),
                Textarea::make('message')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('channel')
                    ->required()
                    ->default('sms'),
                TextInput::make('status')
                    ->required()
                    ->default('delivered'),
                TextInput::make('cost_ugx')
                    ->required()
                    ->numeric()
                    ->default(35.0),
            ]);
    }
}
