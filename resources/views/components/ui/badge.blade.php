@props(['color' => 'green', 'size' => 'md'])

@php
    $colors = [
        'green' => 'bg-leaf-100 text-leaf-800 ring-leaf-200',
        'gold' => 'bg-gold-100 text-gold-800 ring-gold-200',
        'red' => 'bg-rose-100 text-rose-800 ring-rose-200',
        'amber' => 'bg-amber-100 text-amber-800 ring-amber-200',
        'blue' => 'bg-sky-100 text-sky-800 ring-sky-200',
        'slate' => 'bg-slate-100 text-slate-700 ring-slate-200',
    ];
    $sizes = ['sm' => 'px-2 py-0.5 text-xs', 'md' => 'px-2.5 py-1 text-xs', 'lg' => 'px-3 py-1 text-sm'];
    $classes = 'inline-flex items-center gap-1 rounded-full font-semibold ring-1 ring-inset '.$colors[$color].' '.$sizes[$size];
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</span>