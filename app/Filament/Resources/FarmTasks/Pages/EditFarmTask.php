<?php

namespace App\Filament\Resources\FarmTasks\Pages;

use App\Filament\Resources\FarmTasks\FarmTaskResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFarmTask extends EditRecord
{
    protected static string $resource = FarmTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
