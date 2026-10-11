<x-layouts.app title="Search">
    <div class="border-b border-sand-200 bg-leaf-50/60">
        <div class="mx-auto max-w-5xl px-4 py-14 sm:px-6 lg:px-8">
            <h1 class="font-display text-3xl font-bold tracking-tight text-forest-900 sm:text-4xl">Search Agrivibe</h1>
            <p class="mt-2 max-w-2xl text-sm text-leaf-800/70">Find guides, species, diseases and answers from the Knowledge Centre.</p>

            <form action="{{ route('search.index') }}" method="GET" class="mt-6">
                <div class="flex items-center gap-2 rounded-2xl border border-sand-200 bg-white p-2 shadow-sm">
                    <x-ui.icon name="search" class="ml-3 h-5 w-5 shrink-0 text-leaf-600" />
                    <input type="search" id="search-box" name="q" value="{{ $q }}" placeholder="Try “vaccination”, “goats”, “ECF”…"
                        class="w-full border-0 bg-transparent py-2 text-sm text-leaf-950 placeholder:text-leaf-800/40 focus:outline-none focus:ring-0"
                        autocomplete="off" autofocus />
                    <x-ui.button variant="primary" size="md" type="submit" class="shrink-0">Search</x-ui.button>
                </div>
            </form>
        </div>
    </div>

    <div class="mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8">
        @if ($q !== '')
            <div class="flex flex-wrap items-center gap-2">
                <span class="text-sm text-leaf-800/60">Filter:</span>
                @foreach (['' => 'All', 'articles' => 'Articles', 'species' => 'Species', 'diseases' => 'Diseases', 'faqs' => 'FAQs'] as $key => $label)
                    <a href="{{ route('search.index', ['q' => $q, 'type' => $key]) }}"
                        @class([
                            'rounded-full px-3 py-1 text-xs font-medium ring-1 ring-inset transition',
                            'bg-leaf-700 text-white ring-leaf-700' => $type === $key,
                            'bg-white text-leaf-700 ring-sand-300 hover:bg-leaf-50' => $type !== $key,
                        ])>
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            @if ($categorySlug)
                <a href="{{ route('search.index', ['q' => $q, 'type' => $type]) }}" class="mt-2 inline-block text-xs font-medium text-leaf-600 hover:text-leaf-800">
                    × Clear category filter
                </a>
            @endif

            <p class="mt-6 text-sm text-leaf-800/60">Found <strong class="text-leaf-900">{{ $total }}</strong> results for “{{ $q }}”</p>

            @if ($total === 0)
                <div class="mt-8">
                    <x-ui.empty-state
                        icon="search"
                        title="No results found"
                        description="Try different keywords, or browse the Knowledge Centre by category."
                    />
                    <div class="mt-6 text-center">
                        <x-ui.button href="{{ route('knowledge.index') }}" variant="secondary">Browse the Knowledge Centre</x-ui.button>
                    </div>
                </div>
            @else
                <div class="mt-8 space-y-10">
                    @php $labels = ['articles' => 'Articles', 'species' => 'Species', 'diseases' => 'Diseases', 'faqs' => 'FAQ answers']; @endphp

                    @foreach ($results->filter(fn ($r) => $r->isNotEmpty()) as $type => $items)
                        <section>
                            <h2 class="font-display text-lg font-semibold text-forest-900">
                                {{ $labels[$type] ?? ucfirst($type) }}
                                <span class="text-sm font-normal text-leaf-800/50">({{ $items->count() }})</span>
                            </h2>

                            <div class="mt-4 divide-y divide-sand-200 rounded-2xl border border-sand-200 bg-white">
                                @foreach ($items as $item)
                                    @if ($type === 'articles')
                                        <a href="{{ route('knowledge.article', ['category' => $item->category->slug, 'article' => $item]) }}" class="group flex items-start gap-4 p-5 transition hover:bg-leaf-50/60">
                                            <span class="text-2xl">{{ $item->category?->icon }}</span>
                                            <span class="min-w-0">
                                                <span class="block text-xs font-semibold uppercase tracking-wide text-leaf-600">{{ $item->category?->name }}</span>
                                                <span class="mt-1 block font-display text-base font-semibold text-leaf-900 group-hover:text-leaf-600">{{ $item->title }}</span>
                                                <span class="mt-1 block text-sm text-leaf-800/70">{{ $item->excerpt }}</span>
                                            </span>
                                        </a>
                                    @elseif ($type === 'species')
                                        <div class="flex items-start gap-4 p-5">
                                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-leaf-100 text-leaf-700"><x-ui.icon name="leaf" class="h-5 w-5" /></span>
                                            <span class="min-w-0">
                                                <span class="block font-display text-base font-semibold text-leaf-900">{{ $item->name }}</span>
                                                @if ($item->scientific_name)
                                                    <span class="mt-0.5 block text-sm italic text-leaf-800/60">{{ $item->scientific_name }}</span>
                                                @endif
                                                <span class="mt-1 block text-xs text-leaf-800/50">Species profile — farm tools ship in the next phase</span>
                                            </span>
                                        </div>
                                    @elseif ($type === 'diseases')
                                        <div class="flex items-start gap-4 p-5">
                                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-rose-100 text-rose-700"><x-ui.icon name="heart-pulse" class="h-5 w-5" /></span>
                                            <span class="min-w-0">
                                                <span class="block font-display text-base font-semibold text-leaf-900">{{ $item->name }}</span>
                                                @if ($item->aliases)
                                                    <span class="mt-0.5 block text-sm text-leaf-800/60">Also known as: {{ $item->aliases }}</span>
                                                @endif
                                                <span class="mt-1 block text-xs text-leaf-800/50">Always consult a qualified veterinarian</span>
                                            </span>
                                        </div>
                                    @elseif ($type === 'faqs')
                                        <details class="group p-5">
                                            <summary class="flex cursor-pointer items-start justify-between gap-3 font-display text-base font-semibold text-leaf-900">
                                                {{ $item->question }}
                                                <x-ui.icon name="chevron-down" class="mt-1 h-4 w-4 shrink-0 text-leaf-800/40 transition group-open:rotate-180" />
                                            </summary>
                                            <p class="mt-3 text-sm leading-relaxed text-leaf-800/80">{{ $item->answer }}</p>
                                        </details>
                                    @endif
                                @endforeach
                            </div>
                        </section>
                    @endforeach
                </div>
            @endif
        @else
            <div class="mt-4 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($categories as $category)
                    <a href="{{ route('knowledge.category', $category) }}" class="group flex items-center gap-4 rounded-2xl border border-sand-200 bg-white p-5 transition hover:-translate-y-0.5 hover:border-leaf-300 hover:shadow-lg hover:shadow-leaf-900/5">
                        <span class="inline-flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-leaf-100 text-2xl">{{ $category->icon }}</span>
                        <div>
                            <p class="font-display text-base font-semibold text-leaf-900">{{ $category->name }}</p>
                            <p class="mt-0.5 text-xs text-leaf-800/60">Browse {{ $category->name }} guides</p>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</x-layouts.app>