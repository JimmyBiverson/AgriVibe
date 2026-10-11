<x-layouts.app :title="$category->name">
    <div class="border-b border-sand-200 bg-leaf-50/60">
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            <nav class="text-xs font-medium text-leaf-800/60" aria-label="Breadcrumb">
                <ol class="flex items-center gap-1.5">
                    <li><a href="{{ route('home') }}" class="hover:text-leaf-700">Home</a></li>
                    <li><x-ui.icon name="chevron-right" class="h-3 w-3" /></li>
                    <li><a href="{{ route('knowledge.index') }}" class="hover:text-leaf-700">Knowledge Centre</a></li>
                    <li><x-ui.icon name="chevron-right" class="h-3 w-3" /></li>
                    <li class="font-semibold text-leaf-900">{{ $category->name }}</li>
                </ol>
            </nav>

            <div class="mt-5 flex items-center gap-5">
                <span class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-white text-4xl shadow-sm">{{ $category->icon }}</span>
                <div>
                    <h1 class="font-display text-3xl font-bold tracking-tight text-forest-900 sm:text-4xl">{{ $category->name }}</h1>
                    <p class="mt-1 text-sm text-leaf-800/70">
                        {{ $category->description ?? 'Practical guides, step-by-step.' }} · {{ $articles->total() }} guides
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-4">
            <div class="lg:col-span-3">
                @if ($articles->isEmpty())
                    <x-ui.empty-state
                        icon="document"
                        title="No guides yet in this category"
                        description="Our experts are writing new content. Check back soon or explore other categories."
                        :action="null"
                    />
                @else
                    <div class="grid gap-6 sm:grid-cols-2">
                        @foreach ($articles as $article)
                            <a href="{{ route('knowledge.article', ['category' => $category, 'article' => $article]) }}" class="group flex flex-col rounded-2xl border border-sand-200 bg-white p-6 transition hover:-translate-y-0.5 hover:border-leaf-300 hover:shadow-lg hover:shadow-leaf-900/5">
                                <div class="flex items-start justify-between">
                                    <span class="text-4xl">{{ $category->icon }}</span>
                                    @if ($article->is_expert_verified)
                                        <x-ui.badge color="green" size="sm"><x-ui.icon name="shield" class="h-3 w-3" /> Expert reviewed</x-ui.badge>
                                    @endif
                                </div>
                                <h2 class="mt-4 font-display text-lg font-semibold leading-snug text-leaf-900 group-hover:text-leaf-600">{{ $article->title }}</h2>
                                <p class="mt-2 line-clamp-3 flex-1 text-sm leading-relaxed text-leaf-800/70">{{ $article->excerpt }}</p>
                                <div class="mt-4 flex items-center justify-between text-xs text-leaf-800/50">
                                    <span>{{ $article->published_at?->format('M j, Y') }}</span>
                                    <span class="inline-flex items-center gap-1"><x-ui.icon name="clock" class="h-3.5 w-3.5" /> {{ $article->views }} views</span>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-10">
                        {{ $articles->links() }}
                    </div>
                @endif
            </div>

            <aside class="space-y-6">
                <div class="rounded-2xl border border-sand-200 bg-white p-5">
                    <h3 class="font-display text-sm font-semibold uppercase tracking-wider text-leaf-900">Other topics</h3>
                    <div class="mt-4 space-y-2">
                        @foreach ($relatedCategories as $related)
                            <a href="{{ route('knowledge.category', $related) }}" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm text-leaf-900 transition hover:bg-leaf-50">
                                <span class="text-xl">{{ $related->icon }}</span>
                                <span class="font-medium">{{ $related->name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                @auth
                    <div class="rounded-2xl bg-forest-900 p-6 text-center">
                        <h3 class="font-display text-base font-semibold text-white">Take this further</h3>
                        <p class="mt-2 text-sm text-leaf-100/70">Track vaccines, production and costs on your farm.</p>
                        <x-ui.button href="{{ route('dashboard') }}" variant="gold" size="sm" class="mt-4">Go to dashboard</x-ui.button>
                    </div>
                @else
                    <div class="rounded-2xl bg-forest-900 p-6 text-center">
                        <h3 class="font-display text-base font-semibold text-white">Get more for free</h3>
                        <p class="mt-2 text-sm text-leaf-100/70">Create an account for personalised advice and SMS reminders.</p>
                        <x-ui.button href="{{ route('register') }}" variant="gold" size="sm" class="mt-4">Create an account</x-ui.button>
                    </div>
                @endauth
            </aside>
        </div>
    </div>
</x-layouts.app>