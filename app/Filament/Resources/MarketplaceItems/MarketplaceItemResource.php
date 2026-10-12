<?php

namespace App\Filament\Resources\MarketplaceItems;

use App\Filament\Resources\MarketplaceItems\Pages\CreateMarketplaceItem;
use App\Filament\Resources\MarketplaceItems\Pages\EditMarketplaceItem;
use App\Filament\Resources\MarketplaceItems\Pages\ListMarketplaceItems;
use App\Filament\Resources\MarketplaceItems\Schemas\MarketplaceItemForm;
use App\Filament\Resources\MarketplaceItems\Tables\MarketplaceItemsTable;
use App\Models\MarketplaceItem;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class MarketplaceItemResource extends Resource
{
    protected static ?string $model = MarketplaceItem::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-shopping-bag';

    protected static string|UnitEnum|null $navigationGroup = 'Marketplace';

    protected static ?string $navigationLabel = 'Marketplace Listings';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return MarketplaceItemForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MarketplaceItemsTable::configure($table);
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
            'index' => ListMarketplaceItems::route('/'),
            'create' => CreateMarketplaceItem::route('/create'),
            'edit' => EditMarketplaceItem::route('/{record}/edit'),
        ];
    }
}
