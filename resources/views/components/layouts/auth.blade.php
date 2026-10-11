@props(['title' => null, 'subtitle' => null, 'maxWidth' => 'max-w-md'])

<x-layouts.app :title="$title">
    <div class="relative flex min-h-[80vh] items-center justify-center px-4 py-12 sm:px-6">
        <div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
            <div class="absolute -left-24 top-10 h-72 w-72 rounded-full bg-leaf-200/50 blur-3xl"></div>
            <div class="absolute -right-24 bottom-10 h-72 w-72 rounded-full bg-gold-100/60 blur-3xl"></div>
        </div>

        <div class="relative w-full {{ $maxWidth }}">
            <div class="mb-6 flex justify-center">
                <x-brand-logo class="h-11 w-11" />
            </div>

            <div class="rounded-2xl border border-sand-200 bg-white/90 p-6 shadow-xl shadow-leaf-900/5 backdrop-blur sm:p-8">
                @if ($title || $subtitle)
                    <div class="mb-6 text-center">
                        @if ($title)
                            <h1 class="font-display text-2xl font-bold tracking-tight text-forest-900">{{ $title }}</h1>
                        @endif
                        @if ($subtitle)
                            <p class="mt-2 text-sm leading-relaxed text-leaf-800/70">{{ $subtitle }}</p>
                        @endif
                    </div>
                @endif

                {{ $slot }}
            </div>

            <p class="mt-5 text-center text-xs text-leaf-800/50">
                {{ agri_setting('site_name', 'Agrivibe') }} — {{ agri_setting('site_tagline', 'the connected farming community') }}
            </p>
        </div>
    </div>
</x-layouts.app>