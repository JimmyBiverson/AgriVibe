<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-display text-2xl font-bold text-forest-900">Clinical Console</h1>
            <p class="text-sm text-leaf-600">Review patient requests, confirm visits and record your diagnosis.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            @foreach (['active' => 'Active', 'completed' => 'Completed', 'cancelled' => 'Cancelled', 'all' => 'All'] as $key => $label)
                <button wire:click="setFilter('{{ $key }}')"
                    class="rounded-xl border px-3 py-1.5 text-xs font-semibold transition {{ $statusFilter === $key ? 'border-leaf-600 bg-leaf-600 text-white' : 'border-sand-200 bg-white text-leaf-700 hover:bg-sand-50' }}">
                    {{ $label }} <span class="opacity-70">({{ $counts[$key] }})</span>
                </button>
            @endforeach
        </div>
    </div>

    <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($appointments as $appointment)
            <div wire:key="vet-appt-{{ $appointment->id }}" class="flex flex-col rounded-2xl border border-sand-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between border-b border-sand-100 pb-3">
                    <span class="rounded-md bg-leaf-100 px-2 py-0.5 text-[10px] font-bold uppercase text-leaf-800">{{ str_replace('_', ' ', $appointment->service_type) }}</span>
                    @php
                        $statusColors = [
                            'pending' => 'bg-amber-100 text-amber-800',
                            'confirmed' => 'bg-emerald-100 text-emerald-800',
                            'completed' => 'bg-sky-100 text-sky-800',
                            'cancelled' => 'bg-berry-100 text-berry-800',
                        ];
                    @endphp
                    <span class="rounded-full px-2.5 py-0.5 text-[10px] font-bold uppercase {{ $statusColors[$appointment->status] ?? 'bg-sand-100 text-leaf-700' }}">{{ $appointment->status }}</span>
                </div>

                <h4 class="mt-3 font-display text-sm font-bold text-forest-900">{{ $appointment->farmer?->name }}</h4>
                <p class="text-xs text-leaf-600">{{ $appointment->farm?->name ?? 'Farm' }} · Patient: <strong>{{ $appointment->animal?->tag_number ?? 'Herd case' }}</strong></p>

                <p class="mt-3 flex-1 rounded-xl border border-sand-100 bg-sand-25 p-2.5 text-xs text-leaf-800">
                    <em>"{{ \Illuminate\Support\Str::limit($appointment->symptoms_description, 140) }}"</em>
                </p>

                @if ($appointment->diagnosis)
                    <div class="mt-3 rounded-xl border border-emerald-100 bg-emerald-50 p-2.5 text-xs text-emerald-900">
                        <strong>Dx:</strong> {{ \Illuminate\Support\Str::limit($appointment->diagnosis, 120) }}
                    </div>
                @endif

                <div class="mt-4 flex items-center justify-between border-t border-sand-100 pt-3 text-xs">
                    <span class="text-leaf-600">{{ $appointment->scheduled_at->format('d M, H:i') }}</span>
                    <span class="font-mono font-bold text-forest-900">UGX {{ number_format((float) $appointment->fee_ugx) }}</span>
                </div>

                <div class="mt-3 flex items-center justify-end gap-2">
                    @if ($appointment->status === 'pending')
                        <button wire:click="confirm({{ $appointment->id }})" class="rounded-lg bg-leaf-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-leaf-700">Confirm</button>
                    @endif
                    @if (in_array($appointment->status, ['pending', 'confirmed'], true))
                        <button wire:click="startComplete({{ $appointment->id }})" class="rounded-lg border border-sand-200 px-3 py-1.5 text-xs font-semibold text-leaf-700 hover:bg-sand-50">Complete</button>
                        <button wire:click="cancel({{ $appointment->id }})" wire:confirm="Cancel this appointment?" class="text-xs font-semibold text-berry-600 hover:text-berry-800">Cancel</button>
                    @endif
                </div>
            </div>
        @empty
            <div class="rounded-2xl border border-dashed border-sand-300 bg-white px-4 py-12 text-center text-leaf-600 sm:col-span-2 lg:col-span-3">
                No appointments in this view.
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $appointments->links() }}
    </div>

    @if ($completingId)
        <div class="fixed inset-0 z-[80] flex items-start justify-center overflow-y-auto bg-forest-950/50 p-4 sm:p-8">
            <div class="w-full max-w-2xl rounded-2xl bg-white shadow-2xl">
                <div class="flex items-center justify-between border-b border-sand-100 px-6 py-4">
                    <h2 class="font-display text-lg font-bold text-forest-900">Complete Consultation</h2>
                    <button wire:click="closeModal" class="text-leaf-500 hover:text-leaf-800"><x-ui.icon name="close" class="h-5 w-5" /></button>
                </div>

                <form wire:submit="complete" class="grid gap-4 px-6 py-5">
                    <div>
                        <label class="form-label">Diagnosis <span class="text-berry-500">*</span></label>
                        <textarea wire:model="data.diagnosis" rows="3" class="form-input"></textarea>
                        @error('data.diagnosis') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Prescription / advice</label>
                        <textarea wire:model="data.prescription" rows="3" class="form-input"></textarea>
                    </div>
                    <div>
                        <label class="form-label">Fee charged (UGX)</label>
                        <input type="number" min="0" step="0.01" wire:model="data.fee_ugx" class="form-input">
                        @error('data.fee_ugx') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-end gap-3 border-t border-sand-100 pt-4">
                        <button type="button" wire:click="closeModal" class="rounded-xl px-4 py-2 text-sm font-semibold text-leaf-700 hover:bg-sand-100">Cancel</button>
                        <button type="submit" class="rounded-xl bg-leaf-600 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-leaf-700">
                            <span wire:loading.remove wire:target="complete">Save & Complete</span>
                            <span wire:loading wire:target="complete">Saving…</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
