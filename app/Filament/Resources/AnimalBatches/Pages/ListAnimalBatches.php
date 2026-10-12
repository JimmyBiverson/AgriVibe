<?php

namespace App\Filament\Resources\AnimalBatches\Pages;

use App\Filament\Resources\AnimalBatches\AnimalBatchResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAnimalBatches extends ListRecords
{
    protected static string $resource = AnimalBatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
