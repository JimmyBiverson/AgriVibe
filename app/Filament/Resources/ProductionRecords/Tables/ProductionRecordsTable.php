<?php

namespace App\Filament\Resources\ProductionRecords\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductionRecordsTable
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
                TextColumn::make('product_type')
                    ->searchable(),
                TextColumn::make('record_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('unit')
                    ->searchable(),
                TextColumn::make('cracked_damaged_qty')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('retained_home_use')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('sold_quantity')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('unit_selling_price')
                    ->money()
                    ->sortable(),
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
