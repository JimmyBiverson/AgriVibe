@props(['title' => null, 'description' => null, 'align' => 'left', 'action' => null])

<div @class([
    'mb-8 flex flex-col gap-4 sm:flex-row sm:items-end',
    'sm:justify-between' => $action,
])>
    <div @class(['max-w-3xl flex-1', $align === 'center' ? 'mx-auto text-center' : ''])>
        @if ($title)
            <h1 class="font-display text-3xl font-bold tracking-tight text-forest-900 sm:text-4xl">{{ $title }}</h1>
        @endif
        @if ($description)
            <p class="mt-3 text-base leading-relaxed text-leaf-800/70">{{ $description }}</p>
        @endif
    </div>
    @if ($action)
        <div class="shrink-0">{{ $action }}</div>
    @endif
</div>