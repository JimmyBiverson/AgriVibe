<x-layouts.app title="AgriVibe Dashboard — {{ $user->name }}">
    {{-- Header Banner with 3D Depth --}}
    <div class="relative overflow-hidden bg-forest-950 text-white border-b border-sand-300/30">
        <div class="pointer-events-none absolute -left-20 -top-20 h-64 w-64 rounded-full bg-emerald-500/20 blur-3xl"></div>
        <div class="pointer-events-none absolute -right-20 -bottom-20 h-64 w-64 rounded-full bg-gold-400/15 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                {{-- User Profile & Farm Context --}}
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <span class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-emerald-500 to-leaf-700 text-2xl font-black text-white shadow-xl ring-2 ring-emerald-400/40">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </span>
                        <span class="absolute -bottom-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-emerald-500 text-[10px] text-white ring-2 ring-forest-950">
                            ✓
                        </span>
                    </div>
                    <div>
                        <div class="flex items-center gap-2.5">
                            <h1 class="font-display text-2xl font-bold tracking-tight text-white">{{ $user->name }}</h1>
                            <span class="rounded-full bg-emerald-500/20 px-2.5 py-0.5 text-xs font-semibold text-emerald-300 ring-1 ring-emerald-400/30">
                                {{ ucfirst($role) }}
                            </span>
                        </div>
                        <p class="mt-1 text-xs text-leaf-200/80">
                            {{ $farm ? $farm->name . ' · ' . $farm->district : 'AgriVibe Network' }} · {{ $user->email }}
                        </p>
                    </div>
                </div>

                {{-- Role Switcher Bar (For Easy Exploration) --}}
                <div class="flex flex-wrap items-center gap-2">
                    @if ($farms->isNotEmpty())
                        <x-user-farm-switcher :farms="$farms" :current-farm="$farm" :user="$user" />
                    @endif
                    <span class="text-xs text-leaf-200/60 mr-1 hidden sm:inline">Role View:</span>
                    <a href="{{ route('dashboard', ['role' => 'farmer']) }}"
                        class="rounded-xl px-3 py-1.5 text-xs font-semibold transition {{ $role === 'farmer' ? 'bg-emerald-500 text-forest-950 font-bold shadow-md' : 'bg-white/10 text-leaf-100 hover:bg-white/20' }}">
                        👨‍🌾 Farmer
                    </a>
                    <a href="{{ route('dashboard', ['role' => 'veterinarian']) }}"
                        class="rounded-xl px-3 py-1.5 text-xs font-semibold transition {{ $role === 'veterinarian' ? 'bg-emerald-500 text-forest-950 font-bold shadow-md' : 'bg-white/10 text-leaf-100 hover:bg-white/20' }}">
                        🩺 Veterinarian
                    </a>
                    <a href="{{ route('dashboard', ['role' => 'buyer']) }}"
                        class="rounded-xl px-3 py-1.5 text-xs font-semibold transition {{ $role === 'buyer' ? 'bg-emerald-500 text-forest-950 font-bold shadow-md' : 'bg-white/10 text-leaf-100 hover:bg-white/20' }}">
                        🛒 Buyer
                    </a>
                    <a href="{{ route('dashboard', ['role' => 'supplier']) }}"
                        class="rounded-xl px-3 py-1.5 text-xs font-semibold transition {{ $role === 'supplier' ? 'bg-emerald-500 text-forest-950 font-bold shadow-md' : 'bg-white/10 text-leaf-100 hover:bg-white/20' }}">
                        📦 Supplier
                    </a>
                    <a href="{{ route('dashboard', ['role' => 'trainer']) }}"
                        class="rounded-xl px-3 py-1.5 text-xs font-semibold transition {{ $role === 'trainer' ? 'bg-emerald-500 text-forest-950 font-bold shadow-md' : 'bg-white/10 text-leaf-100 hover:bg-white/20' }}">
                        🎓 Trainer
                    </a>

                    @if ($user->isStaff())
                        <a href="{{ url('/admin') }}" class="ml-2 rounded-xl bg-gold-400 px-3 py-1.5 text-xs font-bold text-forest-950 hover:bg-gold-300 shadow-md">
                            ⚡ Admin Panel
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8 space-y-8" x-data="{
        activeTab: 'animals',
        showActionModal: false,
        actionType: 'milk'
    }">
        {{-- Mandatory Antibiotic/Medicine Withdrawal Alert Banner --}}
        @if ($withdrawalAlert)
            <div class="rounded-2xl border-2 border-amber-500/50 bg-gradient-to-r from-amber-950/90 via-forest-950/95 to-amber-950/90 p-4 text-white shadow-xl flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-500 text-forest-950 text-xl font-bold animate-pulse">
                        ⚠️
                    </span>
                    <div>
                        <h4 class="text-sm font-bold text-amber-300">ACTIVE WITHDRAWAL PERIOD WARNING · CONSUMER SAFETY</h4>
                        <p class="text-xs text-leaf-100/90 mt-0.5">
                            <strong>{{ $withdrawalAlert->title }}</strong>: Administered {{ $withdrawalAlert->administered_date->format('M d, Y') }}.
                            Milk and meat from <strong>{{ $withdrawalAlert->animal?->name ?? 'Tagged Animal' }} ({{ $withdrawalAlert->animal?->tag_number }})</strong>
                            cannot be sold or consumed until <span class="text-gold-300 font-bold underline">{{ $withdrawalAlert->safe_consumption_date->format('d M Y') }}</span> ({{ $withdrawalAlert->safe_consumption_date->diffForHumans() }}).
                        </p>
                    </div>
                </div>
                <span class="shrink-0 rounded-lg bg-amber-500/20 px-3 py-1 text-xs font-bold text-amber-300 border border-amber-500/40">
                    HOLD DISPATCH
                </span>
            </div>
        @endif

        {{-- 4 Big 3D Metric Stat Cards --}}
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="card-3d rounded-2xl border border-sand-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-leaf-600">Total Herd & Flocks</span>
                    <span class="rounded-lg bg-leaf-100 p-2 text-lg">🐄</span>
                </div>
                <p class="mt-3 font-display text-2xl font-black text-leaf-950">
                    {{ $animals->count() }} <span class="text-sm font-normal text-leaf-600">head</span> + {{ $batches->sum('current_quantity') }} <span class="text-sm font-normal text-leaf-600">birds/fish</span>
                </p>
                <p class="mt-1 text-xs text-emerald-600 font-semibold">● 100% Biosecurity Compliance</p>
            </div>

            <div class="card-3d rounded-2xl border border-sand-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-leaf-600">Today's Milk & Eggs</span>
                    <span class="rounded-lg bg-amber-100 p-2 text-lg">🥛</span>
                </div>
                <p class="mt-3 font-display text-2xl font-black text-leaf-950">
                    142.5 <span class="text-sm font-normal text-leaf-600">L</span> · 260 <span class="text-sm font-normal text-leaf-600">Eggs</span>
                </p>
                <p class="mt-1 text-xs text-leaf-600 font-medium">8 Trays packed · 6 cracked (retained)</p>
            </div>

            <div class="card-3d rounded-2xl border border-sand-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-leaf-600">Net Cash Flow (Week)</span>
                    <span class="rounded-lg bg-emerald-100 p-2 text-lg">💰</span>
                </div>
                <p class="mt-3 font-display text-2xl font-black text-emerald-700 font-mono">
                    +{{ number_format($netProfit) }} <span class="text-xs font-sans font-bold text-leaf-600">UGX</span>
                </p>
                <p class="mt-1 text-xs text-emerald-600 font-semibold">▲ +48.9% Gross margin</p>
            </div>

            <div class="card-3d rounded-2xl border border-sand-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-leaf-600">Farm Chores & Tasks</span>
                    <span class="rounded-lg bg-cyan-100 p-2 text-lg">📋</span>
                </div>
                <p class="mt-3 font-display text-2xl font-black text-leaf-950">
                    {{ $tasks->count() }} <span class="text-sm font-normal text-leaf-600">pending</span>
                </p>
                <p class="mt-1 text-xs text-amber-700 font-semibold">⚠️ 2 Urgent chores due today</p>
            </div>
        </div>

        {{-- Quick Actions --}}
        <section class="space-y-3">
            <div class="flex items-center justify-between">
                <h2 class="font-display text-lg font-bold text-forest-900">Quick Actions</h2>
                <p class="text-xs text-leaf-600">Jump straight into daily farm work</p>
            </div>
            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-6">
                <x-ui.quick-action icon="plus" title="Register Animal" description="Add to herd" :href="url('/admin/animals/create')" color="emerald" />
                <x-ui.quick-action icon="list" title="Add Batch" description="Flock or pond" :href="url('/admin/animal-batches/create')" color="cyan" />
                <x-ui.quick-action icon="beaker" title="Record Production" description="Milk / eggs / fish" :href="url('/admin/production-records/create')" color="gold" />
                <x-ui.quick-action icon="cash" title="Log Finance" description="Income or expense" :href="url('/admin/farm-finances/create')" color="emerald" />
                <x-ui.quick-action icon="calendar" title="Create Task" description="Assign a chore" :href="url('/admin/farm-tasks/create')" color="amber" />
                <x-ui.quick-action icon="bag" title="New Listing" description="Sell on market" :href="url('/admin/marketplace-items/create')" color="emerald" />
            </div>
        </section>

        {{-- Alerts & Recent Activity --}}
        <section class="grid gap-6 lg:grid-cols-3">
            <div class="lg:col-span-2 space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="font-display text-lg font-bold text-forest-900">Alerts &amp; Reminders</h2>
                    @if ($alerts->isEmpty())
                        <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">All clear</span>
                    @endif
                </div>
                <div class="space-y-3">
                    @forelse ($alerts as $alert)
                        @php
                            $tone = match($alert['level']) {
                                'danger' => 'border-berry-300 bg-berry-50 text-berry-900',
                                'warning' => 'border-gold-300 bg-gold-50 text-gold-900',
                                default => 'border-sky-300 bg-sky-50 text-sky-900',
                            };
                            $iconTone = match($alert['level']) {
                                'danger' => 'bg-berry-500 text-white',
                                'warning' => 'bg-gold-500 text-white',
                                default => 'bg-sky-500 text-white',
                            };
                        @endphp
                        <div class="flex items-start gap-3 rounded-2xl border p-4 {{ $tone }}">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl {{ $iconTone }}">
                                <x-ui.icon :name="$alert['icon']" class="h-4.5 w-4.5" />
                            </span>
                            <div class="flex-1">
                                <p class="text-sm font-bold">{{ $alert['title'] }}</p>
                                <p class="mt-0.5 text-xs opacity-90">{{ $alert['description'] }}</p>
                            </div>
                            @if ($alert['href'])
                                <a href="{{ $alert['href'] }}" class="shrink-0 text-xs font-semibold underline underline-offset-2">View</a>
                            @endif
                        </div>
                    @empty
                        <div class="rounded-2xl border border-sand-200 bg-white p-6 text-center">
                            <span class="mx-auto flex h-10 w-10 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
                                <x-ui.icon name="check-circle" class="h-5 w-5" />
                            </span>
                            <p class="mt-2 text-sm font-semibold text-forest-900">No alerts right now</p>
                            <p class="text-xs text-leaf-600">Your vaccination, chore and safety reminders will appear here.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <x-ui.activity-timeline :items="$recentActivity" empty-message="Record production, finance or health events to see activity here." />
        </section>

        {{-- Conditional View based on Role --}}
        @if ($role === 'farmer')
            {{-- Farmer Navigation Tabs --}}
            <div class="flex flex-wrap items-center gap-2 border-b border-sand-200 pb-3">
                <button @click="activeTab = 'animals'" :class="activeTab === 'animals' ? 'bg-forest-900 text-white font-bold shadow' : 'bg-white text-leaf-800 hover:bg-sand-100'"
                    class="rounded-xl px-4 py-2 text-xs font-semibold transition">
                    🐄 Livestock & Herds ({{ $animals->count() }})
                </button>
                <button @click="activeTab = 'batches'" :class="activeTab === 'batches' ? 'bg-forest-900 text-white font-bold shadow' : 'bg-white text-leaf-800 hover:bg-sand-100'"
                    class="rounded-xl px-4 py-2 text-xs font-semibold transition">
                    🐔 Poultry Flocks & Ponds ({{ $batches->count() }})
                </button>
                <button @click="activeTab = 'production'" :class="activeTab === 'production' ? 'bg-forest-900 text-white font-bold shadow' : 'bg-white text-leaf-800 hover:bg-sand-100'"
                    class="rounded-xl px-4 py-2 text-xs font-semibold transition">
                    🥛 Production Records
                </button>
                <button @click="activeTab = 'finances'" :class="activeTab === 'finances' ? 'bg-forest-900 text-white font-bold shadow' : 'bg-white text-leaf-800 hover:bg-sand-100'"
                    class="rounded-xl px-4 py-2 text-xs font-semibold transition">
                    💵 Financial Ledger & ROI
                </button>
                <button @click="activeTab = 'tasks'" :class="activeTab === 'tasks' ? 'bg-forest-900 text-white font-bold shadow' : 'bg-white text-leaf-800 hover:bg-sand-100'"
                    class="rounded-xl px-4 py-2 text-xs font-semibold transition">
                    🗓️ Daily Farm Chores ({{ $tasks->count() }})
                </button>
            </div>

            {{-- Tab 1: Individual Livestock (Cattle & Goats) --}}
            <div x-show="activeTab === 'animals'" class="space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-display text-lg font-bold text-forest-900">Registered Herd Inventory</h3>
                        <p class="text-xs text-leaf-700">Track individual animal ear tags, RFID codes, lactation status, and market valuation.</p>
                    </div>
                    <button type="button" @click="showActionModal = true; actionType = 'animal'" class="rounded-xl bg-forest-900 px-4 py-2 text-xs font-bold text-white hover:bg-forest-800 shadow">
                        + Register New Animal
                    </button>
                </div>

                <div class="overflow-hidden rounded-2xl border border-sand-200 bg-white shadow-sm">
                    <table class="min-w-full divide-y divide-sand-200 text-left text-xs">
                        <thead class="bg-sand-50 font-semibold text-leaf-900">
                            <tr>
                                <th class="p-4">Ear Tag / RFID</th>
                                <th class="p-4">Name & Breed</th>
                                <th class="p-4">Species</th>
                                <th class="p-4">Weight</th>
                                <th class="p-4">Status</th>
                                <th class="p-4">Housing Shed</th>
                                <th class="p-4 text-right">Est. Value (UGX)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-sand-100 text-leaf-800">
                            @foreach ($animals as $animal)
                                <tr class="hover:bg-sand-25 transition">
                                    <td class="p-4 font-mono font-bold text-forest-900">
                                        {{ $animal->tag_number }}
                                    </td>
                                    <td class="p-4 font-semibold text-leaf-900">
                                        {{ $animal->name }}
                                        <span class="block text-[11px] font-normal text-leaf-600">{{ $animal->breed?->name ?? 'Cross-breed' }}</span>
                                    </td>
                                    <td class="p-4">
                                        <span class="capitalize">{{ $animal->species?->name ?? 'Animal' }}</span>
                                    </td>
                                    <td class="p-4 font-mono">
                                        {{ $animal->weight_kg }} kg
                                    </td>
                                    <td class="p-4">
                                        <span class="rounded-full px-2 py-0.5 text-[10px] font-bold uppercase {{ $animal->health_status === 'healthy' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $animal->health_status }}
                                        </span>
                                        <span class="block text-[10px] text-leaf-600 capitalize mt-0.5">{{ $animal->reproductive_status }}</span>
                                    </td>
                                    <td class="p-4 text-leaf-600">
                                        {{ $animal->housing_location }}
                                    </td>
                                    <td class="p-4 text-right font-mono font-bold text-forest-900">
                                        {{ number_format($animal->estimated_value) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Tab 2: Poultry Flocks & Ponds --}}
            <div x-show="activeTab === 'batches'" class="space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-display text-lg font-bold text-forest-900">Batch Flocks & Aquaculture Ponds</h3>
                        <p class="text-xs text-leaf-700">Track broiler cycles, layer egg production batches, mortality rates, and feed conversion ratios.</p>
                    </div>
                </div>

                <div class="grid gap-6 md:grid-cols-3">
                    @foreach ($batches as $batch)
                        <div class="card-3d rounded-2xl border border-sand-200 bg-white p-6 shadow-sm">
                            <div class="flex items-center justify-between border-b border-sand-100 pb-3">
                                <div>
                                    <span class="font-mono text-xs font-bold text-leaf-600">{{ $batch->batch_code }}</span>
                                    <h4 class="font-display text-sm font-bold text-forest-900">{{ $batch->name }}</h4>
                                </div>
                                <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-bold text-emerald-800 uppercase">
                                    {{ $batch->status }}
                                </span>
                            </div>

                            <div class="mt-4 space-y-2 text-xs">
                                <div class="flex justify-between">
                                    <span class="text-leaf-600">Current Stock:</span>
                                    <span class="font-bold text-forest-900">{{ number_format($batch->current_quantity) }} / {{ number_format($batch->initial_quantity) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-leaf-600">Livability Rate:</span>
                                    <span class="font-bold text-emerald-700">{{ $batch->livability_percent }}%</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-leaf-600">Avg. Weight:</span>
                                    <span class="font-bold text-forest-900">{{ $batch->average_weight_kg }} kg</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-leaf-600">Target FCR:</span>
                                    <span class="font-bold text-gold-700">{{ $batch->target_fcr }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-leaf-600">Housing Unit:</span>
                                    <span class="text-forest-900">{{ $batch->housing_unit }}</span>
                                </div>
                            </div>

                            <div class="mt-4 pt-3 border-t border-sand-100">
                                <p class="text-[11px] text-leaf-600 italic">{{ $batch->notes }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Tab 3: Daily Production Logs --}}
            <div x-show="activeTab === 'production'" class="space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-display text-lg font-bold text-forest-900">Daily Milk & Eggs Log</h3>
                        <p class="text-xs text-leaf-700">Audit production volumes, cracked eggs, home-use retention, and farm-gate sales.</p>
                    </div>
                </div>

                <div class="overflow-hidden rounded-2xl border border-sand-200 bg-white shadow-sm">
                    <table class="min-w-full divide-y divide-sand-200 text-left text-xs">
                        <thead class="bg-sand-50 font-semibold text-leaf-900">
                            <tr>
                                <th class="p-4">Date</th>
                                <th class="p-4">Commodity</th>
                                <th class="p-4">Total Output</th>
                                <th class="p-4">Damaged / Cracked</th>
                                <th class="p-4">Home Retained</th>
                                <th class="p-4">Sold Qty</th>
                                <th class="p-4 text-right">Unit Price</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-sand-100 text-leaf-800">
                            @foreach ($productionRecords as $prod)
                                <tr class="hover:bg-sand-25 transition">
                                    <td class="p-4 font-mono font-semibold text-forest-900">{{ $prod->record_date->format('d M Y') }}</td>
                                    <td class="p-4 font-bold capitalize text-leaf-900">{{ $prod->product_type }}</td>
                                    <td class="p-4 font-mono font-bold text-emerald-700">{{ $prod->quantity }} {{ $prod->unit }}</td>
                                    <td class="p-4 font-mono text-red-600">{{ $prod->cracked_damaged_qty }}</td>
                                    <td class="p-4 font-mono text-leaf-600">{{ $prod->retained_home_use }} {{ $prod->unit }}</td>
                                    <td class="p-4 font-mono font-bold text-forest-900">{{ $prod->sold_quantity }} {{ $prod->unit }}</td>
                                    <td class="p-4 text-right font-mono font-bold text-forest-900">UGX {{ number_format($prod->unit_selling_price) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Tab 4: Farm Finances --}}
            <div x-show="activeTab === 'finances'" class="space-y-6">
                <div class="grid gap-4 sm:grid-cols-3">
                    <div class="rounded-2xl border border-sand-200 bg-emerald-50 p-5">
                        <p class="text-xs font-semibold text-emerald-800 uppercase">Total Income</p>
                        <p class="mt-2 font-display text-2xl font-black text-emerald-900 font-mono">UGX {{ number_format($totalIncome) }}</p>
                    </div>
                    <div class="rounded-2xl border border-sand-200 bg-red-50 p-5">
                        <p class="text-xs font-semibold text-red-800 uppercase">Total Expenses</p>
                        <p class="mt-2 font-display text-2xl font-black text-red-900 font-mono">UGX {{ number_format($totalExpense) }}</p>
                    </div>
                    <div class="rounded-2xl border border-sand-200 bg-forest-900 text-white p-5">
                        <p class="text-xs font-semibold text-gold-300 uppercase">Net Farm Operating Profit</p>
                        <p class="mt-2 font-display text-2xl font-black text-emerald-400 font-mono">UGX {{ number_format($netProfit) }}</p>
                    </div>
                </div>

                <div class="overflow-hidden rounded-2xl border border-sand-200 bg-white shadow-sm">
                    <div class="p-4 border-b border-sand-100 font-display font-bold text-forest-900 text-sm">Recent Ledger Entries</div>
                    <table class="min-w-full divide-y divide-sand-200 text-left text-xs">
                        <thead class="bg-sand-50 font-semibold text-leaf-900">
                            <tr>
                                <th class="p-4">Date</th>
                                <th class="p-4">Type</th>
                                <th class="p-4">Category</th>
                                <th class="p-4">Description</th>
                                <th class="p-4 text-right">Amount (UGX)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-sand-100 text-leaf-800">
                            @foreach ($recentFinances as $txn)
                                <tr class="hover:bg-sand-25 transition">
                                    <td class="p-4 font-mono">{{ $txn->transaction_date->format('d M Y') }}</td>
                                    <td class="p-4">
                                        <span class="rounded-full px-2 py-0.5 text-[10px] font-bold uppercase {{ $txn->type === 'income' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $txn->type }}
                                        </span>
                                    </td>
                                    <td class="p-4 capitalize font-semibold">{{ $txn->category }}</td>
                                    <td class="p-4 text-leaf-700">{{ $txn->description }}</td>
                                    <td class="p-4 text-right font-mono font-bold {{ $txn->type === 'income' ? 'text-emerald-700' : 'text-red-600' }}">
                                        {{ $txn->type === 'income' ? '+' : '-' }} {{ number_format($txn->amount) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Tab 5: Farm Tasks --}}
            <div x-show="activeTab === 'tasks'" class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-display text-lg font-bold text-forest-900">Farm Chores & Reminders</h3>
                        <p class="text-xs text-leaf-700">Automated SMS alerts dispatched to farm staff for each pending chore.</p>
                    </div>
                </div>

                <div class="grid gap-3 sm:grid-cols-2">
                    @foreach ($tasks as $task)
                        <div class="rounded-2xl border border-sand-200 bg-white p-4 shadow-sm flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" class="h-4 w-4 rounded border-sand-300 text-emerald-600 focus:ring-emerald-500" />
                                <div>
                                    <h4 class="text-xs font-bold text-forest-900">{{ $task->title }}</h4>
                                    <p class="text-[11px] text-leaf-600">Due: {{ $task->due_date->format('d M Y') }} · Priority: <span class="font-semibold uppercase {{ $task->priority === 'urgent' ? 'text-red-600' : 'text-leaf-800' }}">{{ $task->priority }}</span></p>
                                </div>
                            </div>
                            <span class="text-xs bg-sand-100 text-leaf-700 px-2 py-1 rounded-lg capitalize">{{ $task->category }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

        @elseif ($role === 'veterinarian')
            {{-- Veterinarian Workspace --}}
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-display text-xl font-bold text-forest-900">Clinical Triage & Telemedicine Consultations</h3>
                        <p class="text-xs text-leaf-700">Manage patient farm calls, emergency field requests, and medical histories.</p>
                    </div>
                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-800">
                        License: VET-UG-2024-8891 (Active)
                    </span>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($vetAppointments as $appt)
                        <div class="card-3d rounded-2xl border border-sand-200 bg-white p-5 shadow-sm">
                            <div class="flex items-center justify-between border-b border-sand-100 pb-3">
                                <span class="rounded-md bg-leaf-100 px-2 py-0.5 text-[10px] font-bold uppercase text-leaf-800">
                                    {{ str_replace('_', ' ', $appt->service_type) }}
                                </span>
                                <span class="text-xs font-mono font-bold text-forest-900">
                                    UGX {{ number_format($appt->fee_ugx) }}
                                </span>
                            </div>
                            <h4 class="mt-3 font-display text-sm font-bold text-forest-900">{{ $appt->farmer?->name }} ({{ $appt->farm?->name }})</h4>
                            <p class="mt-1 text-xs text-leaf-600">Patient: <strong>{{ $appt->animal?->name ?? 'Herd Case' }}</strong> ({{ $appt->animal?->tag_number ?? 'General' }})</p>
                            <p class="mt-2 text-xs text-leaf-800 bg-sand-25 p-2.5 rounded-xl border border-sand-100">
                                <em>"{{ $appt->symptoms_description }}"</em>
                            </p>
                            <div class="mt-4 flex items-center justify-between border-t border-sand-100 pt-3 text-xs">
                                <span class="text-leaf-600">{{ $appt->scheduled_at->format('d M, H:i') }}</span>
                                <button type="button" class="rounded-lg bg-emerald-600 px-3 py-1 text-xs font-bold text-white hover:bg-emerald-500">
                                    Launch Video Call
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        @elseif ($role === 'buyer' || $role === 'supplier')
            {{-- Marketplace Buyer / Supplier Workspace --}}
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-display text-xl font-bold text-forest-900">Agribusiness Marketplace & Direct Trading</h3>
                        <p class="text-xs text-leaf-700">Source verified farm produce, compare prices, or dispatch inputs directly.</p>
                    </div>
                </div>

                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($marketplaceItems as $item)
                        <div class="card-3d rounded-2xl border border-sand-200 bg-white p-5 shadow-sm">
                            <span class="rounded-full bg-sand-100 px-2 py-0.5 text-[10px] font-bold text-leaf-700 uppercase">
                                {{ $item->category }}
                            </span>
                            <h4 class="mt-2 font-display text-sm font-bold text-forest-900">{{ $item->title }}</h4>
                            <p class="mt-1 text-xs text-leaf-600">Seller: {{ $item->seller?->name }} · {{ $item->location }}</p>
                            <div class="mt-4 flex items-center justify-between border-t border-sand-100 pt-3">
                                <div>
                                    <span class="text-[10px] text-leaf-500">Price:</span>
                                    <p class="font-mono text-sm font-black text-forest-900">UGX {{ number_format($item->price) }} / {{ $item->unit }}</p>
                                </div>
                                <button type="button" class="rounded-xl bg-forest-900 px-3 py-1.5 text-xs font-bold text-white hover:bg-forest-800">
                                    Place Order
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        @else
            {{-- Trainer Workspace --}}
            <div class="rounded-2xl border border-sand-200 bg-white p-8 text-center space-y-4">
                <span class="text-4xl">🎓</span>
                <h3 class="font-display text-xl font-bold text-forest-900">AgriVibe Farmer Training Academy</h3>
                <p class="text-sm text-leaf-700 max-w-xl mx-auto">
                    Publish practical curriculum modules, veterinary best practices, and deliver practical farmer certifications across East Africa.
                </p>
                <div class="pt-4">
                    <a href="{{ route('knowledge.index') }}" class="rounded-xl bg-forest-900 px-6 py-2.5 text-xs font-bold text-white hover:bg-forest-800">
                        Manage Academy Courses →
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>