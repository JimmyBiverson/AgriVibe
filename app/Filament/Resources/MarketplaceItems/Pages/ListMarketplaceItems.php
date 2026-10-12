<?php

namespace App\Filament\Resources\MarketplaceItems\Pages;

use App\Filament\Resources\MarketplaceItems\MarketplaceItemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMarketplaceItems extends ListRecords
{
    protected static string $resource = MarketplaceItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
