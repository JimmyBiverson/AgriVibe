@php($farm = current_farm($farmId))
<x-layouts.farm title="Batches & Flocks" :farm="$farm" :farms="available_farms()">
    @if ($farm)
        <livewire:farm.batch-manager :farm-id="$farm->id" />
    @else
        <x-farm.empty-state />
    @endif
</x-layouts.farm>
