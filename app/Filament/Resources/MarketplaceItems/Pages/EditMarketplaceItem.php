<?php

namespace App\Filament\Resources\MarketplaceItems\Pages;

use App\Filament\Resources\MarketplaceItems\MarketplaceItemResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMarketplaceItem extends EditRecord
{
    protected static string $resource = MarketplaceItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
