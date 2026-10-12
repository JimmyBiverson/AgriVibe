<?php

namespace App\Filament\Resources\EnterpriseTypes\Pages;

use App\Filament\Resources\EnterpriseTypes\EnterpriseTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEnterpriseType extends EditRecord
{
    protected static string $resource = EnterpriseTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
