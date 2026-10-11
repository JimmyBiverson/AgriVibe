<x-filament-widgets::widget>
    <div class="relative overflow-hidden rounded-2xl border border-emerald-500/30 bg-gradient-to-br from-slate-950 via-slate-900 to-emerald-950/40 p-6 text-white shadow-2xl">
        {{-- Ambient Glow Accents --}}
        <div class="pointer-events-none absolute -right-16 -top-16 h-48 w-48 rounded-full bg-emerald-500/20 blur-3xl"></div>
        <div class="pointer-events-none absolute -left-16 -bottom-16 h-48 w-48 rounded-full bg-amber-500/15 blur-3xl"></div>

        <div class="relative flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between border-b border-white/10 pb-5">
            <div class="flex items-center gap-3">
                <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-500/20 text-emerald-400 ring-1 ring-emerald-400/40 text-2xl shadow-lg">
                    📡
                </span>
                <div>
                    <h3 class="text-base font-bold tracking-tight text-white flex items-center gap-2">
                        AgriVibe 3D System Intelligence & Telemetry Core
                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-500/20 px-2 py-0.5 text-[11px] font-semibold text-emerald-400 ring-1 ring-emerald-500/40">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 animate-pulse"></span> LIVE
                        </span>
                    </h3>
                    <p class="text-xs text-slate-400 mt-0.5">Real-time gateway connectivity, animal biosecurity monitoring, and rural USSD pipelines.</p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <span class="rounded-xl bg-white/5 px-3 py-1.5 text-xs font-mono font-medium text-slate-300 ring-1 ring-white/10">
                    Host: Africa/Kampala · EAT
                </span>
                <span class="rounded-xl bg-emerald-500/20 px-3 py-1.5 text-xs font-mono font-bold text-emerald-300 ring-1 ring-emerald-500/30">
                    Laravel v13 · PHP 8.4 · Filament v5
                </span>
            </div>
        </div>

        {{-- 4 Glowing Sub-systems Status Cards --}}
        <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-xl border border-emerald-500/30 bg-white/5 p-4 backdrop-blur-sm shadow-md transition hover:border-emerald-400/60">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-emerald-400 uppercase tracking-wider">SMS / USSD Gateway</span>
                    <span class="flex h-2 w-2 rounded-full bg-emerald-400 animate-ping"></span>
                </div>
                <div class="mt-2 text-2xl font-black font-mono text-white">99.8%</div>
                <p class="mt-1 text-[11px] text-slate-400">14 dispatched · 0 failed</p>
            </div>

            <div class="rounded-xl border border-cyan-500/30 bg-white/5 p-4 backdrop-blur-sm shadow-md transition hover:border-cyan-400/60">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-cyan-400 uppercase tracking-wider">Telemedicine Calls</span>
                    <span class="h-2 w-2 rounded-full bg-cyan-400"></span>
                </div>
                <div class="mt-2 text-2xl font-black font-mono text-white">2 Active</div>
                <p class="mt-1 text-[11px] text-slate-400">Encrypted WebRTC streams</p>
            </div>

            <div class="rounded-xl border border-amber-500/30 bg-white/5 p-4 backdrop-blur-sm shadow-md transition hover:border-amber-400/60">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-amber-400 uppercase tracking-wider">Drug Withholding</span>
                    <span class="h-2 w-2 rounded-full bg-amber-400 animate-pulse"></span>
                </div>
                <div class="mt-2 text-2xl font-black font-mono text-amber-300">1 Quarantine</div>
                <p class="mt-1 text-[11px] text-amber-200/80">Mastitis treatment active</p>
            </div>

            <div class="rounded-xl border border-purple-500/30 bg-white/5 p-4 backdrop-blur-sm shadow-md transition hover:border-purple-400/60">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-purple-400 uppercase tracking-wider">Offline Sync Pipeline</span>
                    <span class="h-2 w-2 rounded-full bg-purple-400"></span>
                </div>
                <div class="mt-2 text-2xl font-black font-mono text-white">100% Synced</div>
                <p class="mt-1 text-[11px] text-slate-400">0 local batches pending</p>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
