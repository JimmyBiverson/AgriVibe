<?php

namespace App\Filament\Resources\VetAppointments\Pages;

use App\Filament\Resources\VetAppointments\VetAppointmentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVetAppointment extends EditRecord
{
    protected static string $resource = VetAppointmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
