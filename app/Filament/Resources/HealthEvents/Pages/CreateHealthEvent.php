<?php

namespace App\Filament\Resources\HealthEvents\Pages;

use App\Filament\Resources\HealthEvents\HealthEventResource;
use Filament\Resources\Pages\CreateRecord;

class CreateHealthEvent extends CreateRecord
{
    protected static string $resource = HealthEventResource::class;
}
