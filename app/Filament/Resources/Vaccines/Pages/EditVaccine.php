<?php

namespace App\Filament\Resources\Vaccines\Pages;

use App\Filament\Resources\Vaccines\VaccineResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVaccine extends EditRecord
{
    protected static string $resource = VaccineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
