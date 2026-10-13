<?php

namespace App\Filament\Resources\MarketplaceOrders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MarketplaceOrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')
                    ->searchable(),
                TextColumn::make('buyer.name')
                    ->searchable(),
                TextColumn::make('seller.name')
                    ->searchable(),
                TextColumn::make('marketplace_item_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('item_title')
                    ->searchable(),
                TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('unit')
                    ->searchable(),
                TextColumn::make('unit_price')
                    ->money()
                    ->sortable(),
                TextColumn::make('currency')
                    ->searchable(),
                TextColumn::make('total_amount')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('amount_paid')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('payment_status')
                    ->searchable(),
                TextColumn::make('payment_method')
                    ->searchable(),
                TextColumn::make('payment_reference')
                    ->searchable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('delivery_method')
                    ->searchable(),
                TextColumn::make('delivery_address')
                    ->searchable(),
                TextColumn::make('dispatched_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('delivered_at')
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
