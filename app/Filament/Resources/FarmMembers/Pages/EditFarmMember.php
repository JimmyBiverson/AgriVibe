<?php

namespace App\Filament\Resources\FarmMembers\Pages;

use App\Filament\Resources\FarmMembers\FarmMemberResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFarmMember extends EditRecord
{
    protected static string $resource = FarmMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
