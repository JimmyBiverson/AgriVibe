<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Users')
                ->icon('heroicon-o-users')
                ->badge(fn () => $this->getResource()::getModel()::count()),

            'farmers' => Tab::make('Farmers')
                ->icon('heroicon-o-globe-alt')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('account_type', 'farmer'))
                ->badge(fn () => $this->getResource()::getModel()::where('account_type', 'farmer')->count()),

            'veterinarians' => Tab::make('Veterinarians')
                ->icon('heroicon-o-heart')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('account_type', 'veterinarian'))
                ->badge(fn () => $this->getResource()::getModel()::where('account_type', 'veterinarian')->count()),

            'buyers' => Tab::make('Buyers')
                ->icon('heroicon-o-shopping-cart')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('account_type', 'buyer'))
                ->badge(fn () => $this->getResource()::getModel()::where('account_type', 'buyer')->count()),

            'suppliers' => Tab::make('Suppliers')
                ->icon('heroicon-o-truck')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('account_type', 'supplier'))
                ->badge(fn () => $this->getResource()::getModel()::where('account_type', 'supplier')->count()),

            'trainers' => Tab::make('Trainers')
                ->icon('heroicon-o-academic-cap')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('account_type', 'trainer'))
                ->badge(fn () => $this->getResource()::getModel()::where('account_type', 'trainer')->count()),

            'admins' => Tab::make('Administrators')
                ->icon('heroicon-o-shield-check')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('account_type', 'admin'))
                ->badge(fn () => $this->getResource()::getModel()::where('account_type', 'admin')->count()),
        ];
    }
}
