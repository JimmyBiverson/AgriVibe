@props([
    'title' => '',
    'value' => '',
    'description' => null,
    'icon' => 'sparkles',
    'trend' => null,
    'trendValue' => null,
    'color' => 'emerald',
])

@php
    $colorClasses = match($color) {
        'emerald' => 'bg-emerald-100 text-emerald-700 ring-emerald-200',
        'amber' => 'bg-amber-100 text-amber-700 ring-amber-200',
        'cyan' => 'bg-cyan-100 text-cyan-700 ring-cyan-200',
        'red' => 'bg-berry-100 text-berry-700 ring-berry-200',
        'gold' => 'bg-gold-100 text-gold-700 ring-gold-200',
        'slate' => 'bg-slate-100 text-slate-700 ring-slate-200',
        default => 'bg-leaf-100 text-leaf-700 ring-leaf-200',
    };
@endphp

<div {{ $attributes->merge(['class' => 'card-3d rounded-2xl border border-sand-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg hover:shadow-leaf-900/5']) }}>
    <div class="flex items-center justify-between">
        <span class="text-xs font-bold uppercase tracking-wider text-leaf-600">{{ $title }}</span>
        <span class="rounded-lg p-2 text-lg ring-1 {{ $colorClasses }}">
            <x-ui.icon :name="$icon" class="h-5 w-5" />
        </span>
    </div>
    <p class="mt-3 font-display text-2xl font-black text-forest-950">{{ $value }}</p>
    @if ($description)
        <p class="mt-1 flex items-center gap-1.5 text-xs font-medium text-leaf-700">
            @if ($trend === 'up')
                <x-ui.icon name="arrow-trending-up" class="h-3.5 w-3.5 text-emerald-600" />
            @elseif ($trend === 'down')
                <x-ui.icon name="arrow-trending-down" class="h-3.5 w-3.5 text-berry-600" />
            @endif
            <span>{{ $description }}</span>
            @if ($trendValue)
                <span class="font-semibold {{ $trend === 'up' ? 'text-emerald-600' : ($trend === 'down' ? 'text-berry-600' : 'text-leaf-600') }}">{{ $trendValue }}</span>
            @endif
        </p>
    @endif
</div>