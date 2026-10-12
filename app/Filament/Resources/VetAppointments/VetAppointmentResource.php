<?php

namespace App\Filament\Resources\VetAppointments;

use App\Filament\Resources\VetAppointments\Pages\CreateVetAppointment;
use App\Filament\Resources\VetAppointments\Pages\EditVetAppointment;
use App\Filament\Resources\VetAppointments\Pages\ListVetAppointments;
use App\Filament\Resources\VetAppointments\Schemas\VetAppointmentForm;
use App\Filament\Resources\VetAppointments\Tables\VetAppointmentsTable;
use App\Models\VetAppointment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class VetAppointmentResource extends Resource
{
    protected static ?string $model = VetAppointment::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';

    protected static string|UnitEnum|null $navigationGroup = 'Health & Veterinary';

    protected static ?string $navigationLabel = 'Vet Appointments';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return VetAppointmentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VetAppointmentsTable::configure($table);
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
            'index' => ListVetAppointments::route('/'),
            'create' => CreateVetAppointment::route('/create'),
            'edit' => EditVetAppointment::route('/{record}/edit'),
        ];
    }
}
