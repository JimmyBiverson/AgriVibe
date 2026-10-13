@php($farm = current_farm($farmId))
<x-layouts.farm title="Vet Requests" :farm="$farm" :farms="available_farms()">
    @if ($farm)
        <livewire:farm.vet-request-manager :farm-id="$farm->id" />
    @else
        <x-farm.empty-state />
    @endif
</x-layouts.farm>
