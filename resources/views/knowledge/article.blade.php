<x-layouts.app :title="$article->meta_title ?? $article->title" :description="$article->meta_description ?? $article->excerpt">
    <div class="border-b border-sand-200 bg-leaf-50/60">
        <div class="mx-auto max-w-4xl px-4 py-12 sm:px-6 lg:px-8">
            <nav class="text-xs font-medium text-leaf-800/60" aria-label="Breadcrumb">
                <ol class="flex items-center gap-1.5">
                    <li><a href="{{ route('home') }}" class="hover:text-leaf-700">Home</a></li>
                    <li><x-ui.icon name="chevron-right" class="h-3 w-3" /></li>
                    <li><a href="{{ route('knowledge.index') }}" class="hover:text-leaf-700">Knowledge Centre</a></li>
                    <li><x-ui.icon name="chevron-right" class="h-3 w-3" /></li>
                    <li><a href="{{ route('knowledge.category', $article->category) }}" class="hover:text-leaf-700">{{ $article->category->name }}</a></li>
                </ol>
            </nav>

            <h1 class="mt-5 font-display text-3xl font-bold leading-tight tracking-tight text-forest-900 sm:text-4xl">{{ $article->title }}</h1>

            <div class="mt-5 flex flex-wrap items-center gap-3">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-white text-2xl shadow-sm">{{ $article->category->icon }}</span>
                <div class="text-xs text-leaf-800/60">
                    <p class="font-semibold text-leaf-900">{{ $article->category->name }}</p>
                    <p>
                        {{ $article->published_at?->format('M j, Y') }} ·
                        <span class="inline-flex items-center gap-1"><x-ui.icon name="eye" class="h-3 w-3" /> {{ $article->views }} views</span>
                    </p>
                </div>
                @if ($article->is_expert_verified)
                    <x-ui.badge color="green"><x-ui.icon name="shield" class="h-3.5 w-3.5" /> Expert reviewed</x-ui.badge>
                @endif
                @if ($article->requires_vet_validation)
                    <x-ui.badge color="amber"><x-ui.icon name="warn" class="h-3.5 w-3.5" /> Consult a vet</x-ui.badge>
                @endif
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-4">
            <article class="lg:col-span-3">
                <p class="font-display text-lg font-medium leading-relaxed text-leaf-900">{{ $article->excerpt }}</p>

                <div class="mt-6 agri-prose">
                    {!! $article->body !!}
                </div>

                @if ($article->disclaimer)
                    <x-ui.alert type="warning" class="mt-8">
                        <strong>Important:</strong> {{ $article->disclaimer }}
                    </x-ui.alert>
                @endif

                <div class="mt-10 border-t border-sand-200 pt-6">
                    <h3 class="font-display text-sm font-semibold uppercase tracking-wider text-leaf-900">Tags</h3>
                    <div class="mt-3 flex flex-wrap gap-2">
                        @forelse ($article->tags as $tag)
                            <a href="{{ route('search.index', ['q' => $tag->name]) }}" class="rounded-full bg-leaf-50 px-3 py-1 text-xs font-medium text-leaf-700 ring-1 ring-inset ring-leaf-200 hover:bg-leaf-100">
                                {{ $tag->name }}
                            </a>
                        @empty
                            <span class="text-sm text-leaf-800/50">Untagged</span>
                        @endforelse
                    </div>
                </div>
            </article>

            <aside class="space-y-6">
                <div class="rounded-2xl border border-sand-200 bg-white p-5">
                    <h3 class="font-display text-sm font-semibold uppercase tracking-wider text-leaf-900">Related guides</h3>
                    <div class="mt-4 space-y-4">
                        @forelse ($related as $item)
                            <a href="{{ route('knowledge.article', ['category' => $item->category->slug, 'article' => $item]) }}" class="group block">
                                <span class="text-xs font-semibold uppercase tracking-wide text-leaf-600">{{ $item->category?->name }}</span>
                                <span class="mt-1 block font-display text-sm font-semibold leading-snug text-leaf-900 group-hover:text-leaf-600">{{ $item->title }}</span>
                            </a>
                        @empty
                            <p class="text-sm text-leaf-800/50">No related guides yet.</p>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-2xl border border-sand-200 bg-white p-5">
                    <h3 class="font-display text-sm font-semibold uppercase tracking-wider text-leaf-900">News & updates</h3>
                    <div class="mt-4 space-y-4">
                        @foreach ($news as $item)
                            <a href="{{ route('knowledge.article', ['category' => $item->category->slug, 'article' => $item]) }}" class="group block">
                                <span class="block text-sm font-semibold leading-snug text-leaf-900 group-hover:text-leaf-600">{{ $item->title }}</span>
                                <span class="mt-1 block text-xs text-leaf-800/50">{{ $item->published_at?->format('M j, Y') }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                @guest
                    <div class="rounded-2xl bg-forest-900 p-6 text-center">
                        <h3 class="font-display text-base font-semibold text-white">Love this content?</h3>
                        <p class="mt-2 text-sm text-leaf-100/70">Join free and get personalised advice, SMS reminders and more.</p>
                        <x-ui.button href="{{ route('register') }}" variant="gold" size="sm" class="mt-4">Join free</x-ui.button>
                    </div>
                @endguest
            </aside>
        </div>
    </div>
</x-layouts.app>