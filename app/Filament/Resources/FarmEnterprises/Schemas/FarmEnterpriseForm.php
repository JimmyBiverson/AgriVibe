<?php

namespace App\Filament\Resources\FarmEnterprises\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FarmEnterpriseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('farm_id')
                    ->relationship('farm', 'name')
                    ->required(),
                Select::make('enterprise_type_id')
                    ->relationship('enterpriseType', 'name')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('quantity')
                    ->numeric(),
                TextInput::make('unit'),
                TextInput::make('size')
                    ->numeric(),
                TextInput::make('status')
                    ->required()
                    ->default('active'),
                DatePicker::make('started_at'),
            ]);
    }
}
