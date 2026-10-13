<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-display text-2xl font-bold text-forest-900">Veterinary Requests</h1>
            <p class="text-sm text-leaf-600">Book telemedicine, farm visits and emergency care for {{ $farm->name }}.</p>
        </div>
        <button wire:click="create" @disabled($vetOptions->isEmpty()) class="inline-flex items-center gap-2 rounded-xl bg-leaf-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-leaf-700 disabled:cursor-not-allowed disabled:opacity-60">
            <x-ui.icon name="plus" class="h-4 w-4" /> Request a Vet
        </button>
    </div>

    @if ($vetOptions->isEmpty())
        <div class="mt-5 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
            No veterinarians are currently available. Please check back later or call the Agrivibe support line.
        </div>
    @endif

    <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($appointments as $appointment)
            <div wire:key="appt-{{ $appointment->id }}" class="flex flex-col rounded-2xl border border-sand-200 bg-white p-5 shadow-sm">
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
                <h4 class="mt-3 font-display text-sm font-bold text-forest-900">{{ $appointment->vet?->name ?? 'Vet assigned soon' }}</h4>
                <p class="mt-1 text-xs text-leaf-600">Patient: <strong>{{ $appointment->animal?->tag_number ?? 'Herd case' }}</strong></p>
                <p class="mt-2 flex-1 rounded-xl border border-sand-100 bg-sand-25 p-2.5 text-xs text-leaf-800"><em>"{{ \Illuminate\Support\Str::limit($appointment->symptoms_description, 120) }}"</em></p>
                <div class="mt-4 flex items-center justify-between border-t border-sand-100 pt-3 text-xs">
                    <span class="text-leaf-600">{{ $appointment->scheduled_at->format('d M, H:i') }}</span>
                    <span class="capitalize font-semibold {{ $appointment->urgency === 'emergency' ? 'text-red-600' : ($appointment->urgency === 'urgent' ? 'text-amber-600' : 'text-leaf-700') }}">{{ $appointment->urgency }}</span>
                </div>
                @if (in_array($appointment->status, ['pending', 'confirmed'], true))
                    <div class="mt-3 flex items-center justify-end gap-3">
                        <button wire:click="cancel({{ $appointment->id }})" wire:confirm="Cancel this appointment?" class="text-xs font-semibold text-berry-600 hover:text-berry-800">Cancel</button>
                    </div>
                @else
                    <div class="mt-3 flex items-center justify-end gap-3">
                        <button wire:click="delete({{ $appointment->id }})" wire:confirm="Remove this request?" class="text-xs font-semibold text-leaf-500 hover:text-leaf-800">Remove</button>
                    </div>
                @endif
            </div>
        @empty
            <div class="sm:col-span-2 lg:col-span-3 rounded-2xl border border-dashed border-sand-300 bg-white px-4 py-12 text-center text-leaf-600">
                No veterinary requests yet. Click <strong>Request a Vet</strong> to book your first consultation.
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $appointments->links() }}
    </div>

    @if ($showModal)
        <div class="fixed inset-0 z-[80] flex items-start justify-center overflow-y-auto bg-forest-950/50 p-4 sm:p-8">
            <div class="w-full max-w-2xl rounded-2xl bg-white shadow-2xl">
                <div class="flex items-center justify-between border-b border-sand-100 px-6 py-4">
                    <h2 class="font-display text-lg font-bold text-forest-900">Request a Veterinarian</h2>
                    <button wire:click="closeModal" class="text-leaf-500 hover:text-leaf-800"><x-ui.icon name="close" class="h-5 w-5" /></button>
                </div>

                <form wire:submit="save" class="grid gap-4 px-6 py-5 sm:grid-cols-2">
                    <div>
                        <label class="form-label">Veterinarian <span class="text-berry-500">*</span></label>
                        <select wire:model="data.vet_id" class="form-input">
                            <option value="">Select a vet</option>
                            @foreach ($vetOptions as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        @error('data.vet_id') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Service type</label>
                        <select wire:model="data.service_type" class="form-input">
                            @foreach (['telemedicine' => 'Telemedicine call', 'farm_visit' => 'Farm visit', 'emergency' => 'Emergency', 'vaccination' => 'Vaccination', 'consultation' => 'Consultation'] as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Animal</label>
                        <select wire:model="data.animal_id" class="form-input">
                            <option value="">Whole herd / farm</option>
                            @foreach ($animalOptions as $id => $label)
                                <option value="{{ $id }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Urgency</label>
                        <select wire:model="data.urgency" class="form-input">
                            <option value="normal">Normal</option>
                            <option value="urgent">Urgent</option>
                            <option value="emergency">Emergency</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Preferred date & time <span class="text-berry-500">*</span></label>
                        <input type="datetime-local" wire:model="data.scheduled_at" class="form-input">
                        @error('data.scheduled_at') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Expected fee (UGX)</label>
                        <input type="number" min="0" step="0.01" wire:model="data.fee_ugx" class="form-input">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label">Symptoms / reason <span class="text-berry-500">*</span></label>
                        <textarea wire:model="data.symptoms_description" rows="3" class="form-input" placeholder="Describe the animal's condition, symptoms and how long they have been present."></textarea>
                        @error('data.symptoms_description') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center justify-end gap-3 border-t border-sand-100 pt-4 sm:col-span-2">
                        <button type="button" wire:click="closeModal" class="rounded-xl px-4 py-2 text-sm font-semibold text-leaf-700 hover:bg-sand-100">Cancel</button>
                        <button type="submit" class="rounded-xl bg-leaf-600 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-leaf-700">
                            <span wire:loading.remove wire:target="save">Submit Request</span>
                            <span wire:loading wire:target="save">Submitting…</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
