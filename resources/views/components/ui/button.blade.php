@props([
    'href' => null,
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
    'icon' => null,
    'wire:navigate' => false,
])

@php
    $variants = [
        'primary' => 'bg-leaf-700 text-white shadow-sm hover:bg-leaf-800 focus-visible:outline-leaf-700',
        'secondary' => 'bg-white text-leaf-800 ring-1 ring-inset ring-leaf-300 hover:bg-leaf-50',
        'gold' => 'bg-gold-500 text-bark-900 shadow-sm hover:bg-gold-400',
        'danger' => 'bg-berry-600 text-white shadow-sm hover:bg-berry-500',
        'ghost' => 'text-leaf-700 hover:bg-leaf-50',
        'dark' => 'bg-forest-900 text-white shadow-sm hover:bg-forest-800',
    ];
    $sizes = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2.5 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];
    $classes = 'inline-flex items-center justify-center gap-2 rounded-lg font-semibold transition focus-visible:outline-2 focus-visible:outline-offset-2 disabled:cursor-not-allowed disabled:opacity-60 '.$variants[$variant].' '.$sizes[$size];
@endphp

@if ($href)
    <a {{ $attributes->merge(['href' => $href, 'class' => $classes]) }}>
        @if ($icon)
            <x-ui.icon :name="$icon" class="h-4 w-4" />
        @endif
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->merge(['type' => $type, 'class' => $classes]) }}>
        @if ($icon)
            <x-ui.icon :name="$icon" class="h-4 w-4" />
        @endif
        {{ $slot }}
    </button>
@endif