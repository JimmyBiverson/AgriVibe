@php($farm = current_farm($farmId))
<x-layouts.farm title="Farm Finance" :farm="$farm" :farms="available_farms()">
    @if ($farm)
        <livewire:farm.finance-manager :farm-id="$farm->id" />
    @else
        <x-farm.empty-state />
    @endif
</x-layouts.farm>
