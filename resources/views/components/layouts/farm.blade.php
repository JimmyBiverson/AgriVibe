@props(['title' => null, 'description' => null, 'farm' => null, 'farms' => null, 'nav' => null])
@php
    $siteName = agri_setting('site_name', 'Agrivibe');
    $user = auth()->user();
    $nav ??= [
        ['route' => 'dashboard', 'label' => 'Overview', 'icon' => 'home'],
        ['route' => 'farm.animals', 'label' => 'Livestock', 'icon' => 'heart-pulse'],
        ['route' => 'farm.batches', 'label' => 'Batches & Flocks', 'icon' => 'list'],
        ['route' => 'farm.production', 'label' => 'Production', 'icon' => 'beaker'],
        ['route' => 'farm.finances', 'label' => 'Finance', 'icon' => 'cash'],
        ['route' => 'farm.tasks', 'label' => 'Tasks', 'icon' => 'calendar'],
        ['route' => 'farm.health', 'label' => 'Animal Health', 'icon' => 'shield'],
        ['route' => 'farm.vet', 'label' => 'Vet Requests', 'icon' => 'heart-pulse'],
        ['route' => 'section.marketplace', 'label' => 'Marketplace', 'icon' => 'bag'],
        ['route' => 'section.find-vet', 'label' => 'Find a Vet', 'icon' => 'search'],
        ['route' => 'knowledge.index', 'label' => 'Academy', 'icon' => 'academy'],
        ['route' => 'section.community', 'label' => 'Community', 'icon' => 'community'],
    ];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.svg') }}">
    <x-seo :title="$title" :description="$description" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-screen bg-sand-50 font-sans text-leaf-950 antialiased" x-data="{ sidebarOpen: false }">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside
            class="fixed inset-y-0 left-0 z-50 w-64 -translate-x-full overflow-y-auto bg-forest-950 text-leaf-100 transition-transform duration-200 lg:static lg:translate-x-0"
            :class="{ 'translate-x-0': sidebarOpen }"
        >
            <div class="flex items-center gap-2.5 px-5 py-5">
                <x-brand-logo class="h-9 w-9" />
                <div>
                    <p class="font-display text-base font-bold leading-tight text-white">{{ $siteName }}</p>
                    <p class="text-[11px] text-leaf-300">Farm Console</p>
                </div>
            </div>

            @if ($farms && $farms->count() > 1)
                <div class="px-4 pb-3">
                    <form method="GET">
                        <select name="farm" onchange="this.form.submit()" class="w-full rounded-xl border border-white/10 bg-white/5 px-3 py-2 text-xs font-semibold text-white focus:outline-none">
                            @foreach ($farms as $option)
                                <option value="{{ $option->id }}" @selected(($farm?->id) === $option->id) class="text-forest-900">{{ $option->name }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
            @elseif ($farm)
                <div class="px-4 pb-3">
                    <span class="block truncate rounded-xl bg-white/5 px-3 py-2 text-xs font-semibold text-leaf-100">{{ $farm->name }}</span>
                </div>
            @endif

            <nav class="space-y-1 px-3 pb-6">
                @foreach ($nav as $item)
                    @php $active = request()->routeIs($item['route']); @endphp
                    <a href="{{ route($item['route'], $farm ? ['farm' => $farm->id] : []) }}"
                       class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition {{ $active ? 'bg-emerald-500 text-forest-950 font-bold shadow' : 'text-leaf-200 hover:bg-white/10 hover:text-white' }}">
                        <x-ui.icon :name="$item['icon']" class="h-4.5 w-4.5" />
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>
        </aside>

        {{-- Backdrop --}}
        <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-forest-950/50 lg:hidden"></div>

        {{-- Main --}}
        <div class="flex min-w-0 flex-1 flex-col">
            <header class="sticky top-0 z-30 flex items-center justify-between gap-3 border-b border-sand-200 bg-white/90 px-4 py-3 backdrop-blur sm:px-6">
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = true" class="rounded-xl p-2 text-leaf-700 hover:bg-sand-100 lg:hidden">
                        <x-ui.icon name="menu" class="h-5 w-5" />
                    </button>
                    <div>
                        <h1 class="font-display text-lg font-bold text-forest-900">{{ $title }}</h1>
                        @if ($farm)
                            <p class="text-xs text-leaf-600">{{ $farm->name }}@if ($farm->district) · {{ $farm->district }}@endif</p>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-2" x-data="{ open: false }">
                    <div class="relative">
                        <button @click="open = !open" class="flex items-center gap-2 rounded-xl border border-sand-200 bg-white px-2.5 py-1.5 text-sm font-semibold text-leaf-800 hover:bg-sand-50">
                            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-gradient-to-br from-emerald-500 to-leaf-700 text-xs font-bold text-white">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                            <span class="hidden max-w-[120px] truncate sm:block">{{ $user->name }}</span>
                            <x-ui.icon name="chevron-down" class="h-3.5 w-3.5" />
                        </button>
                        <div x-show="open" x-cloak @click.away="open = false" x-transition class="absolute right-0 z-50 mt-2 w-52 rounded-2xl border border-sand-200 bg-white p-1.5 shadow-xl">
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-2 rounded-xl px-3 py-2 text-sm text-leaf-800 hover:bg-sand-50"><x-ui.icon name="home" class="h-4 w-4" /> My Dashboard</a>
                            @if ($user->isStaff())
                                <a href="{{ url('/admin') }}" class="flex items-center gap-2 rounded-xl px-3 py-2 text-sm text-leaf-800 hover:bg-sand-50"><x-ui.icon name="tools" class="h-4 w-4" /> Admin Panel</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex w-full items-center gap-2 rounded-xl px-3 py-2 text-left text-sm text-berry-600 hover:bg-berry-50"><x-ui.icon name="arrow-right" class="h-4 w-4" /> Sign out</button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1">
                {{ $slot }}
            </main>
        </div>
    </div>

    {{-- Flash messages --}}
    <div class="fixed inset-x-0 top-0 z-[75] space-y-2 p-4 sm:p-6">
        @foreach (['success' => 'success', 'error' => 'danger', 'warning' => 'warning', 'info' => 'info'] as $key => $type)
            @if (session($key))
                <x-ui.alert :type="$type" dismissable class="mx-auto max-w-lg shadow-lg">{{ session($key) }}</x-ui.alert>
            @endif
        @endforeach
    </div>

    <x-public.toasts />
    @stack('scripts')
</body>
</html>
