<?php

namespace App\Filament\Resources\FarmFinances\Pages;

use App\Filament\Resources\FarmFinances\FarmFinanceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFarmFinances extends ListRecords
{
    protected static string $resource = FarmFinanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
