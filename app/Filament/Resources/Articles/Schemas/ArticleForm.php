<?php

namespace App\Filament\Resources\Articles\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('uuid')
                    ->label('UUID')
                    ->required(),
                Select::make('category_id')
                    ->relationship('category', 'name'),
                Select::make('author_id')
                    ->relationship('author', 'name'),
                Select::make('species_id')
                    ->relationship('species', 'name'),
                TextInput::make('disease_id')
                    ->numeric(),
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug')
                    ->required(),
                Textarea::make('excerpt')
                    ->columnSpanFull(),
                Textarea::make('body')
                    ->columnSpanFull(),
                FileUpload::make('cover_image')
                    ->image(),
                TextInput::make('audience')
                    ->required()
                    ->default('all'),
                TextInput::make('content_type')
                    ->required()
                    ->default('knowledge'),
                TextInput::make('status')
                    ->required()
                    ->default('draft'),
                Toggle::make('is_featured')
                    ->required(),
                Toggle::make('is_expert_verified')
                    ->required(),
                Toggle::make('requires_vet_validation')
                    ->required(),
                Textarea::make('disclaimer')
                    ->columnSpanFull(),
                TextInput::make('meta_title'),
                Textarea::make('meta_description')
                    ->columnSpanFull(),
                FileUpload::make('meta_image')
                    ->image(),
                TextInput::make('views')
                    ->required()
                    ->numeric()
                    ->default(0),
                DateTimePicker::make('published_at'),
            ]);
    }
}
