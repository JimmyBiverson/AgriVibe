<?php

namespace App\Filament\Resources\FarmEnterprises;

use App\Filament\Resources\FarmEnterprises\Pages\CreateFarmEnterprise;
use App\Filament\Resources\FarmEnterprises\Pages\EditFarmEnterprise;
use App\Filament\Resources\FarmEnterprises\Pages\ListFarmEnterprises;
use App\Filament\Resources\FarmEnterprises\Schemas\FarmEnterpriseForm;
use App\Filament\Resources\FarmEnterprises\Tables\FarmEnterprisesTable;
use App\Models\FarmEnterprise;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class FarmEnterpriseResource extends Resource
{
    protected static ?string $model = FarmEnterprise::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-building-office-2';

    protected static string|UnitEnum|null $navigationGroup = 'Farm Operations';

    protected static ?string $navigationLabel = 'Farm Enterprises';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return FarmEnterpriseForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FarmEnterprisesTable::configure($table);
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
            'index' => ListFarmEnterprises::route('/'),
            'create' => CreateFarmEnterprise::route('/create'),
            'edit' => EditFarmEnterprise::route('/{record}/edit'),
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
