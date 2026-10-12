<?php

namespace App\Filament\Resources\ProductionRecords\Pages;

use App\Filament\Resources\ProductionRecords\ProductionRecordResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProductionRecords extends ListRecords
{
    protected static string $resource = ProductionRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
