<?php

namespace App\Filament\Resources\FarmMembers\Pages;

use App\Filament\Resources\FarmMembers\FarmMemberResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFarmMembers extends ListRecords
{
    protected static string $resource = FarmMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
