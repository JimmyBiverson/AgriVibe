@php
    $nav = [
        ['route' => 'dashboard', 'label' => 'Overview', 'icon' => 'home'],
        ['route' => 'marketplace.shop', 'label' => 'Shop', 'icon' => 'bag'],
        ['route' => 'marketplace.orders', 'label' => 'My Orders', 'icon' => 'list'],
        ['route' => 'marketplace.sales', 'label' => 'Sales', 'icon' => 'cash'],
        ['route' => 'section.marketplace', 'label' => 'Public Listings', 'icon' => 'briefcase'],
        ['route' => 'knowledge.index', 'label' => 'Academy', 'icon' => 'academy'],
    ];
@endphp
<x-layouts.farm title="Marketplace" description="Buy farm produce, inputs and services." :nav="$nav">
    <livewire:marketplace.listing-browser />
</x-layouts.farm>
