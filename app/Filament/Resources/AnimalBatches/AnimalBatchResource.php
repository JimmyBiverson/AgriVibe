<?php

namespace App\Filament\Resources\AnimalBatches;

use App\Filament\Resources\AnimalBatches\Pages\CreateAnimalBatch;
use App\Filament\Resources\AnimalBatches\Pages\EditAnimalBatch;
use App\Filament\Resources\AnimalBatches\Pages\ListAnimalBatches;
use App\Filament\Resources\AnimalBatches\Schemas\AnimalBatchForm;
use App\Filament\Resources\AnimalBatches\Tables\AnimalBatchesTable;
use App\Models\AnimalBatch;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class AnimalBatchResource extends Resource
{
    protected static ?string $model = AnimalBatch::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static string|UnitEnum|null $navigationGroup = 'Farm Operations';

    protected static ?string $navigationLabel = 'Batches & Flocks';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return AnimalBatchForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AnimalBatchesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListAnimalBatches::route('/'),
            'create' => CreateAnimalBatch::route('/create'),
            'edit' => EditAnimalBatch::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
