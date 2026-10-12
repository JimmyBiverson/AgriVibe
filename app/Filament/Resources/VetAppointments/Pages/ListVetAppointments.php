<?php

namespace App\Filament\Resources\VetAppointments\Pages;

use App\Filament\Resources\VetAppointments\VetAppointmentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVetAppointments extends ListRecords
{
    protected static string $resource = VetAppointmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
