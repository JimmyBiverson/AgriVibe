<x-ui.card class="h-full">
    <div class="flex items-start justify-between gap-3">
        <div>
            <p {{ $attributes->merge(['class' => 'text-sm font-medium text-leaf-800/60']) }}>{{ $label }}</p>
            <p class="mt-1 font-display text-2xl font-semibold text-leaf-900">{{ $value }}</p>
        </div>
        <span class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-leaf-100 text-leaf-700">
            <x-ui.icon :name="$icon ?? 'sparkles'" class="h-5 w-5" />
        </span>
    </div>
    @if (isset($foot))
        <div class="mt-3 border-t border-sand-100 pt-3 text-xs text-leaf-800/60">{{ $foot }}</div>
    @endif
</x-ui.card>