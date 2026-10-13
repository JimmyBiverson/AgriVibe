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
<x-layouts.farm title="Sales & Orders" description="Fulfil orders and track payments." :nav="$nav">
    <livewire:marketplace.seller-orders />
</x-layouts.farm>
