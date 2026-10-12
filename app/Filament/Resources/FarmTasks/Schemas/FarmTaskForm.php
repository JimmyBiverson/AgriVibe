<?php

namespace App\Filament\Resources\FarmTasks\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FarmTaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('farm_id')
                    ->relationship('farm', 'name')
                    ->required(),
                TextInput::make('assigned_to')
                    ->numeric(),
                TextInput::make('title')
                    ->required(),
                TextInput::make('category')
                    ->required()
                    ->default('general'),
                DatePicker::make('due_date')
                    ->required(),
                TextInput::make('priority')
                    ->required()
                    ->default('normal'),
                TextInput::make('status')
                    ->required()
                    ->default('pending'),
                Textarea::make('description')
                    ->columnSpanFull(),
            ]);
    }
}
