<x-layouts.app title="FAQs">
    <div class="border-b border-sand-200 bg-leaf-50/60">
        <div class="mx-auto max-w-4xl px-4 py-14 sm:px-6 lg:px-8">
            <h1 class="font-display text-3xl font-bold tracking-tight text-forest-900 sm:text-4xl">Frequently asked questions</h1>
            <p class="mt-2 max-w-2xl text-sm text-leaf-800/70">Quick answers to the questions we get most. Can't find yours? <a href="{{ route('contact') }}" class="font-semibold text-leaf-600 hover:underline">Contact us</a>.</p>
        </div>
    </div>

    <div class="mx-auto max-w-4xl px-4 py-12 sm:px-6 lg:px-8">
        @forelse ($faqs as $group => $items)
            <section class="mb-10">
                <h2 class="font-display text-lg font-semibold text-forest-900">{{ $group }}</h2>
                <div class="mt-4 divide-y divide-sand-200 rounded-2xl border border-sand-200 bg-white">
                    @foreach ($items as $faq)
                        <details class="group px-6 py-5">
                            <summary class="flex cursor-pointer items-start justify-between gap-4 font-display text-base font-semibold text-leaf-900">
                                {{ $faq->question }}
                                <x-ui.icon name="chevron-down" class="mt-1 h-4 w-4 shrink-0 text-leaf-800/40 transition group-open:rotate-180" />
                            </summary>
                            <p class="mt-3 text-sm leading-relaxed text-leaf-800/80">{{ $faq->answer }}</p>
                        </details>
                    @endforeach
                </div>
            </section>
        @empty
            <x-ui.empty-state icon="question" title="No FAQs yet" description="Check back soon." />
        @endforelse
    </div>
</x-layouts.app>