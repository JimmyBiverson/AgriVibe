<?php

namespace App\Filament\Resources\ProductionRecords\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProductionRecordForm
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
                TextInput::make('product_type')
                    ->required(),
                DatePicker::make('record_date')
                    ->required(),
                TextInput::make('quantity')
                    ->required()
                    ->numeric(),
                TextInput::make('unit')
                    ->required()
                    ->default('litres'),
                TextInput::make('cracked_damaged_qty')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('retained_home_use')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('sold_quantity')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('unit_selling_price')
                    ->required()
                    ->numeric()
                    ->default(0.0)
                    ->prefix('$'),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
