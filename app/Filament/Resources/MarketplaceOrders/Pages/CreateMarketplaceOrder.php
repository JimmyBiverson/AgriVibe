<?php

namespace App\Filament\Resources\MarketplaceOrders\Pages;

use App\Filament\Resources\MarketplaceOrders\MarketplaceOrderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMarketplaceOrder extends CreateRecord
{
    protected static string $resource = MarketplaceOrderResource::class;
}
