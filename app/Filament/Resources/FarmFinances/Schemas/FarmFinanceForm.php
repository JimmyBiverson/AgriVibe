<?php

namespace App\Filament\Resources\FarmFinances\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FarmFinanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('farm_id')
                    ->relationship('farm', 'name')
                    ->required(),
                TextInput::make('animal_batch_id')
                    ->numeric(),
                TextInput::make('type')
                    ->required(),
                TextInput::make('category')
                    ->required(),
                DatePicker::make('transaction_date')
                    ->required(),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                TextInput::make('currency')
                    ->required()
                    ->default('UGX'),
                TextInput::make('description')
                    ->required(),
                TextInput::make('reference_number'),
            ]);
    }
}
