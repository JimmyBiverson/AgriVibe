@php($farm = current_farm($farmId))
<x-layouts.farm title="Livestock" :farm="$farm" :farms="available_farms()">
    @if ($farm)
        <livewire:farm.animal-manager :farm-id="$farm->id" />
    @else
        <x-farm.empty-state />
    @endif
</x-layouts.farm>
