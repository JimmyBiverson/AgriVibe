@php($farm = current_farm($farmId))
<x-layouts.farm title="Animal Health" :farm="$farm" :farms="available_farms()">
    @if ($farm)
        <livewire:farm.health-manager :farm-id="$farm->id" />
    @else
        <x-farm.empty-state />
    @endif
</x-layouts.farm>
