<?php

namespace App\Filament\Resources\ProductionRecords;

use App\Filament\Resources\ProductionRecords\Pages\CreateProductionRecord;
use App\Filament\Resources\ProductionRecords\Pages\EditProductionRecord;
use App\Filament\Resources\ProductionRecords\Pages\ListProductionRecords;
use App\Filament\Resources\ProductionRecords\Schemas\ProductionRecordForm;
use App\Filament\Resources\ProductionRecords\Tables\ProductionRecordsTable;
use App\Models\ProductionRecord;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class ProductionRecordResource extends Resource
{
    protected static ?string $model = ProductionRecord::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';

    protected static string|UnitEnum|null $navigationGroup = 'Farm Operations';

    protected static ?string $navigationLabel = 'Production Records';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return ProductionRecordForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductionRecordsTable::configure($table);
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
            'index' => ListProductionRecords::route('/'),
            'create' => CreateProductionRecord::route('/create'),
            'edit' => EditProductionRecord::route('/{record}/edit'),
        ];
    }
}
