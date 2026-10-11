@props(['icon' => 'document', 'title' => 'Nothing here yet', 'description' => null, 'action' => null])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center rounded-2xl border border-dashed border-sand-300 bg-sand-50 px-6 py-16 text-center']) }}>
    <span class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-leaf-100 text-leaf-600">
        <x-ui.icon :name="$icon" class="h-7 w-7" />
    </span>
    <h3 class="mt-4 font-display text-lg font-semibold text-leaf-900">{{ $title }}</h3>
    @if ($description)
        <p class="mt-1 max-w-md text-sm text-leaf-800/60">{{ $description }}</p>
    @endif
    @if ($action)
        <div class="mt-5">{{ $action }}</div>
    @endif
</div>