@php
    $nav = config('agrivibe.navigation');
    $knowledgeChildren = config('agrivibe.knowledge_categories');
@endphp

<header class="sticky top-0 z-50 border-b border-sand-200/70 bg-sand-25/95 backdrop-blur">
    @if (agri_setting('announcement_enabled', false))
        <div class="bg-forest-900 px-4 py-2 text-center text-xs font-medium text-leaf-100">
            {{ agri_setting('announcement_text', 'Welcome to the connected farming community.') }}
        </div>
    @endif

    <nav class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8" aria-label="Main">
        <x-brand-logo class="h-10 w-10" />

        <div class="hidden items-center gap-1 lg:flex" x-data="{ open: null }" @mouseleave="open = null">
            @foreach ($nav as $item)
                <div
                    class="relative"
                    @mouseenter="open = '{{ $loop->index }}'"
                >
                    <a
                        href="{{ route($item['route']) }}"
                        class="inline-flex items-center gap-1 rounded-lg px-3 py-2 text-sm font-medium text-leaf-900 hover:bg-leaf-50 hover:text-leaf-700"
                        {{ $loop->index === 0 ? '@mouseenter="open = \'0\'"' : '' }}
                    >
                        {{ $item['label'] }}
                        @if (! empty($item['children']))
                            <x-ui.icon name="chevron-down" class="h-3.5 w-3.5 text-leaf-800/50" />
                        @endif
                    </a>
                    @if (! empty($item['children']))
                        <div
                            x-show="open === '{{ $loop->index }}'"
                            x-transition
                            @click.outside="open = null"
                            class="absolute left-0 top-full w-72 rounded-xl border border-sand-200 bg-white p-2 shadow-xl"
                            style="display:none"
                        >
                            @foreach ($item['children'] as $child)
                                <a href="{{ $child['url'] }}" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-leaf-900 hover:bg-leaf-50">
                                    <x-ui.icon :name="$child['icon']" class="h-4 w-4 text-leaf-600" />
                                    <span>
                                        <span class="block font-medium">{{ $child['label'] }}</span>
                                        @if (! empty($child['description']))
                                            <span class="block text-xs text-leaf-800/60">{{ $child['description'] }}</span>
                                        @endif
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('search.index') }}" class="rounded-lg p-2 text-leaf-800 hover:bg-leaf-50" aria-label="Search">
                <x-ui.icon name="search" class="h-5 w-5" />
            </a>

            @auth
                <a href="{{ route('dashboard') }}" class="hidden items-center gap-2 rounded-lg px-3 py-2 text-sm font-semibold text-leaf-700 hover:bg-leaf-50 sm:inline-flex">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-leaf-700 text-xs font-bold text-white">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>
                    <span class="hidden md:inline">My Dashboard</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="hidden sm:block">
                    @csrf
                    <x-ui.button variant="ghost" size="sm" type="submit">Log out</x-ui.button>
                </form>
            @else
                <a href="{{ route('login') }}" class="hidden text-sm font-semibold text-leaf-800 hover:text-leaf-600 sm:block">Log in</a>
                <a href="{{ route('register') }}">
                    <x-ui.button variant="primary" size="sm">Get started</x-ui.button>
                </a>
            @endauth

            <button type="button" class="rounded-lg p-2 text-leaf-900 lg:hidden" x-data x-on:click="$store.mobileNav.toggle()" aria-label="Open menu">
                <x-ui.icon name="menu" class="h-6 w-6" />
            </button>
        </div>
    </nav>

    {{-- Mobile menu --}}
    <div
        x-show="$store.mobileNav.open"
        x-cloak
        x-transition
        class="border-t border-sand-200 bg-sand-25 lg:hidden"
    >
        <div class="mx-auto max-w-7xl space-y-1 px-4 py-4">
            @foreach ($nav as $item)
                <a href="{{ route($item['route']) }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-leaf-900 hover:bg-leaf-50" x-on:click="$store.mobileNav.close()">
                    {{ $item['label'] }}
                </a>
            @endforeach
            <div class="pt-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="block rounded-lg px-3 py-2 text-sm font-semibold text-leaf-700" x-on:click="$store.mobileNav.close()">My Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="block rounded-lg px-3 py-2 text-sm font-semibold text-leaf-700" x-on:click="$store.mobileNav.close()">Log in</a>
                @endauth
            </div>
        </div>
    </div>
</header>