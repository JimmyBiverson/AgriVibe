<?php

namespace App\Filament\Resources\FarmEnterprises\Pages;

use App\Filament\Resources\FarmEnterprises\FarmEnterpriseResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFarmEnterprises extends ListRecords
{
    protected static string $resource = FarmEnterpriseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
