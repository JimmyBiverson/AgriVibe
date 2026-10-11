<x-layouts.app title="My Dashboard">
    <div class="border-b border-sand-200 bg-forest-950">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-4">
                    <span class="inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-white/10 text-xl font-bold text-white">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </span>
                    <div>
                        <h1 class="font-display text-2xl font-bold tracking-tight text-white">Karibu, {{ $user->name }}!</h1>
                        <p class="mt-1 text-sm text-leaf-100/70">
                            {{ config("agrivibe.account_types.{$user->account_type}.label", ucfirst($user->account_type)) }}
                            · {{ $user->email }}
                        </p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    @if ($user->isStaff())
                        <x-ui.button href="{{ url('/admin') }}" variant="gold" size="md">
                            <x-ui.icon name="shield" class="h-4 w-4" /> Admin panel
                        </x-ui.button>
                    @endif
                    <x-ui.button href="{{ route('knowledge.index') }}" variant="ghost" size="md" class="text-white hover:bg-white/10">
                        Knowledge Centre
                    </x-ui.button>
                </div>
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        @if (! $user->hasVerifiedEmail())
            <x-ui.alert type="warning" class="mb-8">
                <p class="flex items-center justify-between gap-3">
                    <span><strong>Your email is not verified yet.</strong> Verify to secure your account and regain full access.</span>
                    <a href="{{ route('verification.notice') }}" class="shrink-0 font-semibold underline underline-offset-4">Verify now</a>
                </p>
            </x-ui.alert>
        @endif

        @if ($user->status === 'pending')
            <x-ui.alert type="info" class="mb-8">
                <strong>Account under review.</strong> Professional accounts are approved by our team. We'll email you once it's ready.
            </x-ui.alert>
        @endif

        <div class="grid gap-4 sm:grid-cols-3">
            <x-ui.stat label="Farm memberships" :value="$farmCount" icon="briefcase" foot="Farms you belong to" />
            <x-ui.stat label="Farms you own" :value="$ownedFarms" icon="home" foot="Farms registered under your name" />
            <x-ui.stat label="Account status" :value="ucfirst($user->status)" icon="shield" foot="Last login {{ $user->last_login_at?->diffForHumans() ?? '—' }}" />
        </div>

        <div class="mt-10 grid gap-8 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <x-ui.card>
                    <h2 class="font-display text-lg font-semibold text-leaf-900">My digital farm</h2>
                    <p class="mt-1 text-sm text-leaf-800/60">Your farm records — animals, batches, vaccination, feeding and production — are being activated in this phase of the build.</p>

                    @if ($farms->isEmpty())
                        <div class="mt-5">
                            <x-ui.empty-state
                                icon="home"
                                title="No farm registered yet"
                                description="Soon you'll be able to create a farm, add animals and start tracking your production."
                            />
                        </div>
                    @else
                        <div class="mt-5 grid gap-4 sm:grid-cols-2">
                            @foreach ($farms as $farm)
                                <div class="rounded-xl border border-sand-200 bg-sand-25 p-5">
                                    <div class="flex items-center justify-between">
                                        <p class="font-display text-base font-semibold text-leaf-900">{{ $farm->name }}</p>
                                        <x-ui.badge color="green" size="sm">{{ $farm->status }}</x-ui.badge>
                                    </div>
                                    <p class="mt-1 text-sm text-leaf-800/70">{{ $farm->enterpriseType?->name ?? 'Mixed farm' }} · {{ $farm->is_active ? 'Active' : 'Inactive' }}</p>
                                    <p class="mt-3 text-xs text-leaf-800/50">Member since {{ $farm->created_at?->format('M Y') }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </x-ui.card>
            </div>

            <aside class="space-y-6">
                <div class="rounded-2xl border border-sand-200 bg-white p-6">
                    <h2 class="font-display text-sm font-semibold uppercase tracking-wider text-leaf-900">Coming in this build</h2>
                    <ul class="mt-4 space-y-3">
                        @foreach ([
                            ['tools', 'Digital farm & records'],
                            ['heart-pulse', 'Animal health & vaccination'],
                            ['bag', 'Marketplace'],
                            ['pin', 'Find a vet'],
                            ['academy', 'Training & courses'],
                            ['cash', 'Market prices'],
                            ['signal', 'SMS reminders'],
                        ] as [$icon, $label])
                            <li class="flex items-center gap-3 text-sm text-leaf-800/80">
                                <x-ui.icon :name="$icon" class="h-4 w-4 text-leaf-600" />
                                {{ $label }}
                                <span class="ml-auto text-[10px] font-semibold uppercase tracking-wide text-gold-600">Soon</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="rounded-2xl bg-forest-900 p-6 text-center">
                    <h2 class="font-display text-base font-semibold text-white">Need reassurance?</h2>
                    <p class="mt-2 text-sm text-leaf-100/70">Read our FAQs or talk to our team.</p>
                    <div class="mt-4 flex justify-center gap-3">
                        <x-ui.button href="{{ route('faq.index') }}" variant="ghost" size="sm" class="text-white hover:bg-white/10">FAQ</x-ui.button>
                        <x-ui.button href="{{ route('contact') }}" variant="ghost" size="sm" class="text-white hover:bg-white/10">Contact</x-ui.button>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</x-layouts.app>