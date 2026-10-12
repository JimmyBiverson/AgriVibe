@props(['farms' => collect(), 'currentFarm' => null, 'user' => null])

<div x-data="{ open: false }" class="relative">
    <button type="button" @click="open = !open" class="flex items-center gap-2 rounded-xl bg-white/10 px-3 py-1.5 text-xs font-semibold text-leaf-100 transition hover:bg-white/20">
        <x-ui.icon name="building-office" class="h-4 w-4" />
        <span class="max-w-[120px] truncate sm:max-w-[160px]">
            {{ $currentFarm?->name ?? ($user?->name ?? 'My Farm') }}
        </span>
        <x-ui.icon name="chevron-down" class="h-3.5 w-3.5 transition" x-bind:class="{ 'rotate-180': open }" />
    </button>

    <div x-show="open" x-transition x-cloak @click.away="open = false" class="absolute right-0 z-50 mt-2 w-64 rounded-2xl border border-sand-200 bg-white shadow-xl">
        <div class="border-b border-sand-100 px-3 py-2">
            <p class="text-xs font-semibold text-leaf-900">Switch Farm</p>
            <p class="text-[11px] text-leaf-600">Manage multiple enterprises</p>
        </div>
        <div class="max-h-64 overflow-auto py-1">
            <a href="{{ route('dashboard') }}" class="flex items-center justify-between px-3 py-2 text-xs text-leaf-900 hover:bg-sand-50">
                <span>All Farms (Overview)</span>
                @if (! $currentFarm)
                    <x-ui.icon name="check" class="h-4 w-4 text-emerald-600" />
                @endif
            </a>
            @foreach ($farms as $farm)
                <a href="{{ route('dashboard', ['farm' => $farm->id]) }}" class="flex items-center justify-between px-3 py-2 text-xs text-leaf-900 hover:bg-sand-50">
                    <div>
                        <p class="font-medium">{{ $farm->name }}</p>
                        <p class="text-[11px] text-leaf-600">{{ $farm->district ?? $farm->country }}</p>
                    </div>
                    @if ($currentFarm && $currentFarm->id === $farm->id)
                        <x-ui.icon name="check" class="h-4 w-4 text-emerald-600" />
                    @endif
                </a>
            @endforeach
        </div>
        <div class="border-t border-sand-100 px-3 py-2 text-right">
            <a href="{{ url('/farms/create') }}" class="text-xs font-semibold text-leaf-600 hover:underline">+ Create New Farm</a>
        </div>
    </div>
</div>
