<?php

namespace App\Filament\Resources\Vaccines;

use App\Filament\Resources\Vaccines\Pages\CreateVaccine;
use App\Filament\Resources\Vaccines\Pages\EditVaccine;
use App\Filament\Resources\Vaccines\Pages\ListVaccines;
use App\Filament\Resources\Vaccines\Schemas\VaccineForm;
use App\Filament\Resources\Vaccines\Tables\VaccinesTable;
use App\Models\Vaccine;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class VaccineResource extends Resource
{
    protected static ?string $model = Vaccine::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-shield-check';

    protected static string|UnitEnum|null $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'Vaccines';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return VaccineForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VaccinesTable::configure($table);
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
            'index' => ListVaccines::route('/'),
            'create' => CreateVaccine::route('/create'),
            'edit' => EditVaccine::route('/{record}/edit'),
        ];
    }
}
