<?php

namespace App\Livewire\Concerns;

use App\Models\Farm;
use Illuminate\Database\Eloquent\Collection;

trait InteractsWithFarm
{
    public ?int $farmId = null;

    public function initializeFarm(?int $farmId = null): void
    {
        $this->farmId = $farmId ?: $this->availableFarms()->first()?->id;
    }

    /**
     * @return Collection<int, Farm>
     */
    protected function availableFarms(): Collection
    {
        $user = auth()->user();

        return $user->ownedFarms()->get()
            ->merge($user->farms()->get())
            ->unique('id')
            ->values();
    }

    protected function farm(): Farm
    {
        $farms = $this->availableFarms();

        $farm = $this->farmId
            ? $farms->firstWhere('id', $this->farmId)
            : null;

        $farm ??= $farms->first();

        abort_if(! $farm, 403, 'No farm available for this account.');

        return $farm;
    }

    public function updatedFarmId(): void
    {
        $this->dispatch('$refresh');
    }
}
