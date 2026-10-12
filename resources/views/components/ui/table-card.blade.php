@props(['title' => null, 'class' => ''])

<div {{ $attributes->merge(['class' => 'rounded-2xl border border-sand-200 bg-white shadow-sm ' . $class]) }}>
    @if ($title)
        <div class="flex items-center justify-between border-b border-sand-100 p-4">
            <h3 class="font-display text-base font-semibold text-forest-900">{{ $title }}</h3>
            <div class="flex items-center gap-2">
                {{ $actions ?? '' }}
            </div>
        </div>
    @endif
    <div class="p-4">
        {{ $slot }}
    </div>
</div>