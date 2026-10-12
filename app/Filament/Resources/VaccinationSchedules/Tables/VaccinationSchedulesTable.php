<?php

namespace App\Filament\Resources\VaccinationSchedules\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VaccinationSchedulesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('species.name')
                    ->searchable(),
                TextColumn::make('vaccine.name')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('age_days_from')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('age_days_to')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('age_label')
                    ->searchable(),
                TextColumn::make('route')
                    ->searchable(),
                TextColumn::make('dose')
                    ->searchable(),
                TextColumn::make('frequency')
                    ->searchable(),
                TextColumn::make('production_system')
                    ->searchable(),
                IconColumn::make('is_expert_verified')
                    ->boolean(),
                TextColumn::make('source')
                    ->searchable(),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
