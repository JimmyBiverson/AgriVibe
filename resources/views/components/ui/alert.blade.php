@props(['type' => 'info', 'dismissable' => false])

@php
    $styles = [
        'info' => 'border-sky-300 bg-sky-50 text-sky-900',
        'success' => 'border-leaf-300 bg-leaf-50 text-leaf-900',
        'warning' => 'border-gold-300 bg-gold-50 text-gold-900',
        'danger' => 'border-rose-300 bg-rose-50 text-rose-900',
    ];
@endphp

<div x-data="{ open: true }" x-show="open" x-transition
    {{ $attributes->merge(['class' => 'flex items-start gap-3 rounded-lg border p-4 text-sm '.$styles[$type]]) }}>
    <div class="flex-1">{{ $slot }}</div>
    @if ($dismissable)
        <button type="button" @click="open = false" aria-label="Dismiss alert" class="text-current/60 hover:text-current">
            <x-ui.icon name="x-mark" class="h-4 w-4" />
        </button>
    @endif
</div>