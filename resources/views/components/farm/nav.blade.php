@props(['farm' => null, 'farms' => collect()])

<div class="rounded-2xl border border-sand-200 bg-white p-3 shadow-sm">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <nav class="flex flex-wrap items-center gap-1 text-sm">
            @php
                $items = [
                    ['route' => 'dashboard', 'label' => 'Overview', 'match' => 'dashboard'],
                    ['route' => 'farm.animals', 'label' => 'Animals', 'match' => 'farm.animals'],
                    ['route' => 'farm.batches', 'label' => 'Batches', 'match' => 'farm.batches'],
                    ['route' => 'farm.production', 'label' => 'Production', 'match' => 'farm.production'],
                    ['route' => 'farm.finances', 'label' => 'Finance', 'match' => 'farm.finances'],
                    ['route' => 'farm.tasks', 'label' => 'Tasks', 'match' => 'farm.tasks'],
                ];
            @endphp
            @foreach ($items as $item)
                <a href="{{ route($item['route'], ['farm' => $farm?->id]) }}"
                   class="rounded-xl px-3 py-1.5 font-semibold transition {{ request()->routeIs($item['match']) ? 'bg-leaf-600 text-white shadow-sm' : 'text-leaf-700 hover:bg-sand-100' }}">
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        @if ($farms->count() > 1)
            <form method="GET" class="flex items-center gap-2">
                <label class="text-xs font-semibold text-leaf-600">Farm</label>
                <select name="farm" onchange="this.form.submit()" class="rounded-xl border border-sand-300 bg-white px-3 py-1.5 text-sm font-medium text-leaf-900 shadow-sm focus:border-leaf-500 focus:outline-none">
                    @foreach ($farms as $option)
                        <option value="{{ $option->id }}" @selected($farm?->id === $option->id)>{{ $option->name }}</option>
                    @endforeach
                </select>
            </form>
        @elseif ($farm)
            <span class="inline-flex items-center gap-1.5 rounded-xl bg-sand-100 px-3 py-1.5 text-xs font-semibold text-leaf-700">
                <x-ui.icon name="city" class="h-3.5 w-3.5" /> {{ $farm->name }}
            </span>
        @endif
    </div>
</div>
