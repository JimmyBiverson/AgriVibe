@props(['icon' => 'sparkles', 'title' => '', 'description' => '', 'href' => '#', 'color' => 'emerald'])

@php
    $colors = match($color) {
        'amber' => 'bg-amber-100 text-amber-700 hover:bg-amber-200',
        'cyan' => 'bg-cyan-100 text-cyan-700 hover:bg-cyan-200',
        'red' => 'bg-berry-100 text-berry-700 hover:bg-berry-200',
        'gold' => 'bg-gold-100 text-gold-700 hover:bg-gold-200',
        default => 'bg-leaf-100 text-leaf-700 hover:bg-leaf-200',
    };
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'group flex flex-col items-center justify-center gap-2 rounded-2xl border border-sand-200 bg-white p-4 text-center shadow-sm transition hover:-translate-y-0.5 hover:shadow-md hover:shadow-leaf-900/5']) }}>
    <span class="flex h-10 w-10 items-center justify-center rounded-xl ring-1 {{ $colors }}">
        <x-ui.icon :name="$icon" class="h-5 w-5" />
    </span>
    <div>
        <p class="text-sm font-semibold text-forest-900">{{ $title }}</p>
        @if ($description)
            <p class="mt-0.5 text-xs text-leaf-600">{{ $description }}</p>
        @endif
    </div>
</a>