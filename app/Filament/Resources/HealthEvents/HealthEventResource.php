<?php

namespace App\Filament\Resources\HealthEvents;

use App\Filament\Resources\HealthEvents\Pages\CreateHealthEvent;
use App\Filament\Resources\HealthEvents\Pages\EditHealthEvent;
use App\Filament\Resources\HealthEvents\Pages\ListHealthEvents;
use App\Filament\Resources\HealthEvents\Schemas\HealthEventForm;
use App\Filament\Resources\HealthEvents\Tables\HealthEventsTable;
use App\Models\HealthEvent;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class HealthEventResource extends Resource
{
    protected static ?string $model = HealthEvent::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-heart';

    protected static string|UnitEnum|null $navigationGroup = 'Health & Veterinary';

    protected static ?string $navigationLabel = 'Health Events';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return HealthEventForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HealthEventsTable::configure($table);
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
            'index' => ListHealthEvents::route('/'),
            'create' => CreateHealthEvent::route('/create'),
            'edit' => EditHealthEvent::route('/{record}/edit'),
        ];
    }
}
