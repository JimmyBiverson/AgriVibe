<?php

namespace App\Filament\Resources\FarmMembers;

use App\Filament\Resources\FarmMembers\Pages\CreateFarmMember;
use App\Filament\Resources\FarmMembers\Pages\EditFarmMember;
use App\Filament\Resources\FarmMembers\Pages\ListFarmMembers;
use App\Filament\Resources\FarmMembers\Schemas\FarmMemberForm;
use App\Filament\Resources\FarmMembers\Tables\FarmMembersTable;
use App\Models\FarmMember;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class FarmMemberResource extends Resource
{
    protected static ?string $model = FarmMember::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user-group';

    protected static string|UnitEnum|null $navigationGroup = 'Farm Operations';

    protected static ?string $navigationLabel = 'Farm Members';

    protected static ?int $navigationSort = 7;

    public static function form(Schema $schema): Schema
    {
        return FarmMemberForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FarmMembersTable::configure($table);
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
            'index' => ListFarmMembers::route('/'),
            'create' => CreateFarmMember::route('/create'),
            'edit' => EditFarmMember::route('/{record}/edit'),
        ];
    }
}
