<x-layouts.app :title="$title">
    <section class="relative overflow-hidden bg-forest-950">
        <div class="pointer-events-none absolute inset-0">
            <div class="absolute -left-24 -top-20 h-80 w-80 rounded-full bg-leaf-700/30 blur-3xl"></div>
            <div class="absolute -right-20 bottom-0 h-80 w-80 rounded-full bg-gold-500/10 blur-3xl"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <span class="inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-white/10 text-gold-400 backdrop-blur">
                    <x-ui.icon :name="$icon" class="h-7 w-7" />
                </span>
                @if (isset($eyebrow))
                    <p class="mt-5 text-xs font-semibold uppercase tracking-wider text-gold-400">{{ $eyebrow }}</p>
                @endif
                <h1 class="mt-3 font-display text-4xl font-bold tracking-tight text-white sm:text-5xl">{{ $title }}</h1>
                <p class="mx-auto mt-5 max-w-2xl text-base leading-relaxed text-leaf-100/80 sm:text-lg">{{ $intro }}</p>
            </div>
        </div>
    </section>

    <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <x-ui.alert type="info" class="mx-auto max-w-3xl">
            <p><strong>Module status:</strong> {{ $status }}. {{ $statusNote }}</p>
        </x-ui.alert>

        @if (! empty($profileHints))
            <div class="mx-auto mt-8 flex max-w-3xl flex-wrap items-center justify-center gap-3">
                @foreach ($profileHints as $accountType => $hint)
                    @php $type = config("agrivibe.account_types.{$accountType}", []) @endphp
                    <a href="{{ route('register') }}" class="group flex items-center gap-3 rounded-xl border border-sand-200 bg-white px-5 py-3 text-sm transition hover:border-leaf-300 hover:shadow-md">
                        <span class="font-semibold text-leaf-700 group-hover:text-leaf-600">{{ $type['label'] ?? ucfirst($accountType) }}</span>
                        <span class="hidden text-leaf-800/60 sm:inline">·</span>
                        <span class="hidden text-xs text-leaf-800/60 sm:inline">{{ $hint }}</span>
                    </a>
                @endforeach
            </div>
            <p class="mt-4 text-center text-xs text-leaf-800/50">Joining as one of these is free — select it during registration.</p>
        @endif

        <div class="mx-auto mt-14 max-w-5xl">
            <h2 class="text-center font-display text-2xl font-bold tracking-tight text-forest-900">Related knowledge while you wait</h2>
            <div class="mt-8 grid gap-6 sm:grid-cols-3">
                @foreach ($relatedArticles as $article)
                    <a href="{{ route('knowledge.article', ['category' => $article->category->slug, 'article' => $article]) }}" class="group flex flex-col rounded-2xl border border-sand-200 bg-white p-6 transition hover:-translate-y-0.5 hover:border-leaf-300 hover:shadow-lg hover:shadow-leaf-900/5">
                        <span class="text-3xl">{{ $article->category?->icon }}</span>
                        <h3 class="mt-3 font-display text-base font-semibold leading-snug text-leaf-900 group-hover:text-leaf-600">{{ $article->title }}</h3>
                        <p class="mt-2 line-clamp-2 flex-1 text-sm text-leaf-800/70">{{ $article->excerpt }}</p>
                        <span class="mt-4 text-xs font-semibold uppercase tracking-wide text-leaf-600">{{ $article->category?->name }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-layouts.app>