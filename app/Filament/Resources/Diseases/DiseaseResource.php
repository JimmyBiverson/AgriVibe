<?php

namespace App\Filament\Resources\Diseases;

use App\Filament\Resources\Diseases\Pages\CreateDisease;
use App\Filament\Resources\Diseases\Pages\EditDisease;
use App\Filament\Resources\Diseases\Pages\ListDiseases;
use App\Filament\Resources\Diseases\Schemas\DiseaseForm;
use App\Filament\Resources\Diseases\Tables\DiseasesTable;
use App\Models\Disease;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class DiseaseResource extends Resource
{
    protected static ?string $model = Disease::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-bug-ant';

    protected static string|UnitEnum|null $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'Diseases';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return DiseaseForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DiseasesTable::configure($table);
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
            'index' => ListDiseases::route('/'),
            'create' => CreateDisease::route('/create'),
            'edit' => EditDisease::route('/{record}/edit'),
        ];
    }
}
