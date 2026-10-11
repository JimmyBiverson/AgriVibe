<x-layouts.app title="Contact us">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-3xl text-center">
            <h1 class="font-display text-4xl font-bold tracking-tight text-forest-900">Talk to our team</h1>
            <p class="mt-3 text-base text-leaf-800/70">Questions, feedback or partnership ideas — we'd love to hear from you.</p>
        </div>

        <div class="mx-auto mt-12 grid max-w-4xl gap-6 sm:grid-cols-3">
            @foreach([
                ['mail', 'Email us', agri_setting('contact_email', 'hello@agrivibe.com'), 'We reply within 1–2 working days'],
                ['phone', 'Call us', agri_setting('contact_phone', '0700 000 000'), 'Mon–Fri, 8am – 6pm EAT'],
                ['pin', 'Visit us', agri_setting('contact_address', 'Kampala, Uganda'), "Let's meet in person"],
            ] as [$icon, $title, $value, $subtitle])
                <a href="{{ $icon === 'mail' ? 'mailto:'.agri_setting('contact_email', 'hello@agrivibe.com') : ($icon === 'phone' ? 'tel:+256'.agri_setting('contact_phone', '0700000000') : '#') }}" class="group rounded-2xl border border-sand-200 bg-white p-6 text-center transition hover:-translate-y-0.5 hover:border-leaf-300 hover:shadow-lg hover:shadow-leaf-900/5">
                    <span class="inline-flex h-11 w-11 items-center justify-center rounded-xl bg-leaf-100 text-leaf-700">
                        <x-ui.icon :name="$icon" class="h-5 w-5" />
                    </span>
                    <h2 class="mt-4 font-display text-base font-semibold text-leaf-900">{{ $title }}</h2>
                    <p class="mt-1 text-sm font-medium text-leaf-700">{{ $value }}</p>
                    <p class="mt-1 text-xs text-leaf-800/60">{{ $subtitle }}</p>
                </a>
            @endforeach
        </div>

        <div class="mx-auto mt-14 max-w-2xl rounded-2xl border border-sand-200 bg-white p-8">
            <h2 class="font-display text-xl font-bold tracking-tight text-forest-900">Prefer email?</h2>
            <p class="mt-2 text-sm text-leaf-800/70">For support requests, include your account email (if registered) and as much detail as possible.</p>
            <div class="mt-5 flex items-center gap-3 rounded-xl bg-leaf-50 p-4 text-sm">
                <x-ui.icon name="mail" class="h-5 w-5 shrink-0 text-leaf-600" />
                <a href="mailto:{{ agri_setting('contact_email', 'hello@agrivibe.com') }}" class="font-semibold text-leaf-700 hover:underline">
                    {{ agri_setting('contact_email', 'hello@agrivibe.com') }}
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>