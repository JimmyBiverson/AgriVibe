<?php

namespace App\Filament\Resources\MarketplaceOrders\Pages;

use App\Filament\Resources\MarketplaceOrders\MarketplaceOrderResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMarketplaceOrder extends EditRecord
{
    protected static string $resource = MarketplaceOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
