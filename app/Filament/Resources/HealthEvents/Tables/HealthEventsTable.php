<?php

namespace App\Filament\Resources\HealthEvents\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HealthEventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('farm.name')
                    ->searchable(),
                TextColumn::make('animal.name')
                    ->searchable(),
                TextColumn::make('animal_batch_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('vet.name')
                    ->searchable(),
                TextColumn::make('event_type')
                    ->searchable(),
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('medicine_name')
                    ->searchable(),
                TextColumn::make('dosage')
                    ->searchable(),
                TextColumn::make('administered_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('withdrawal_period_days')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('safe_consumption_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('status')
                    ->searchable(),
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
