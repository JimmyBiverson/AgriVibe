@php
    $nav = [
        ['route' => 'dashboard', 'label' => 'Overview', 'icon' => 'home'],
        ['route' => 'vet.console', 'label' => 'Appointments', 'icon' => 'calendar'],
        ['route' => 'section.find-vet', 'label' => 'Vet Directory', 'icon' => 'search'],
        ['route' => 'knowledge.index', 'label' => 'Academy', 'icon' => 'academy'],
        ['route' => 'section.community', 'label' => 'Community', 'icon' => 'community'],
    ];
@endphp
<x-layouts.farm title="Vet Console" description="Manage veterinary consultations and patient records." :nav="$nav">
    <livewire:vet.vet-console />
</x-layouts.farm>
