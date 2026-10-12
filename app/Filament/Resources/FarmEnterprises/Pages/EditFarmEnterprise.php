<?php

namespace App\Filament\Resources\FarmEnterprises\Pages;

use App\Filament\Resources\FarmEnterprises\FarmEnterpriseResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditFarmEnterprise extends EditRecord
{
    protected static string $resource = FarmEnterpriseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
