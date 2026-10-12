<?php

namespace App\Filament\Resources\VaccinationSchedules;

use App\Filament\Resources\VaccinationSchedules\Pages\CreateVaccinationSchedule;
use App\Filament\Resources\VaccinationSchedules\Pages\EditVaccinationSchedule;
use App\Filament\Resources\VaccinationSchedules\Pages\ListVaccinationSchedules;
use App\Filament\Resources\VaccinationSchedules\Schemas\VaccinationScheduleForm;
use App\Filament\Resources\VaccinationSchedules\Tables\VaccinationSchedulesTable;
use App\Models\VaccinationSchedule;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class VaccinationScheduleResource extends Resource
{
    protected static ?string $model = VaccinationSchedule::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-shield-check';

    protected static string|UnitEnum|null $navigationGroup = 'Health & Veterinary';

    protected static ?string $navigationLabel = 'Vaccination Schedules';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return VaccinationScheduleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VaccinationSchedulesTable::configure($table);
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
            'index' => ListVaccinationSchedules::route('/'),
            'create' => CreateVaccinationSchedule::route('/create'),
            'edit' => EditVaccinationSchedule::route('/{record}/edit'),
        ];
    }
}
