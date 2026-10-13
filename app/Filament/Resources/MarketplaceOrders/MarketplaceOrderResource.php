<?php

namespace App\Filament\Resources\MarketplaceOrders;

use App\Filament\Resources\MarketplaceOrders\Pages\CreateMarketplaceOrder;
use App\Filament\Resources\MarketplaceOrders\Pages\EditMarketplaceOrder;
use App\Filament\Resources\MarketplaceOrders\Pages\ListMarketplaceOrders;
use App\Filament\Resources\MarketplaceOrders\Schemas\MarketplaceOrderForm;
use App\Filament\Resources\MarketplaceOrders\Tables\MarketplaceOrdersTable;
use App\Models\MarketplaceOrder;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class MarketplaceOrderResource extends Resource
{
    protected static ?string $model = MarketplaceOrder::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-shopping-cart';

    protected static string|UnitEnum|null $navigationGroup = 'Marketplace';

    protected static ?string $navigationLabel = 'Orders';

    protected static ?string $modelLabel = 'Order';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return MarketplaceOrderForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MarketplaceOrdersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMarketplaceOrders::route('/'),
            'create' => CreateMarketplaceOrder::route('/create'),
            'edit' => EditMarketplaceOrder::route('/{record}/edit'),
        ];
    }
}
