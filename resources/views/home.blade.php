<x-layouts.app title="{{ agri_setting('site_meta_title', 'Agrivibe — Smart Agribusiness Platform') }}">

    {{-- 3D Welcoming Hero Section --}}
    <section class="relative overflow-hidden bg-forest-950 pb-24 pt-12 lg:pt-16">
        {{-- Ambient 3D lighting & particle grid --}}
        <div class="pointer-events-none absolute inset-0">
            <div class="absolute -left-36 -top-36 h-[500px] w-[500px] rounded-full bg-emerald-500/20 blur-[130px]"></div>
            <div class="absolute right-0 top-1/4 h-[550px] w-[550px] rounded-full bg-gold-400/15 blur-[140px]"></div>
            <div class="absolute bottom-0 left-1/3 h-96 w-96 rounded-full bg-leaf-600/25 blur-[120px]"></div>
            <div class="absolute inset-0 opacity-[0.06]" style="background-image: radial-gradient(circle at 1.5px 1.5px, #4ade80 1.5px, transparent 0); background-size: 36px 36px;"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid items-center gap-12 lg:grid-cols-12">
                {{-- Left Column: Copy & Actions --}}
                <div class="text-center lg:col-span-7 lg:text-left">
                    <div class="inline-flex items-center gap-2 rounded-full border border-emerald-400/30 bg-emerald-950/70 px-4 py-1.5 text-xs font-semibold text-emerald-300 shadow-lg shadow-emerald-950/50 backdrop-blur">
                        <span class="flex h-2 w-2 rounded-full bg-emerald-400 animate-ping"></span>
                        <x-ui.icon name="sparkles" class="h-3.5 w-3.5 text-gold-400" />
                        Uganda's Next-Gen 3D Smart Agribusiness Ecosystem
                    </div>

                    <h1 class="mt-6 font-display text-4xl font-extrabold leading-tight tracking-tight text-white sm:text-5xl lg:text-6xl">
                        Smart Farming.<br>
                        Higher Yields.<br>
                        <span class="bg-gradient-to-r from-emerald-400 via-gold-300 to-emerald-200 bg-clip-text text-transparent">
                            Complete 3D Visibility.
                        </span>
                    </h1>

                    <p class="mt-6 max-w-2xl text-base leading-relaxed text-leaf-100/90 sm:text-lg">
                        The all-in-one digital companion for African farmers. Manage herds & flocks, track feed formulations, access certified veterinary doctors, monitor market prices, and trade directly — on smartphones, web, and offline via SMS/USSD.
                    </p>

                    {{-- Action CTA Row --}}
                    <div class="mt-8 flex flex-wrap items-center justify-center gap-4 lg:justify-start">
                        <x-ui.button href="{{ route('register') }}" variant="gold" size="lg" class="shadow-xl shadow-gold-500/20 transition-all hover:scale-105">
                            <x-ui.icon name="sparkles" class="h-4 w-4 mr-1.5" />
                            Create Free Farm Account
                        </x-ui.button>
                        <x-ui.button href="{{ route('knowledge.index') }}" variant="ghost" size="lg" class="border border-white/20 text-white hover:bg-white/10 hover:border-white/40">
                            Knowledge Centre
                        </x-ui.button>
                        <a href="#market-ticker" class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-gold-300 hover:text-white transition">
                            <span class="inline-block h-2 w-2 rounded-full bg-gold-400"></span> Live Market Prices ↓
                        </a>
                    </div>

                    {{-- 3D Interactive Search Bar --}}
                    <div class="mt-10 mx-auto max-w-xl lg:mx-0">
                        <form action="{{ route('search.index') }}" method="GET" class="relative flex items-center rounded-2xl border border-emerald-400/25 bg-forest-900/90 p-2 shadow-2xl shadow-black/50 backdrop-blur-xl">
                            <x-ui.icon name="search" class="ml-3 h-5 w-5 shrink-0 text-emerald-400" />
                            <input type="search" name="q" placeholder="Ask anything: vaccination dates, pig feeding, tilapia ponds, cow mastitis..."
                                class="w-full border-0 bg-transparent px-3 text-sm text-white placeholder:text-leaf-200/50 focus:outline-none focus:ring-0"
                                autocomplete="off" />
                            <x-ui.button variant="primary" size="md" type="submit" class="shrink-0 bg-emerald-600 hover:bg-emerald-500 shadow-md">
                                Search 3D Base
                            </x-ui.button>
                        </form>
                        {{-- Popular Tags --}}
                        <div class="mt-3 flex flex-wrap items-center gap-2 text-xs text-leaf-200/70 justify-center lg:justify-start">
                            <span class="font-medium text-gold-400">Trending:</span>
                            <a href="{{ route('search.index', ['q' => 'Broiler vaccination']) }}" class="rounded-lg bg-white/5 px-2.5 py-1 text-leaf-100 hover:bg-white/15 hover:text-white transition">Broiler vaccines</a>
                            <a href="{{ route('search.index', ['q' => 'Dairy cattle feeding']) }}" class="rounded-lg bg-white/5 px-2.5 py-1 text-leaf-100 hover:bg-white/15 hover:text-white transition">Dairy feeding</a>
                            <a href="{{ route('search.index', ['q' => 'Tilapia fingerlings']) }}" class="rounded-lg bg-white/5 px-2.5 py-1 text-leaf-100 hover:bg-white/15 hover:text-white transition">Fish ponds</a>
                            <a href="{{ route('search.index', ['q' => 'Boer goat breeding']) }}" class="rounded-lg bg-white/5 px-2.5 py-1 text-leaf-100 hover:bg-white/15 hover:text-white transition">Boer goats</a>
                        </div>
                    </div>
                </div>

                {{-- Right Column: 3D Isometric Agricultural Showcase Stage --}}
                <div class="lg:col-span-5 perspective-1000">
                    <div class="relative mx-auto max-w-md preserve-3d">
                        {{-- Central 3D Glass Master Hub --}}
                        <div class="relative rounded-3xl border border-emerald-400/30 bg-gradient-to-b from-forest-900/90 to-forest-950/95 p-6 shadow-2xl shadow-black/80 backdrop-blur-2xl transition-transform duration-500 hover:rotate-x-2 hover:rotate-y-2">
                            {{-- Top Header of 3D Hub --}}
                            <div class="flex items-center justify-between border-b border-white/10 pb-4">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500/20 text-emerald-400 ring-1 ring-emerald-400/30">
                                        🌱
                                    </span>
                                    <div>
                                        <h3 class="text-sm font-bold text-white">Nakato Family Farm Hub</h3>
                                        <p class="text-xs text-emerald-300/80">Kumi District · Connected Live</p>
                                    </div>
                                </div>
                                <span class="rounded-full bg-emerald-500/20 px-2.5 py-1 text-[11px] font-semibold text-emerald-300 ring-1 ring-emerald-400/40">
                                    ● 3D Sync Active
                                </span>
                            </div>

                            {{-- Live Farm Sector Metrics Grid --}}
                            <div class="mt-5 space-y-3">
                                {{-- Dairy Herd Telemetry --}}
                                <div class="group rounded-2xl border border-white/10 bg-white/5 p-3.5 backdrop-blur transition hover:bg-white/10 hover:border-emerald-400/40">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2.5">
                                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-500/20 text-lg">🐄</span>
                                            <div>
                                                <p class="text-xs font-semibold text-white">Dairy Herd (Friesian / Ankole)</p>
                                                <p class="text-[11px] text-leaf-200/70">18 Heads · Daily Milk Yield</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-bold text-gold-400">142 L/day</p>
                                            <span class="text-[10px] font-medium text-emerald-400">▲ +12% this week</span>
                                        </div>
                                    </div>
                                    {{-- Mini progress bar --}}
                                    <div class="mt-2.5 h-1.5 w-full overflow-hidden rounded-full bg-white/10">
                                        <div class="h-full rounded-full bg-gradient-to-r from-emerald-500 to-gold-400" style="width: 82%"></div>
                                    </div>
                                </div>

                                {{-- Poultry Flock Telemetry --}}
                                <div class="group rounded-2xl border border-white/10 bg-white/5 p-3.5 backdrop-blur transition hover:bg-white/10 hover:border-emerald-400/40">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2.5">
                                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-500/20 text-lg">🐔</span>
                                            <div>
                                                <p class="text-xs font-semibold text-white">Broiler Batch #B-04</p>
                                                <p class="text-[11px] text-leaf-200/70">500 Birds · Day 24 of 35</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-bold text-emerald-300">98.6%</p>
                                            <span class="text-[10px] font-medium text-leaf-200/70">Livability Rate</span>
                                        </div>
                                    </div>
                                    <div class="mt-2.5 flex items-center justify-between text-[11px] text-leaf-200/80">
                                        <span>Avg. Weight: <strong>1.42 kg</strong></span>
                                        <span>FCR: <strong class="text-gold-300">1.48</strong> (Target: 1.50)</span>
                                    </div>
                                </div>

                                {{-- Veterinary & Biosecurity Status --}}
                                <div class="group rounded-2xl border border-white/10 bg-white/5 p-3.5 backdrop-blur transition hover:bg-white/10 hover:border-emerald-400/40">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2.5">
                                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-cyan-500/20 text-lg">🛡️</span>
                                            <div>
                                                <p class="text-xs font-semibold text-white">Health & Biosecurity</p>
                                                <p class="text-[11px] text-leaf-200/70">Dr. Moses Okello (Assigned Vet)</p>
                                            </div>
                                        </div>
                                        <span class="rounded-md bg-emerald-500/20 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-emerald-300">
                                            Vaccinated
                                        </span>
                                    </div>
                                    <p class="mt-2 text-[11px] text-emerald-300/90 flex items-center gap-1.5">
                                        <x-ui.icon name="check" class="h-3.5 w-3.5 text-emerald-400" />
                                        ECF & Newcastle booster verified · 0 days withdrawal
                                    </p>
                                </div>
                            </div>

                            {{-- Bottom Quick Action in 3D Card --}}
                            <div class="mt-5 pt-4 border-t border-white/10 flex items-center justify-between text-xs">
                                <span class="text-leaf-200/70">Offline Access Enabled:</span>
                                <span class="font-mono font-semibold text-gold-300 bg-black/40 px-2.5 py-1 rounded-lg border border-gold-400/30">
                                    *284*40# USSD
                                </span>
                            </div>
                        </div>

                        {{-- Floating 3D Satellite Badge 1 (Top-Left) --}}
                        <div class="absolute -left-8 -top-6 animate-float-slow rounded-2xl border border-emerald-400/40 bg-forest-900/90 p-3 shadow-xl backdrop-blur-xl">
                            <div class="flex items-center gap-2.5">
                                <span class="text-2xl">🐟</span>
                                <div>
                                    <p class="text-[11px] font-bold text-white">Cage Aquaculture</p>
                                    <p class="text-[10px] text-emerald-300">DO 6.8 mg/L · pH 7.2</p>
                                </div>
                            </div>
                        </div>

                        {{-- Floating 3D Satellite Badge 2 (Bottom-Right) --}}
                        <div class="absolute -bottom-8 -right-6 animate-float-reverse rounded-2xl border border-gold-400/40 bg-forest-900/90 p-3 shadow-xl backdrop-blur-xl">
                            <div class="flex items-center gap-2.5">
                                <span class="text-2xl">💰</span>
                                <div>
                                    <p class="text-[11px] font-bold text-gold-300">+28.4% Net Margin</p>
                                    <p class="text-[10px] text-leaf-200/80">Batch ROI Real-time</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 4 Big 3D Metric Highlights --}}
            <div class="mx-auto mt-16 grid max-w-5xl grid-cols-2 gap-4 sm:grid-cols-4">
                <div class="card-3d rounded-2xl border border-white/15 bg-white/5 p-4 text-center backdrop-blur-md">
                    <p class="text-2xl font-black text-gold-400 sm:text-3xl">{{ $stats['articles'] }}</p>
                    <p class="mt-1 text-xs font-semibold uppercase tracking-wider text-leaf-200">Verified Guides</p>
                    <p class="text-[11px] text-leaf-200/60 mt-0.5">Reviewed by Vets</p>
                </div>
                <div class="card-3d rounded-2xl border border-white/15 bg-white/5 p-4 text-center backdrop-blur-md">
                    <p class="text-2xl font-black text-emerald-400 sm:text-3xl">{{ $stats['categories'] }}</p>
                    <p class="mt-1 text-xs font-semibold uppercase tracking-wider text-leaf-200">Farm Sectors</p>
                    <p class="text-[11px] text-leaf-200/60 mt-0.5">Livestock, Fish, Crops</p>
                </div>
                <div class="card-3d rounded-2xl border border-white/15 bg-white/5 p-4 text-center backdrop-blur-md">
                    <p class="text-2xl font-black text-cyan-300 sm:text-3xl">{{ $stats['farms'] }}</p>
                    <p class="mt-1 text-xs font-semibold uppercase tracking-wider text-leaf-200">Registered Farms</p>
                    <p class="text-[11px] text-leaf-200/60 mt-0.5">Connected in Uganda</p>
                </div>
                <div class="card-3d rounded-2xl border border-white/15 bg-white/5 p-4 text-center backdrop-blur-md">
                    <p class="text-2xl font-black text-amber-300 sm:text-3xl">{{ $stats['species'] }}+</p>
                    <p class="mt-1 text-xs font-semibold uppercase tracking-wider text-leaf-200">Breeds & Species</p>
                    <p class="text-[11px] text-leaf-200/60 mt-0.5">Full Genetic Profiles</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Live Agricultural Market Price Ticker Ribbon --}}
    <section id="market-ticker" class="relative z-20 border-y border-sand-300/80 bg-forest-900 py-3 text-white overflow-hidden shadow-inner">
        <div class="mx-auto flex max-w-7xl items-center px-4">
            <div class="flex items-center gap-2 shrink-0 pr-4 border-r border-white/20">
                <span class="flex h-2.5 w-2.5 rounded-full bg-emerald-400 animate-ping"></span>
                <span class="text-xs font-bold uppercase tracking-wider text-gold-300">Live Market Prices</span>
            </div>
            <div class="overflow-hidden flex-1 ml-4">
                <div class="flex animate-marquee gap-8 whitespace-nowrap">
                    @foreach (array_merge($marketPrices, $marketPrices) as $item)
                        <div class="inline-flex items-center gap-2 text-xs">
                            <span class="font-bold text-leaf-100">{{ $item['commodity'] }}</span>
                            <span class="text-leaf-300/70">({{ $item['market'] }}):</span>
                            <span class="font-mono font-extrabold text-gold-300">UGX {{ number_format($item['price']) }}/{{ $item['unit'] }}</span>
                            <span class="text-[11px] font-bold {{ $item['up'] ? 'text-emerald-400' : 'text-red-400' }}">
                                {{ $item['change'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Interactive 3D Farm Ecosystem Explorer --}}
    <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8" x-data="{
        activeSector: 'livestock',
        sectors: {
            livestock: {
                title: 'Livestock & Ruminants',
                desc: 'Dairy & beef cattle, Boer goats, Dorper sheep, and intensive piggery management.',
                stats: 'Friesian, Ankole, Boer, Large White',
                roi: '32% - 48% Annual Margin',
                feed: 'Silage, Hay, High-Protein Dairy Meal',
                vaccine: 'ECF dipping, FMD bivalent, Anthrax spore'
            },
            poultry: {
                title: 'Poultry, Eggs & Brooding',
                desc: 'Layers egg collection, broiler meat batch tracking, incubation cycles, and brooding temperature control.',
                stats: 'Kuroiler, Cobb 500, Lohmann Brown, Turkeys',
                roi: '22% - 35% Cycle Margin',
                feed: 'Starter, Grower, Finisher, Layers Mash',
                vaccine: 'Marek\'s (Day 1), Newcastle (Day 7), Gumboro (Day 14)'
            },
            aquaculture: {
                title: 'Aquaculture & Cage Farming',
                desc: 'Tilapia and African catfish cage culture, earthen pond fertilisation, dissolved oxygen monitoring, and hatchery fingerlings.',
                stats: 'Nile Tilapia, African Catfish',
                roi: '40% - 55% Harvest Margin',
                feed: 'Extruded floating pellets (32-45% Crude Protein)',
                vaccine: 'Water quality parameter management'
            },
            crops: {
                title: 'High-Value Cash & Feed Crops',
                desc: 'Maize grain, beans, Hass avocados, cashew nuts, pasture management, and drip irrigation scheduling.',
                stats: 'Bazooka Maize, Nambale, Hass Avocado, Robusta',
                roi: '50% - 120% Seasonal Return',
                feed: 'NPK, Urea, Organic Compost, Foliar sprays',
                vaccine: 'Fall armyworm bio-controls, Rust prevention'
            },
            vet: {
                title: 'Veterinary Telemedicine & Health',
                desc: 'Direct consultations with certified veterinary surgeons, withdrawal period alerts, and clinical prescription delivery.',
                stats: 'Registered VAs, Mobile field clinics',
                roi: 'Reduces mortality by up to 75%',
                feed: 'Mineral licks, Multivitamins, Dewormers',
                vaccine: 'Mandatory withdrawal period enforcement'
            },
            finance: {
                title: 'Smart Agribusiness Accounting',
                desc: 'Cost-per-bird, cost-per-litre, feeding conversion ratio (FCR), cash flow statements, and break-even calculators.',
                stats: 'Automated P&L, Export to PDF/Excel',
                roi: 'Full visibility on every UGX invested',
                feed: 'Input inventory tracking & reorder alerts',
                vaccine: 'Medical expense allocation per batch'
            }
        }
    }">
        <div class="text-center">
            <span class="inline-block rounded-full bg-leaf-100 px-3 py-1 text-xs font-bold uppercase tracking-wider text-leaf-800">
                Connected Agricultural Sectors
            </span>
            <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-forest-900 sm:text-4xl">
                One Unified Platform for Every Farming Discipline
            </h2>
            <p class="mx-auto mt-3 max-w-2xl text-base text-leaf-800/70">
                Explore how AgriVibe delivers tailored digital management, clinical guidance, and profitability tools for your specific agribusiness sector.
            </p>
        </div>

        {{-- 3D Pill Selector Tabs --}}
        <div class="mt-10 flex flex-wrap items-center justify-center gap-2">
            <button @click="activeSector = 'livestock'" :class="activeSector === 'livestock' ? 'bg-forest-900 text-white shadow-lg ring-2 ring-emerald-400' : 'bg-white text-leaf-900 hover:bg-sand-100'"
                class="flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold transition-all">
                <span>🐄</span> Livestock & Dairy
            </button>
            <button @click="activeSector = 'poultry'" :class="activeSector === 'poultry' ? 'bg-forest-900 text-white shadow-lg ring-2 ring-emerald-400' : 'bg-white text-leaf-900 hover:bg-sand-100'"
                class="flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold transition-all">
                <span>🐔</span> Poultry & Flocks
            </button>
            <button @click="activeSector = 'aquaculture'" :class="activeSector === 'aquaculture' ? 'bg-forest-900 text-white shadow-lg ring-2 ring-emerald-400' : 'bg-white text-leaf-900 hover:bg-sand-100'"
                class="flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold transition-all">
                <span>🐟</span> Aquaculture Ponds
            </button>
            <button @click="activeSector = 'crops'" :class="activeSector === 'crops' ? 'bg-forest-900 text-white shadow-lg ring-2 ring-emerald-400' : 'bg-white text-leaf-900 hover:bg-sand-100'"
                class="flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold transition-all">
                <span>🌽</span> Cash & Feed Crops
            </button>
            <button @click="activeSector = 'vet'" :class="activeSector === 'vet' ? 'bg-forest-900 text-white shadow-lg ring-2 ring-emerald-400' : 'bg-white text-leaf-900 hover:bg-sand-100'"
                class="flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold transition-all">
                <span>🩺</span> Vet Telemedicine
            </button>
            <button @click="activeSector = 'finance'" :class="activeSector === 'finance' ? 'bg-forest-900 text-white shadow-lg ring-2 ring-emerald-400' : 'bg-white text-leaf-900 hover:bg-sand-100'"
                class="flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold transition-all">
                <span>💰</span> Farm Finances
            </button>
        </div>

        {{-- Dynamic 3D Sector Display Card --}}
        <div class="mt-8 rounded-3xl border border-sand-200 bg-white p-6 sm:p-10 shadow-xl shadow-leaf-900/5 card-3d">
            <div class="grid gap-8 lg:grid-cols-12 items-center">
                <div class="lg:col-span-7">
                    <span class="text-xs font-bold uppercase tracking-wider text-leaf-600">Sector Architecture</span>
                    <h3 class="mt-2 font-display text-2xl font-bold text-forest-900 sm:text-3xl" x-text="sectors[activeSector].title"></h3>
                    <p class="mt-3 text-base leading-relaxed text-leaf-800/80" x-text="sectors[activeSector].desc"></p>

                    <div class="mt-6 grid grid-cols-2 gap-4">
                        <div class="rounded-xl border border-sand-200 bg-sand-25 p-4">
                            <p class="text-xs font-semibold text-leaf-600 uppercase">Recommended Breeds/Varieties</p>
                            <p class="mt-1 font-display text-sm font-bold text-leaf-900" x-text="sectors[activeSector].stats"></p>
                        </div>
                        <div class="rounded-xl border border-sand-200 bg-sand-25 p-4">
                            <p class="text-xs font-semibold text-gold-600 uppercase">Typical Profit Margin</p>
                            <p class="mt-1 font-display text-sm font-bold text-leaf-900" x-text="sectors[activeSector].roi"></p>
                        </div>
                        <div class="rounded-xl border border-sand-200 bg-sand-25 p-4">
                            <p class="text-xs font-semibold text-leaf-600 uppercase">Optimal Feeding</p>
                            <p class="mt-1 font-display text-xs font-medium text-leaf-800" x-text="sectors[activeSector].feed"></p>
                        </div>
                        <div class="rounded-xl border border-sand-200 bg-sand-25 p-4">
                            <p class="text-xs font-semibold text-emerald-700 uppercase">Health & Vaccines</p>
                            <p class="mt-1 font-display text-xs font-medium text-leaf-800" x-text="sectors[activeSector].vaccine"></p>
                        </div>
                    </div>

                    <div class="mt-8 flex items-center gap-4">
                        <x-ui.button href="{{ route('register') }}" variant="primary" size="md">
                            Start Tracking This Sector
                        </x-ui.button>
                        <a href="{{ route('knowledge.index') }}" class="text-sm font-semibold text-leaf-700 hover:text-leaf-900 flex items-center gap-1">
                            Read detailed guides <x-ui.icon name="arrow-right" class="h-4 w-4" />
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <div class="rounded-2xl bg-gradient-to-br from-forest-900 to-forest-950 p-6 text-white shadow-2xl">
                        <div class="flex items-center justify-between border-b border-white/10 pb-3">
                            <span class="text-xs font-semibold text-gold-400 uppercase tracking-wider">AgriVibe Smart Rations Engine</span>
                            <span class="text-[10px] bg-emerald-500/20 text-emerald-300 px-2 py-0.5 rounded-full">Automated FCR</span>
                        </div>
                        <div class="mt-4 space-y-3 text-xs">
                            <div class="flex justify-between items-center py-2 border-b border-white/5">
                                <span class="text-leaf-200/80">Individual Animal RFID / Ear-Tag:</span>
                                <span class="font-bold text-white">Supported</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-white/5">
                                <span class="text-leaf-200/80">Batch Mortality & Livability:</span>
                                <span class="font-bold text-emerald-400">Daily Tracking</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-white/5">
                                <span class="text-leaf-200/80">Withdrawal Period Safety Warning:</span>
                                <span class="font-bold text-gold-400">Automated Alert</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-white/5">
                                <span class="text-leaf-200/80">Lifetime Cost Calculation:</span>
                                <span class="font-bold text-white">Per Bird / Litre / Kg</span>
                            </div>
                            <div class="flex justify-between items-center py-2">
                                <span class="text-leaf-200/80">SMS Reminders Gateway:</span>
                                <span class="font-bold text-cyan-300">Live Africa's Talking</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Interactive 3D Farm Profitability & Rations Calculator Preview --}}
    <section class="bg-sand-100/70 py-20 border-y border-sand-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8" x-data="{
            enterprise: 'broiler',
            quantity: 500,
            durationWeeks: 5,
            feedPricePerBag: 135000,
            salePricePerUnit: 14000,
            get totalBags() {
                if (this.enterprise === 'broiler') return Math.ceil((this.quantity * 3.5) / 50);
                if (this.enterprise === 'layer') return Math.ceil((this.quantity * 0.12 * 30) / 50);
                return Math.ceil((this.quantity * 0.8 * 30) / 50);
            },
            get feedCost() {
                return this.totalBags * this.feedPricePerBag;
            },
            get chickCost() {
                return this.enterprise === 'broiler' ? this.quantity * 2500 : (this.enterprise === 'layer' ? this.quantity * 3500 : this.quantity * 500);
            },
            get healthLabourCost() {
                return this.quantity * 800;
            },
            get totalProductionCost() {
                return this.feedCost + this.chickCost + this.healthLabourCost;
            },
            get expectedRevenue() {
                if (this.enterprise === 'broiler') return (this.quantity * 0.97) * this.salePricePerUnit;
                if (this.enterprise === 'layer') return (this.quantity * 0.85 * 30 / 30) * 13500;
                return (this.quantity * 0.95) * 8500;
            },
            get netProfit() {
                return this.expectedRevenue - this.totalProductionCost;
            },
            get costPerUnit() {
                return Math.round(this.totalProductionCost / (this.quantity * 0.97));
            }
        }">
            <div class="mx-auto max-w-3xl text-center">
                <span class="rounded-full bg-gold-100 px-3 py-1 text-xs font-bold uppercase tracking-wider text-gold-800">
                    Smart Agribusiness Tools
                </span>
                <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-forest-900 sm:text-4xl">
                    Instant 3D Farm Profitability & Rations Calculator
                </h2>
                <p class="mt-2 text-base text-leaf-800/70">
                    Estimate feed requirements, total production costs, break-even prices, and projected net profits before spending a single shilling.
                </p>
            </div>

            <div class="mt-12 grid gap-8 lg:grid-cols-12 items-start">
                {{-- Input controls --}}
                <div class="rounded-3xl border border-sand-200 bg-white p-6 sm:p-8 shadow-lg lg:col-span-6 card-3d-subtle">
                    <h3 class="font-display text-lg font-bold text-forest-900">Configure Your Batch</h3>

                    <div class="mt-6 space-y-5">
                        <div>
                            <label class="block text-xs font-semibold text-leaf-800 uppercase tracking-wider">Enterprise Type</label>
                            <div class="mt-2 grid grid-cols-3 gap-2">
                                <button type="button" @click="enterprise = 'broiler'; salePricePerUnit = 14000; quantity = 500"
                                    :class="enterprise === 'broiler' ? 'border-emerald-500 bg-emerald-50 text-emerald-900 font-bold ring-1 ring-emerald-500' : 'border-sand-200 bg-sand-25 text-leaf-800'"
                                    class="rounded-xl border p-2.5 text-xs text-center transition">
                                    🐓 Broilers
                                </button>
                                <button type="button" @click="enterprise = 'layer'; salePricePerUnit = 13500; quantity = 300"
                                    :class="enterprise === 'layer' ? 'border-emerald-500 bg-emerald-50 text-emerald-900 font-bold ring-1 ring-emerald-500' : 'border-sand-200 bg-sand-25 text-leaf-800'"
                                    class="rounded-xl border p-2.5 text-xs text-center transition">
                                    🥚 Layers
                                </button>
                                <button type="button" @click="enterprise = 'fish'; salePricePerUnit = 9500; quantity = 1000"
                                    :class="enterprise === 'fish' ? 'border-emerald-500 bg-emerald-50 text-emerald-900 font-bold ring-1 ring-emerald-500' : 'border-sand-200 bg-sand-25 text-leaf-800'"
                                    class="rounded-xl border p-2.5 text-xs text-center transition">
                                    🐟 Tilapia
                                </button>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-xs font-semibold text-leaf-900">
                                <span>Batch Stocking Quantity:</span>
                                <span class="font-bold text-emerald-700" x-text="quantity + ' Units'"></span>
                            </div>
                            <input type="range" min="100" max="5000" step="50" x-model.number="quantity"
                                class="mt-2 w-full accent-emerald-600" />
                        </div>

                        <div>
                            <div class="flex justify-between text-xs font-semibold text-leaf-900">
                                <span>Feed Price Per 50kg Bag (UGX):</span>
                                <span class="font-mono text-leaf-700" x-text="feedPricePerBag.toLocaleString()"></span>
                            </div>
                            <input type="range" min="90000" max="220000" step="5000" x-model.number="feedPricePerBag"
                                class="mt-2 w-full accent-emerald-600" />
                        </div>

                        <div>
                            <div class="flex justify-between text-xs font-semibold text-leaf-900">
                                <span>Expected Selling Price / Unit (UGX):</span>
                                <span class="font-mono text-leaf-700" x-text="salePricePerUnit.toLocaleString()"></span>
                            </div>
                            <input type="range" min="8000" max="25000" step="500" x-model.number="salePricePerUnit"
                                class="mt-2 w-full accent-emerald-600" />
                        </div>
                    </div>
                </div>

                {{-- 3D Output Card --}}
                <div class="rounded-3xl border border-emerald-400/40 bg-forest-950 p-6 sm:p-8 text-white shadow-2xl lg:col-span-6 card-3d">
                    <div class="flex items-center justify-between border-b border-white/10 pb-4">
                        <span class="text-xs font-bold uppercase tracking-wider text-gold-300">Projected Financial Breakdown</span>
                        <span class="rounded-full bg-emerald-500/20 px-2.5 py-0.5 text-xs font-semibold text-emerald-300">
                            Based on East African Norms
                        </span>
                    </div>

                    <div class="mt-6 grid grid-cols-2 gap-4">
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                            <p class="text-xs text-leaf-200/70">Feed Required</p>
                            <p class="mt-1 font-display text-xl font-bold text-gold-300" x-text="totalBags + ' Bags (50kg)'"></p>
                            <p class="text-[11px] text-leaf-200/60 mt-1 font-mono" x-text="'UGX ' + feedCost.toLocaleString()"></p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                            <p class="text-xs text-leaf-200/70">Cost Per Marketable Unit</p>
                            <p class="mt-1 font-display text-xl font-bold text-cyan-300" x-text="'UGX ' + costPerUnit.toLocaleString()"></p>
                            <p class="text-[11px] text-leaf-200/60 mt-1">Break-even price</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                            <p class="text-xs text-leaf-200/70">Total Production Cost</p>
                            <p class="mt-1 font-display text-lg font-bold text-white font-mono" x-text="'UGX ' + totalProductionCost.toLocaleString()"></p>
                            <p class="text-[11px] text-leaf-200/60 mt-1">Chicks, Feed & Health</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                            <p class="text-xs text-leaf-200/70">Expected Gross Revenue</p>
                            <p class="mt-1 font-display text-lg font-bold text-gold-400 font-mono" x-text="'UGX ' + Math.round(expectedRevenue).toLocaleString()"></p>
                            <p class="text-[11px] text-leaf-200/60 mt-1">At 97% survival rate</p>
                        </div>
                    </div>

                    {{-- Big Projected Net Profit Callout --}}
                    <div class="mt-6 rounded-2xl border border-emerald-400/40 bg-gradient-to-r from-emerald-900/60 to-emerald-950/80 p-5 text-center">
                        <p class="text-xs font-semibold uppercase tracking-wider text-emerald-300">Estimated Net Profit</p>
                        <p class="mt-1 font-display text-3xl font-black text-emerald-400 font-mono"
                            x-text="'UGX ' + Math.round(netProfit).toLocaleString()">
                        </p>
                        <p class="mt-1 text-xs text-leaf-200/80">
                            Return on Investment: <strong class="text-gold-300" x-text="Math.round((netProfit / totalProductionCost) * 100) + '%'"></strong>
                        </p>
                    </div>

                    <div class="mt-6 text-center">
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-xl bg-gold-400 px-6 py-2.5 text-xs font-bold text-forest-950 shadow-lg hover:bg-gold-300 transition">
                            Unlock Detailed Batch Accounting On Your Farm →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Knowledge Categories Grid --}}
    <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="mb-10 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-leaf-600">Agricultural Knowledge Base</p>
                <h2 class="mt-2 font-display text-3xl font-bold tracking-tight text-forest-900">Practical Field Guides</h2>
                <p class="mt-2 max-w-2xl text-sm text-leaf-800/70">Actionable, step-by-step guides developed for East African farmers and reviewed by veterinary specialists.</p>
            </div>
            <a href="{{ route('knowledge.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-leaf-600 hover:text-leaf-800">
                Browse all guides <x-ui.icon name="arrow-right" class="h-4 w-4" />
            </a>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($categories as $category)
                <a href="{{ route('knowledge.category', $category) }}" class="card-3d group relative flex items-center gap-4 overflow-hidden rounded-2xl border border-sand-200 bg-white p-5 transition hover:border-leaf-400 hover:shadow-xl">
                    <span class="inline-flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-leaf-100 text-2xl shadow-inner">{{ $category->icon }}</span>
                    <span class="min-w-0 flex-1">
                        <span class="block font-display text-base font-semibold text-leaf-900 group-hover:text-leaf-700">{{ $category->name }}</span>
                        <span class="mt-0.5 block truncate text-xs text-leaf-800/60">{{ $category->articles_count }} actionable guides</span>
                    </span>
                    <x-ui.icon name="chevron-right" class="h-4 w-4 shrink-0 text-leaf-800/30 transition group-hover:translate-x-1 group-hover:text-leaf-600" />
                </a>
            @endforeach
        </div>
    </section>

    {{-- Featured Guides --}}
    @if ($featuredArticles->isNotEmpty())
        <section class="bg-white py-20 border-t border-sand-200">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-10 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-leaf-600">Featured Agronomy & Veterinary Papers</p>
                        <h2 class="mt-2 font-display text-3xl font-bold tracking-tight text-forest-900">Recommended Reading</h2>
                    </div>
                </div>

                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($featuredArticles as $article)
                        <a href="{{ route('knowledge.article', ['category' => $article->category->slug, 'article' => $article]) }}" class="card-3d group flex flex-col overflow-hidden rounded-2xl border border-sand-200 bg-sand-25 transition hover:border-leaf-300 hover:shadow-xl">
                            <div class="flex h-36 items-center justify-center bg-gradient-to-br from-emerald-100 to-leaf-200 p-4">
                                <span class="text-5xl drop-shadow-md">{{ $article->category?->icon }}</span>
                            </div>
                            <div class="flex flex-1 flex-col p-5">
                                <span class="text-xs font-bold uppercase tracking-wide text-leaf-600">{{ $article->category?->name }}</span>
                                <h3 class="mt-2 font-display text-base font-semibold leading-snug text-leaf-900 group-hover:text-leaf-600">{{ $article->title }}</h3>
                                <p class="mt-2 line-clamp-2 flex-1 text-xs leading-relaxed text-leaf-800/70">{{ $article->excerpt }}</p>
                                <div class="mt-4 flex items-center justify-between text-xs text-leaf-800/50 border-t border-sand-200 pt-3">
                                    <span>{{ $article->published_at?->format('M j, Y') }}</span>
                                    <span class="inline-flex items-center gap-1 text-leaf-700 font-medium"><x-ui.icon name="clock" class="h-3.5 w-3.5" /> {{ $article->views }} views</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Offline USSD & SMS Inclusion Showcase --}}
    <section class="bg-forest-900 py-20 text-white relative overflow-hidden">
        <div class="pointer-events-none absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 1px 1px, #fff 1px, transparent 0); background-size: 28px 28px;"></div>
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-12 items-center">
                <div class="lg:col-span-7">
                    <span class="inline-block rounded-full bg-gold-400/20 px-3 py-1 text-xs font-bold uppercase tracking-wider text-gold-300">
                        Universal Digital Inclusion
                    </span>
                    <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                        No Smartphone? No Internet?<br>
                        <span class="text-gold-400">AgriVibe Works Everywhere via SMS & USSD.</span>
                    </h2>
                    <p class="mt-4 text-base leading-relaxed text-leaf-100/80">
                        We believe every smallholder farmer deserves instant agricultural intelligence. Even on a basic 2G feature phone, any registered telephone number can check prices, trigger vaccination reminders, and request veterinary help.
                    </p>

                    <div class="mt-8 grid grid-cols-2 gap-4">
                        <div class="rounded-xl border border-white/10 bg-white/5 p-4">
                            <p class="font-mono text-sm font-bold text-gold-300">PRICE MAIZE</p>
                            <p class="mt-1 text-xs text-leaf-100/70">Returns current wholesale and retail prices in nearest market.</p>
                        </div>
                        <div class="rounded-xl border border-white/10 bg-white/5 p-4">
                            <p class="font-mono text-sm font-bold text-gold-300">VET KUMI</p>
                            <p class="mt-1 text-xs text-leaf-100/70">Connects directly to verified local veterinarian on standby.</p>
                        </div>
                        <div class="rounded-xl border border-white/10 bg-white/5 p-4">
                            <p class="font-mono text-sm font-bold text-gold-300">VACCINE CHICKEN</p>
                            <p class="mt-1 text-xs text-leaf-100/70">Delivers upcoming disease schedule and administration route.</p>
                        </div>
                        <div class="rounded-xl border border-white/10 bg-white/5 p-4">
                            <p class="font-mono text-sm font-bold text-gold-300">*284*40# USSD</p>
                            <p class="mt-1 text-xs text-leaf-100/70">Interactive menu available in English, Luganda, Swahili, and Ateso.</p>
                        </div>
                    </div>
                </div>

                {{-- Visual 3D Phone Screen Mockup --}}
                <div class="lg:col-span-5 perspective-1000 flex justify-center">
                    <div class="w-72 rounded-[40px] border-4 border-sand-400/40 bg-black p-4 shadow-2xl shadow-black card-3d">
                        <div class="mx-auto h-4 w-28 rounded-full bg-sand-700/60 mb-4"></div>
                        <div class="rounded-2xl bg-forest-950 p-4 border border-emerald-500/30 text-white font-mono text-xs space-y-3">
                            <div class="text-gold-300 font-bold border-b border-white/10 pb-2">
                                AgriVibe SMS Gateway
                            </div>
                            <div class="rounded-lg bg-white/10 p-2 text-leaf-200">
                                <strong>YOU:</strong> PRICE EGGS
                            </div>
                            <div class="rounded-lg bg-emerald-950/80 p-2.5 text-emerald-300 border border-emerald-500/30">
                                <strong>AGRIVIBE:</strong><br>
                                Kampala Wholesale: UGX 13,500/tray.<br>
                                Jinja: UGX 14,000/tray.<br>
                                Reply 1 to post sale.<br>
                                Reply 2 for buyers.
                            </div>
                            <div class="text-[10px] text-leaf-400 pt-2 text-center">
                                ● Africa's Talking Gateway Live
                            </div>
                        </div>
                        <div class="mx-auto mt-4 h-8 w-8 rounded-full border border-white/20 bg-white/5"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Farmer Community Voices & Testimonials --}}
    <section class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="text-center">
            <span class="rounded-full bg-leaf-100 px-3 py-1 text-xs font-bold uppercase tracking-wider text-leaf-800">
                Farmer Success Stories
            </span>
            <h2 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-forest-900 sm:text-4xl">
                Trusted by Farmers Across East Africa
            </h2>
        </div>

        <div class="mt-12 grid gap-6 sm:grid-cols-3">
            <div class="card-3d rounded-2xl border border-sand-200 bg-white p-6 shadow-md">
                <div class="flex items-center gap-3">
                    <span class="flex h-12 w-12 items-center justify-center rounded-full bg-emerald-100 text-lg font-bold text-emerald-800">SN</span>
                    <div>
                        <h4 class="font-display font-bold text-leaf-900">Sarah Nakato</h4>
                        <p class="text-xs text-leaf-600">Smallholder Farmer · Kumi</p>
                    </div>
                </div>
                <p class="mt-4 text-sm leading-relaxed text-leaf-800/80">
                    "From just 2 goats to 60 healthy head today! AgriVibe's vaccination calendar and automated withdrawal warnings stopped medication mistakes completely."
                </p>
                <div class="mt-4 flex text-gold-400 text-xs">★★★★★</div>
            </div>

            <div class="card-3d rounded-2xl border border-sand-200 bg-white p-6 shadow-md">
                <div class="flex items-center gap-3">
                    <span class="flex h-12 w-12 items-center justify-center rounded-full bg-amber-100 text-lg font-bold text-amber-800">DM</span>
                    <div>
                        <h4 class="font-display font-bold text-leaf-900">David Mugisha</h4>
                        <p class="text-xs text-leaf-600">Dairy Rancher · Mbarara</p>
                    </div>
                </div>
                <p class="mt-4 text-sm leading-relaxed text-leaf-800/80">
                    "Tracking daily milk production per cow helped us identify mastitis early. Our average yield climbed by 24% in only 3 months of using AgriVibe."
                </p>
                <div class="mt-4 flex text-gold-400 text-xs">★★★★★</div>
            </div>

            <div class="card-3d rounded-2xl border border-sand-200 bg-white p-6 shadow-md">
                <div class="flex items-center gap-3">
                    <span class="flex h-12 w-12 items-center justify-center rounded-full bg-cyan-100 text-lg font-bold text-cyan-800">PO</span>
                    <div>
                        <h4 class="font-display font-bold text-leaf-900">Peter Otim</h4>
                        <p class="text-xs text-leaf-600">Aquaculture Producer · Gulu</p>
                    </div>
                </div>
                <p class="mt-4 text-sm leading-relaxed text-leaf-800/80">
                    "Finding reliable fingerling suppliers and selling tilapia direct to buyers without middlemen has revolutionized our fish farm margins."
                </p>
                <div class="mt-4 flex text-gold-400 text-xs">★★★★★</div>
            </div>
        </div>
    </section>

    {{-- Final CTA --}}
    <section class="mx-auto max-w-7xl px-4 pb-20 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden rounded-3xl bg-forest-950 px-6 py-16 text-center sm:px-16 border border-emerald-400/30 shadow-2xl">
            <div class="pointer-events-none absolute -right-20 -top-20 h-72 w-72 rounded-full bg-emerald-500/20 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-24 -left-16 h-72 w-72 rounded-full bg-gold-400/20 blur-3xl"></div>
            <div class="relative">
                <h2 class="mx-auto max-w-2xl font-display text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                    Join the Connected Digital Farming Revolution
                </h2>
                <p class="mx-auto mt-4 max-w-xl text-sm leading-relaxed text-leaf-100/85 sm:text-base">
                    Register your farm in 2 minutes. Free for individual farmers, scalable for commercial enterprises and agricultural cooperatives.
                </p>
                <div class="mt-8 flex flex-col items-center justify-center gap-4 sm:flex-row">
                    <x-ui.button href="{{ route('register') }}" variant="gold" size="lg" class="shadow-xl shadow-gold-500/25">
                        Create Free Farm Account
                    </x-ui.button>
                    <x-ui.button href="{{ route('about') }}" variant="ghost" size="lg" class="text-white hover:bg-white/10 border border-white/20">
                        Explore System Architecture
                    </x-ui.button>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>