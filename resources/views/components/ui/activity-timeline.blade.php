@props(['items' => collect(), 'emptyMessage' => 'No recent activity'])

<div {{ $attributes->merge(['class' => 'rounded-2xl border border-sand-200 bg-white shadow-sm']) }}>
    <div class="flex items-center justify-between border-b border-sand-100 p-4">
        <h3 class="font-display text-base font-semibold text-forest-900">Recent Activity</h3>
    </div>
    <div class="divide-y divide-sand-100">
        @forelse ($items as $item)
            <div class="flex items-start gap-3 p-4">
                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-leaf-100 text-leaf-700">
                    <x-ui.icon :name="$item['icon'] ?? 'sparkles'" class="h-4 w-4" />
                </span>
                <div class="flex-1">
                    <p class="text-sm font-medium text-forest-900">{{ $item['title'] }}</p>
                    @if ($item['description'])
                        <p class="mt-0.5 text-xs text-leaf-600">{{ $item['description'] }}</p>
                    @endif
                    @if ($item['time'])
                        <p class="mt-1 text-[11px] text-leaf-500">{{ $item['time'] }}</p>
                    @endif
                </div>
            </div>
        @empty
            <div class="p-6 text-center text-sm text-leaf-600">{{ $emptyMessage }}</div>
        @endforelse
    </div>
</div>