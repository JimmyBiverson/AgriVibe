<?php

namespace App\Filament\Resources\FarmTasks;

use App\Filament\Resources\FarmTasks\Pages\CreateFarmTask;
use App\Filament\Resources\FarmTasks\Pages\EditFarmTask;
use App\Filament\Resources\FarmTasks\Pages\ListFarmTasks;
use App\Filament\Resources\FarmTasks\Schemas\FarmTaskForm;
use App\Filament\Resources\FarmTasks\Tables\FarmTasksTable;
use App\Models\FarmTask;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class FarmTaskResource extends Resource
{
    protected static ?string $model = FarmTask::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static string|UnitEnum|null $navigationGroup = 'Farm Operations';

    protected static ?string $navigationLabel = 'Tasks & Reminders';

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return FarmTaskForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FarmTasksTable::configure($table);
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
            'index' => ListFarmTasks::route('/'),
            'create' => CreateFarmTask::route('/create'),
            'edit' => EditFarmTask::route('/{record}/edit'),
        ];
    }
}
