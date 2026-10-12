<?php

namespace App\Filament\Resources\FarmFinances\Pages;

use App\Filament\Resources\FarmFinances\FarmFinanceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFarmFinance extends EditRecord
{
    protected static string $resource = FarmFinanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
