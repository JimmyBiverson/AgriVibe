<?php

namespace App\Filament\Resources\Farms\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class FarmsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('uuid')
                    ->label('UUID')
                    ->searchable(),
                TextColumn::make('owner.name')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('slug')
                    ->searchable(),
                TextColumn::make('type')
                    ->searchable(),
                TextColumn::make('country_code')
                    ->searchable(),
                TextColumn::make('location.name')
                    ->searchable(),
                TextColumn::make('district')
                    ->searchable(),
                TextColumn::make('sub_county')
                    ->searchable(),
                TextColumn::make('parish')
                    ->searchable(),
                TextColumn::make('village')
                    ->searchable(),
                TextColumn::make('address')
                    ->searchable(),
                TextColumn::make('latitude')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('longitude')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('acreage')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('land_tenure')
                    ->searchable(),
                TextColumn::make('logo')
                    ->searchable(),
                ImageColumn::make('cover_image'),
                IconColumn::make('has_electricity')
                    ->boolean(),
                TextColumn::make('workers_count')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('assignedVet.name')
                    ->searchable(),
                TextColumn::make('preferred_language')
                    ->searchable(),
                TextColumn::make('preferred_contact')
                    ->searchable(),
                TextColumn::make('visibility')
                    ->searchable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('verified_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
