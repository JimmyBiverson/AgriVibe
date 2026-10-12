<?php

namespace App\Filament\Resources\AnimalBatches\Pages;

use App\Filament\Resources\AnimalBatches\AnimalBatchResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditAnimalBatch extends EditRecord
{
    protected static string $resource = AnimalBatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
