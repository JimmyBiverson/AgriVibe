<?php

namespace App\Filament\Resources\MarketplaceOrders\Pages;

use App\Filament\Resources\MarketplaceOrders\MarketplaceOrderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMarketplaceOrders extends ListRecords
{
    protected static string $resource = MarketplaceOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
