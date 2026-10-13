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
<x-layouts.farm title="My Orders" description="Track your marketplace purchases." :nav="$nav">
    <livewire:marketplace.my-orders />
</x-layouts.farm>
