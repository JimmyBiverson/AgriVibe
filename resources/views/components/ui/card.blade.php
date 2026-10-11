@props([
    'heading' => null,
    'description' => null,
    'padding' => true,
    'class' => '',
])

<div {{ $attributes->merge(['class' => 'rounded-2xl border border-sand-200 bg-white shadow-sm '.($padding ? 'p-6' : '').' '.$class]) }}>
    @if ($heading)
        <div class="mb-5">
            <h3 class="font-display text-lg font-semibold text-leaf-900">{{ $heading }}</h3>
            @if ($description)
                <p class="mt-1 text-sm text-leaf-800/60">{{ $description }}</p>
            @endif
        </div>
    @endif
    {{ $slot }}
</div>