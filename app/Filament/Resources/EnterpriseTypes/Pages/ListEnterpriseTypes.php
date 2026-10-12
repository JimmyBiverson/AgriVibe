<?php

namespace App\Filament\Resources\EnterpriseTypes\Pages;

use App\Filament\Resources\EnterpriseTypes\EnterpriseTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEnterpriseTypes extends ListRecords
{
    protected static string $resource = EnterpriseTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
