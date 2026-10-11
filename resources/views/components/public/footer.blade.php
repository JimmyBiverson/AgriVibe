@php
    $nav = config('agrivibe.navigation');
@endphp

<footer class="mt-auto bg-forest-950 text-leaf-100">
    <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-4">
            <div class="lg:col-span-1">
                <x-brand-logo class="h-10 w-10" />
                <p class="mt-4 max-w-xs text-sm leading-relaxed text-leaf-200/80">
                    {{ agri_setting('site_tagline', 'The connected farming community — knowledge, tools, markets and experts to help agribusiness thrive.') }}
                </p>
                <div class="mt-5 space-y-2 text-sm text-leaf-200/80">
                    <p class="flex items-center gap-2"><x-ui.icon name="pin" class="h-4 w-4 text-gold-400" /> {{ agri_setting('contact_address', 'Kampala, Uganda') }}</p>
                    <p class="flex items-center gap-2"><x-ui.icon name="phone" class="h-4 w-4 text-gold-400" /> +256 {{ agri_setting('contact_phone', '700 000 000') }}</p>
                    <p class="flex items-center gap-2"><x-ui.icon name="mail" class="h-4 w-4 text-gold-400" /> {{ agri_setting('contact_email', 'hello@agrivibe.com') }}</p>
                </div>
            </div>

            <div>
                <h3 class="font-display text-sm font-semibold uppercase tracking-wider text-gold-300">Explore</h3>
                <ul class="mt-4 space-y-2.5 text-sm">
                    @foreach ($nav as $item)
                        <li><a href="{{ route($item['route']) }}" class="text-leaf-200/80 transition hover:text-white">{{ $item['label'] }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h3 class="font-display text-sm font-semibold uppercase tracking-wider text-gold-300">Knowledge Centre</h3>
                <ul class="mt-4 space-y-2.5 text-sm">
                    @foreach (config('agrivibe.knowledge_categories') as $category)
                        <li><a href="{{ $category['url'] }}" class="text-leaf-200/80 transition hover:text-white">{{ $category['label'] }}</a></li>
                    @endforeach
                    <li><a href="{{ route('faq.index') }}" class="text-leaf-200/80 transition hover:text-white">Frequently Asked Questions</a></li>
                </ul>
            </div>

            <div>
                <h3 class="font-display text-sm font-semibold uppercase tracking-wider text-gold-300">Grow with Agrivibe</h3>
                <p class="mt-4 text-sm text-leaf-200/80">Create a free account and unlock your digital farm.</p>
                <div class="mt-4 space-y-3">
                    <a href="{{ route('register') }}">
                        <x-ui.button variant="gold" size="md" class="w-full">Join Agrivibe</x-ui.button>
                    </a>
                    <a href="{{ route('contact') }}" class="flex justify-center text-sm font-medium text-leaf-100 underline decoration-leaf-700 underline-offset-4 hover:text-white">
                        Talk to our team
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-12 flex flex-col items-center justify-between gap-3 border-t border-white/10 pt-6 text-xs text-leaf-200/60 sm:flex-row">
            <p>&copy; {{ date('Y') }} {{ agri_setting('site_name', 'Agrivibe') }}. All rights reserved.</p>
            <div class="flex gap-5">
                <a href="{{ route('about') }}" class="hover:text-white">About</a>
                <a href="{{ route('faq.index') }}" class="hover:text-white">FAQ</a>
                <a href="{{ route('contact') }}" class="hover:text-white">Contact</a>
            </div>
        </div>
    </div>
</footer>