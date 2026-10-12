<div
    x-data="{ toasts: [] }"
    x-on:notify.window="
        toasts.push({ id: Date.now() + Math.random(), message: $event.detail.message ?? ($event.detail[0]?.message ?? '') });
        setTimeout(() => toasts.shift(), 4000);
    "
    class="pointer-events-none fixed inset-x-0 bottom-4 z-[70] mx-auto w-full max-w-sm space-y-2 px-4"
>
    <template x-for="toast in toasts" :key="toast.id">
        <div class="pointer-events-auto flex items-start gap-3 rounded-xl bg-forest-900 px-4 py-3 text-sm font-medium text-white shadow-xl ring-1 ring-emerald-500/30">
            <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-emerald-500 text-[11px] text-forest-950">✓</span>
            <span x-text="toast.message"></span>
        </div>
    </template>
</div>
