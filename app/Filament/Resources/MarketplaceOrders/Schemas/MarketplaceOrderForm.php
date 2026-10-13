<?php

namespace App\Filament\Resources\MarketplaceOrders\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MarketplaceOrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('order_number')
                    ->required(),
                Select::make('buyer_id')
                    ->relationship('buyer', 'name')
                    ->required(),
                Select::make('seller_id')
                    ->relationship('seller', 'name')
                    ->required(),
                TextInput::make('marketplace_item_id')
                    ->numeric(),
                TextInput::make('item_title')
                    ->required(),
                TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->default(1.0),
                TextInput::make('unit'),
                TextInput::make('unit_price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('currency')
                    ->required()
                    ->default('UGX'),
                TextInput::make('total_amount')
                    ->required()
                    ->numeric(),
                TextInput::make('amount_paid')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('payment_status')
                    ->required()
                    ->default('unpaid'),
                TextInput::make('payment_method'),
                TextInput::make('payment_reference'),
                TextInput::make('status')
                    ->required()
                    ->default('pending'),
                TextInput::make('delivery_method'),
                TextInput::make('delivery_address'),
                Textarea::make('notes')
                    ->columnSpanFull(),
                DateTimePicker::make('dispatched_at'),
                DateTimePicker::make('delivered_at'),
            ]);
    }
}
