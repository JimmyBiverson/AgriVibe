@php($farm = current_farm($farmId))
<x-layouts.farm title="Tasks & Reminders" :farm="$farm" :farms="available_farms()">
    @if ($farm)
        <livewire:farm.task-manager :farm-id="$farm->id" />
    @else
        <x-farm.empty-state />
    @endif
</x-layouts.farm>
