<x-layouts.app title="{{ agri_setting('site_meta_title', 'Agrivibe — Grow Together') }}">

    {{-- Hero --}}
    <section class="relative overflow-hidden bg-forest-950">
        <div class="pointer-events-none absolute inset-0">
            <div class="absolute -left-32 -top-24 h-96 w-96 rounded-full bg-leaf-700/30 blur-3xl"></div>
            <div class="absolute -right-24 bottom-0 h-96 w-96 rounded-full bg-gold-500/10 blur-3xl"></div>
            <div class="absolute inset-0 opacity-[0.07]" style="background-image: radial-gradient(circle at 1px 1px, #fff 1px, transparent 0); background-size: 34px 34px;"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 pb-20 pt-16 sm:px-6 sm:pt-24 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <x-ui.badge color="gold" class="mb-5">
                    <x-ui.icon name="sparkles" class="h-3.5 w-3.5" />
                    Built for Uganda's farmers & agribusinesses
                </x-ui.badge>

                <h1 class="font-display text-4xl font-bold leading-tight tracking-tight text-white sm:text-5xl lg:text-6xl">
                    Everything your farm needs to <span class="text-gold-400">grow</span>
                </h1>

                <p class="mx-auto mt-5 max-w-2xl text-base leading-relaxed text-leaf-100/80 sm:text-lg">
                    Knowledge, farm records, animal health, markets and a community of experts — on your phone, in your language, for every size of farm.
                </p>

                <div class="mt-9 flex flex-col items-center justify-center gap-3 sm:flex-row">
                    <x-ui.button href="{{ route('register') }}" variant="gold" size="lg">Get started free</x-ui.button>
                    <x-ui.button href="{{ route('knowledge.index') }}" variant="ghost" size="lg" class="text-white hover:bg-white/10">Explore the Knowledge Centre</x-ui.button>
                </div>

                {{-- Hero search --}}
                <form action="{{ route('search.index') }}" method="GET" class="mt-10 mx-auto flex max-w-xl items-center gap-2 rounded-2xl border border-white/10 bg-white/95 p-2 shadow-2xl shadow-black/20 backdrop-blur">
                    <x-ui.icon name="search" class="ml-3 h-5 w-5 shrink-0 text-leaf-600" />
                    <input type="search" name="q" placeholder="Search vaccination, piggery, maize, fish ponds…"
                        class="w-full border-0 bg-transparent text-sm text-leaf-950 placeholder:text-leaf-800/40 focus:outline-none focus:ring-0"
                        autocomplete="off" />
                    <x-ui.button variant="primary" size="md" type="submit" class="shrink-0">Search</x-ui.button>
                </form>
            </div>

            {{-- Stats --}}
            <div class="mx-auto mt-14 grid max-w-3xl grid-cols-2 gap-4 sm:grid-cols-4">
                @foreach ($stats as $label => $value)
                    <div class="rounded-xl border border-white/10 bg-white/5 px-4 py-4 text-center backdrop-blur">
                        <p class="font-display text-2xl font-semibold text-gold-400">{{ $value }}</p>
                        <p class="mt-1 text-xs font-medium uppercase tracking-wide text-leaf-100/70">{{ $label }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Knowledge categories --}}
    <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="mb-10 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-leaf-600">Knowledge Centre</p>
                <h2 class="mt-2 font-display text-3xl font-bold tracking-tight text-forest-900">Learn what actually works</h2>
                <p class="mt-2 max-w-2xl text-sm text-leaf-800/70">Practical, step-by-step guides written for East African farms — reviewed by experts.</p>
            </div>
            <a href="{{ route('knowledge.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-leaf-600 hover:text-leaf-800">
                Browse all knowledge <x-ui.icon name="arrow-right" class="h-4 w-4" />
            </a>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($categories as $category)
                <a href="{{ route('knowledge.category', $category) }}" class="group relative flex items-center gap-4 overflow-hidden rounded-2xl border border-sand-200 bg-white p-5 transition hover:-translate-y-0.5 hover:border-leaf-300 hover:shadow-lg hover:shadow-leaf-900/5">
                    <span class="inline-flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-leaf-100 text-2xl">{{ $category->icon }}</span>
                    <span class="min-w-0 flex-1">
                        <span class="block font-display text-base font-semibold text-leaf-900">{{ $category->name }}</span>
                        <span class="mt-0.5 block truncate text-xs text-leaf-800/60">{{ $category->articles_count }} guides</span>
                    </span>
                    <x-ui.icon name="chevron-right" class="h-4 w-4 shrink-0 text-leaf-800/30 transition group-hover:translate-x-1 group-hover:text-leaf-600" />
                </a>
            @endforeach
        </div>
    </section>

    {{-- Featured articles --}}
    @if ($featuredArticles->isNotEmpty())
        <section class="bg-white py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-10 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-leaf-600">Editor's picks</p>
                        <h2 class="mt-2 font-display text-3xl font-bold tracking-tight text-forest-900">Featured guides</h2>
                    </div>
                </div>

                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($featuredArticles as $article)
                        <a href="{{ route('knowledge.article', ['category' => $article->category->slug, 'article' => $article]) }}" class="group flex flex-col overflow-hidden rounded-2xl border border-sand-200 bg-sand-25 transition hover:-translate-y-0.5 hover:shadow-lg hover:shadow-leaf-900/5">
                            <div class="flex h-40 items-center justify-center bg-gradient-to-br from-leaf-100 to-leaf-200 p-4">
                                <span class="text-5xl opacity-80">{{ $article->category?->icon }}</span>
                            </div>
                            <div class="flex flex-1 flex-col p-5">
                                <span class="text-xs font-semibold uppercase tracking-wide text-leaf-600">{{ $article->category?->name }}</span>
                                <h3 class="mt-2 font-display text-base font-semibold leading-snug text-leaf-900 group-hover:text-leaf-600">{{ $article->title }}</h3>
                                <p class="mt-2 line-clamp-2 flex-1 text-sm leading-relaxed text-leaf-800/70">{{ $article->excerpt }}</p>
                                <div class="mt-4 flex items-center justify-between text-xs text-leaf-800/50">
                                    <span>{{ $article->published_at?->format('M j, Y') }}</span>
                                    <span class="inline-flex items-center gap-1"><x-ui.icon name="clock" class="h-3.5 w-3.5" /> {{ $article->views }} views</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Latest + news --}}
    <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <h2 class="font-display text-2xl font-bold tracking-tight text-forest-900">Latest from the Knowledge Centre</h2>
                <div class="mt-8 space-y-6">
                    @foreach ($latestArticles as $article)
                        <a href="{{ route('knowledge.article', ['category' => $article->category->slug, 'article' => $article]) }}" class="group flex items-start gap-4 border-b border-sand-200 pb-6 last:border-0">
                            <span class="hidden h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-leaf-50 text-3xl sm:inline-flex">{{ $article->category?->icon }}</span>
                            <span class="min-w-0">
                                <span class="text-xs font-semibold uppercase tracking-wide text-leaf-600">{{ $article->category?->name }}</span>
                                <span class="mt-1 block font-display text-lg font-semibold leading-snug text-leaf-900 group-hover:text-leaf-600">{{ $article->title }}</span>
                                <span class="mt-1.5 block text-sm leading-relaxed text-leaf-800/70">{{ $article->excerpt }}</span>
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>

            <aside>
                <h2 class="font-display text-2xl font-bold tracking-tight text-forest-900">News & updates</h2>
                <div class="mt-8 space-y-5">
                    @foreach ($news as $item)
                        <a href="{{ route('knowledge.article', ['category' => $item->category->slug, 'article' => $item]) }}" class="group block rounded-2xl border border-sand-200 bg-white p-5 transition hover:border-leaf-300 hover:shadow-lg hover:shadow-leaf-900/5">
                            <span class="text-xs font-semibold uppercase tracking-wide text-gold-600">News</span>
                            <span class="mt-2 block font-display text-base font-semibold leading-snug text-leaf-900 group-hover:text-leaf-600">{{ $item->title }}</span>
                            <span class="mt-3 flex items-center gap-2 text-xs text-leaf-800/50">
                                <x-ui.icon name="calendar" class="h-3.5 w-3.5" /> {{ $item->published_at?->format('M j, Y') }}
                            </span>
                        </a>
                    @endforeach
                </div>
            </aside>
        </div>
    </section>

    {{-- CTA --}}
    <section class="mx-auto max-w-7xl px-4 pb-20 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden rounded-3xl bg-forest-900 px-6 py-16 text-center sm:px-16">
            <div class="pointer-events-none absolute -right-20 -top-20 h-72 w-72 rounded-full bg-leaf-600/30 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-24 -left-16 h-72 w-72 rounded-full bg-gold-500/10 blur-3xl"></div>
            <div class="relative">
                <h2 class="mx-auto max-w-2xl font-display text-3xl font-bold tracking-tight text-white sm:text-4xl">
                    Start growing stronger, today
                </h2>
                <p class="mx-auto mt-4 max-w-xl text-sm leading-relaxed text-leaf-100/80 sm:text-base">
                    Create your free account and unlock your digital farm — knowledge, records and a community that has your back.
                </p>
                <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row">
                    <x-ui.button href="{{ route('register') }}" variant="gold" size="lg">Join Agrivibe free</x-ui.button>
                    <x-ui.button href="{{ route('about') }}" variant="ghost" size="lg" class="text-white hover:bg-white/10">Learn more</x-ui.button>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>