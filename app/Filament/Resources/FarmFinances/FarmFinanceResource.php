<?php

namespace App\Filament\Resources\FarmFinances;

use App\Filament\Resources\FarmFinances\Pages\CreateFarmFinance;
use App\Filament\Resources\FarmFinances\Pages\EditFarmFinance;
use App\Filament\Resources\FarmFinances\Pages\ListFarmFinances;
use App\Filament\Resources\FarmFinances\Schemas\FarmFinanceForm;
use App\Filament\Resources\FarmFinances\Tables\FarmFinancesTable;
use App\Models\FarmFinance;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class FarmFinanceResource extends Resource
{
    protected static ?string $model = FarmFinance::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';

    protected static string|UnitEnum|null $navigationGroup = 'Finance & Inventory';

    protected static ?string $navigationLabel = 'Farm Finances';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return FarmFinanceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FarmFinancesTable::configure($table);
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
            'index' => ListFarmFinances::route('/'),
            'create' => CreateFarmFinance::route('/create'),
            'edit' => EditFarmFinance::route('/{record}/edit'),
        ];
    }
}
