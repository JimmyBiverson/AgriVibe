<?php

namespace App\Filament\Resources\HealthEvents\Pages;

use App\Filament\Resources\HealthEvents\HealthEventResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHealthEvent extends EditRecord
{
    protected static string $resource = HealthEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
