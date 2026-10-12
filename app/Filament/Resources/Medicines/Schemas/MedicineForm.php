<?php

namespace App\Filament\Resources\Medicines\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MedicineForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('category'),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('dosage'),
                TextInput::make('route'),
                TextInput::make('withdrawal_days_meat')
                    ->numeric(),
                TextInput::make('withdrawal_days_milk')
                    ->numeric(),
                TextInput::make('withdrawal_days_eggs')
                    ->numeric(),
                Textarea::make('notes')
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
