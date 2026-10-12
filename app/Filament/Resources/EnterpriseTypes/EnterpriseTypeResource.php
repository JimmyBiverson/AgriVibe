<?php

namespace App\Filament\Resources\EnterpriseTypes;

use App\Filament\Resources\EnterpriseTypes\Pages\CreateEnterpriseType;
use App\Filament\Resources\EnterpriseTypes\Pages\EditEnterpriseType;
use App\Filament\Resources\EnterpriseTypes\Pages\ListEnterpriseTypes;
use App\Filament\Resources\EnterpriseTypes\Schemas\EnterpriseTypeForm;
use App\Filament\Resources\EnterpriseTypes\Tables\EnterpriseTypesTable;
use App\Models\EnterpriseType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class EnterpriseTypeResource extends Resource
{
    protected static ?string $model = EnterpriseType::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-squares-2x2';

    protected static string|UnitEnum|null $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'Enterprise Types';

    protected static ?int $navigationSort = 7;

    public static function form(Schema $schema): Schema
    {
        return EnterpriseTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EnterpriseTypesTable::configure($table);
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
            'index' => ListEnterpriseTypes::route('/'),
            'create' => CreateEnterpriseType::route('/create'),
            'edit' => EditEnterpriseType::route('/{record}/edit'),
        ];
    }
}
