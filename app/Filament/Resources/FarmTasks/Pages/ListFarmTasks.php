<?php

namespace App\Filament\Resources\FarmTasks\Pages;

use App\Filament\Resources\FarmTasks\FarmTaskResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFarmTasks extends ListRecords
{
    protected static string $resource = FarmTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
