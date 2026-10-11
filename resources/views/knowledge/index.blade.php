<x-layouts.app title="Knowledge Centre">
    <x-ui.page-header
        title="The Knowledge Centre"
        description="Practical guides on livestock, poultry, fish farming, crops, animal health and farm management — written for East African farmers."
        class="mx-auto max-w-7xl px-4 pt-14 sm:px-6 lg:px-8"
    />

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {{-- Categories grid --}}
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($categories as $category)
                <a href="{{ route('knowledge.category', $category) }}" class="group flex items-center gap-4 rounded-2xl border border-sand-200 bg-white p-5 transition hover:-translate-y-0.5 hover:border-leaf-300 hover:shadow-lg hover:shadow-leaf-900/5">
                    <span class="inline-flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-leaf-100 text-2xl">{{ $category->icon }}</span>
                    <span class="min-w-0 flex-1">
                        <span class="block font-display text-base font-semibold text-leaf-900">{{ $category->name }}</span>
                        <span class="mt-0.5 block text-xs text-leaf-800/60">{{ $category->articles_count }} guides</span>
                    </span>
                    <x-ui.icon name="chevron-right" class="h-4 w-4 shrink-0 text-leaf-800/30 transition group-hover:translate-x-1 group-hover:text-leaf-600" />
                </a>
            @endforeach
        </div>

        {{-- Trending --}}
        @if ($trending->isNotEmpty())
            <div class="mt-16">
                <h2 class="font-display text-2xl font-bold tracking-tight text-forest-900">Trending this week</h2>
                <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($trending as $article)
                        <a href="{{ route('knowledge.article', ['category' => $article->category->slug, 'article' => $article]) }}" class="group flex flex-col rounded-2xl border border-sand-200 bg-white p-5 transition hover:-translate-y-0.5 hover:shadow-lg hover:shadow-leaf-900/5">
                            <div class="flex items-center justify-between">
                                <span class="text-3xl">{{ $article->category?->icon }}</span>
                                <span class="inline-flex items-center gap-1 text-xs text-leaf-800/50"><x-ui.icon name="eye" class="h-3.5 w-3.5" /> {{ $article->views }}</span>
                            </div>
                            <h3 class="mt-3 font-display text-base font-semibold leading-snug text-leaf-900 group-hover:text-leaf-600">{{ $article->title }}</h3>
                            <p class="mt-2 line-clamp-2 flex-1 text-sm text-leaf-800/70">{{ $article->excerpt }}</p>
                            <span class="mt-4 text-xs font-semibold uppercase tracking-wide text-leaf-600">{{ $article->category?->name }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        @if ($featured->isNotEmpty())
            <div class="mt-16 flex flex-wrap gap-6">
                @foreach ($featured as $article)
                    <a href="{{ route('knowledge.article', ['category' => $article->category->slug, 'article' => $article]) }}" class="group flex flex-1 flex-row items-center gap-5 overflow-hidden rounded-2xl border border-gold-200 bg-gradient-to-br from-gold-50 to-sand-25 p-6 sm:min-w-[320px]">
                        <span class="text-5xl">{{ $article->category?->icon }}</span>
                        <span class="min-w-0">
                            <x-ui.badge color="gold" size="sm">Featured</x-ui.badge>
                            <h3 class="mt-2 font-display text-lg font-semibold leading-snug text-leaf-900 group-hover:text-leaf-600">{{ $article->title }}</h3>
                            <p class="mt-1 line-clamp-2 text-sm text-leaf-800/70">{{ $article->excerpt }}</p>
                        </span>
                    </a>
                @endforeach
            </div>
        @endif

        {{-- Latest full list --}}
        <div class="mt-16 pb-20">
            <h2 class="font-display text-2xl font-bold tracking-tight text-forest-900">All guides</h2>
            <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($latest as $article)
                    <a href="{{ route('knowledge.article', ['category' => $article->category->slug, 'article' => $article]) }}" class="group flex flex-col rounded-2xl border border-sand-200 bg-white p-5 transition hover:-translate-y-0.5 hover:border-leaf-300 hover:shadow-lg hover:shadow-leaf-900/5">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold uppercase tracking-wide text-leaf-600">{{ $article->category?->name }}</span>
                            <x-ui.icon name="arrow-right" class="h-4 w-4 text-leaf-800/30 transition group-hover:translate-x-1 group-hover:text-leaf-600" />
                        </div>
                        <h3 class="mt-3 font-display text-lg font-semibold leading-snug text-leaf-900 group-hover:text-leaf-600">{{ $article->title }}</h3>
                        <p class="mt-2 line-clamp-3 flex-1 text-sm leading-relaxed text-leaf-800/70">{{ $article->excerpt }}</p>
                        <div class="mt-4 flex items-center justify-between text-xs text-leaf-800/50">
                            <span>{{ $article->published_at?->format('M j, Y') }}</span>
                            <span class="inline-flex items-center gap-1"><x-ui.icon name="clock" class="h-3.5 w-3.5" /> {{ $article->views }} views</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.app>