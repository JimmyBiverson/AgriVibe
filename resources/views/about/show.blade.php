<x-layouts.app title="About Agrivibe">
    <div class="relative overflow-hidden bg-forest-950">
        <div class="pointer-events-none absolute inset-0">
            <div class="absolute -right-24 -top-20 h-80 w-80 rounded-full bg-leaf-700/30 blur-3xl"></div>
        </div>
        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-3xl text-center">
                <p class="text-xs font-semibold uppercase tracking-wider text-gold-400">Our story</p>
                <h1 class="mt-3 font-display text-4xl font-bold tracking-tight text-white sm:text-5xl">Grow stronger, together</h1>
                <p class="mx-auto mt-5 max-w-2xl text-base leading-relaxed text-leaf-100/80 sm:text-lg">
                    Agrivibe is a connected farming platform built for East Africa. We bring practical knowledge, record-keeping tools, animal health services, markets and a community of experts to every farmer — on any phone.
                </p>
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid gap-8 lg:grid-cols-3">
            <div class="space-y-8 lg:col-span-2">
                <div>
                    <h2 class="font-display text-2xl font-bold tracking-tight text-forest-900">Why we exist</h2>
                    <div class="mt-4 space-y-4 text-sm leading-relaxed text-leaf-900 sm:text-base">
                        <p>Smallholder farmers produce most of East Africa's food, yet they rarely have access to the same information, tools and markets as large agribusinesses. A missed vaccination, an unfair farm-gate price or an unplanned outbreak can set a household back a whole season.</p>
                        <p>Agrivibe closes that gap — one farm at a time. From step-by-step guides in your language, to digital farm records, vet consultation, fair market prices and a community of experts, we give every farmer the means to make confident decisions.</p>
                    </div>
                </div>

                <div>
                    <h2 class="font-display text-2xl font-bold tracking-tight text-forest-900">What we're building</h2>
                    <div class="mt-5 grid gap-4 sm:grid-cols-2">
                        @foreach ([
                            ['book', 'Knowledge Centre', 'Practical guides on livestock, poultry, fish, crops and farm management.'],
                            ['tools', 'Digital Farm', 'Animals, batches, vaccination, feeding, production and financial records.'],
                            ['heart-pulse', 'Animal Health', 'Find vets, track diseases, follow vaccination schedules and get reminders.'],
                            ['bag', 'Marketplace', 'List and trade produce, livestock and inputs with verified partners.'],
                            ['cash', 'Market Prices', 'Fair, up-to-date prices from markets across Uganda.'],
                            ['academy', 'Training', 'Short practical courses that turn knowledge into income.'],
                            ['community', 'Community', 'Farmer groups, forums and cooperative buying power.'],
                            ['signal', 'SMS & USSD', 'Essential services reachable from any phone, even offline.'],
                        ] as [$icon, $title, $desc])
                            <div class="rounded-xl border border-sand-200 bg-white p-5">
                                <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-leaf-100 text-leaf-700">
                                    <x-ui.icon :name="$icon" class="h-5 w-5" />
                                </span>
                                <h3 class="mt-3 font-display text-base font-semibold text-leaf-900">{{ $title }}</h3>
                                <p class="mt-1 text-sm leading-relaxed text-leaf-800/70">{{ $desc }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <aside class="space-y-6">
                <div class="rounded-2xl border border-sand-200 bg-white p-6">
                    <h3 class="font-display text-sm font-semibold uppercase tracking-wider text-leaf-900">Our values</h3>
                    <ul class="mt-4 space-y-4">
                        @foreach([
                            ['leaf', 'Farmer first', 'Every feature must help the farmer earn or learn more.'],
                            ['shield', 'Trusted advice', 'Health and finance guidance is verified and honest.'],
                            ['signal', 'Works offline', 'SMS and USSD keep the platform reachable on any phone.'],
                            ['users', 'Community-powered', 'We grow by helping our members grow.'],
                        ] as [$icon, $title, $desc])
                            <li class="flex items-start gap-3">
                                <span class="inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-leaf-100 text-leaf-700">
                                    <x-ui.icon :name="$icon" class="h-4 w-4" />
                                </span>
                                <span>
                                    <strong class="block text-sm font-semibold text-leaf-900">{{ $title }}</strong>
                                    <span class="mt-0.5 block text-xs leading-relaxed text-leaf-800/70">{{ $desc }}</span>
                                </span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="rounded-2xl bg-forest-900 p-6 text-center">
                    <h3 class="font-display text-lg font-semibold text-white">Join the community</h3>
                    <p class="mt-2 text-sm text-leaf-100/70">Create a free account and start your digital farm.</p>
                    <x-ui.button href="{{ route('register') }}" variant="gold" size="sm" class="mt-4">Get started</x-ui.button>
                </div>
            </aside>
        </div>
    </div>
</x-layouts.app>