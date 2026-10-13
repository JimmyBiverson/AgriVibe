@php($farm = current_farm($farmId))
<x-layouts.farm title="Production" :farm="$farm" :farms="available_farms()">
    @if ($farm)
        <livewire:farm.production-manager :farm-id="$farm->id" />
    @else
        <x-farm.empty-state />
    @endif
</x-layouts.farm>
