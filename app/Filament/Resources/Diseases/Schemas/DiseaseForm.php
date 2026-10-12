<?php

namespace App\Filament\Resources\Diseases\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class DiseaseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('species_id')
                    ->relationship('species', 'name'),
                TextInput::make('name')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                TextInput::make('category'),
                Textarea::make('cause')
                    ->columnSpanFull(),
                Textarea::make('symptoms')
                    ->columnSpanFull(),
                Textarea::make('prevention')
                    ->columnSpanFull(),
                Textarea::make('treatment')
                    ->columnSpanFull(),
                TextInput::make('severity'),
                Toggle::make('is_notifiable')
                    ->required(),
                Toggle::make('is_contagious')
                    ->required(),
                FileUpload::make('image')
                    ->image(),
                Toggle::make('is_expert_verified')
                    ->required(),
                Textarea::make('disclaimer')
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
