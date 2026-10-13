<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-display text-2xl font-bold text-forest-900">Animal Health & Treatments</h1>
            <p class="text-sm text-leaf-600">Log vaccines, treatments and withdrawals for {{ $farm->name }}.</p>
        </div>
        <button wire:click="create" class="inline-flex items-center gap-2 rounded-xl bg-leaf-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-leaf-700">
            <x-ui.icon name="plus" class="h-4 w-4" /> Log Health Event
        </button>
    </div>

    @if ($withdrawalCount > 0)
        <div class="mt-5 flex items-center gap-3 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
            <x-ui.icon name="exclamation-triangle" class="h-5 w-5" />
            <span><strong>{{ $withdrawalCount }}</strong> withdrawal period(s) active — do not sell milk, meat or eggs from these animals yet.</span>
        </div>
    @endif

    <div class="mt-6 overflow-hidden rounded-2xl border border-sand-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-sand-100 text-sm">
            <thead class="bg-sand-50 text-left text-xs font-semibold uppercase tracking-wider text-leaf-600">
                <tr>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Event</th>
                    <th class="px-4 py-3">Animal / Batch</th>
                    <th class="px-4 py-3">Medicine</th>
                    <th class="px-4 py-3">Withdrawal</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-sand-100">
                @forelse ($events as $event)
                    <tr wire:key="health-{{ $event->id }}" class="hover:bg-sand-50/60">
                        <td class="whitespace-nowrap px-4 py-3 font-mono text-xs text-leaf-700">{{ $event->administered_date->format('d M Y') }}</td>
                        <td class="px-4 py-3">
                            <span class="rounded-full bg-leaf-100 px-2.5 py-0.5 text-[10px] font-bold uppercase text-leaf-800">{{ str_replace('_', ' ', $event->event_type) }}</span>
                            <p class="mt-1 text-leaf-900">{{ $event->title }}</p>
                        </td>
                        <td class="px-4 py-3 text-leaf-700">
                            {{ $event->animal?->tag_number ?? $event->batch?->name ?? '—' }}
                        </td>
                        <td class="px-4 py-3 text-leaf-700">
                            {{ $event->medicine_name ?: '—' }}@if ($event->dosage) <span class="text-leaf-500">({{ $event->dosage }})</span>@endif
                        </td>
                        <td class="px-4 py-3">
                            @if ($event->is_withdrawal_active)
                                <span class="rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-semibold text-amber-800">Until {{ $event->safe_consumption_date->format('d M Y') }}</span>
                            @else
                                <span class="text-xs text-leaf-500">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button wire:click="edit({{ $event->id }})" class="text-xs font-semibold text-leaf-600 hover:text-leaf-800">Edit</button>
                            <button wire:click="delete({{ $event->id }})" wire:confirm="Delete this health record?" class="ml-3 text-xs font-semibold text-berry-600 hover:text-berry-800">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-10 text-center text-leaf-600">
                            No health records yet. Click <strong>Log Health Event</strong> to record a vaccination or treatment.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $events->links() }}
    </div>

    @if ($showModal)
        <div class="fixed inset-0 z-[80] flex items-start justify-center overflow-y-auto bg-forest-950/50 p-4 sm:p-8">
            <div class="w-full max-w-2xl rounded-2xl bg-white shadow-2xl">
                <div class="flex items-center justify-between border-b border-sand-100 px-6 py-4">
                    <h2 class="font-display text-lg font-bold text-forest-900">{{ $editingId ? 'Edit Health Record' : 'Log Health Event' }}</h2>
                    <button wire:click="closeModal" class="text-leaf-500 hover:text-leaf-800"><x-ui.icon name="close" class="h-5 w-5" /></button>
                </div>

                <form wire:submit="save" class="grid gap-4 px-6 py-5 sm:grid-cols-2">
                    <div>
                        <label class="form-label">Event type <span class="text-berry-500">*</span></label>
                        <select wire:model="data.event_type" class="form-input">
                            @foreach (['vaccination', 'treatment', 'deworming', 'checkup', 'mortality', 'other'] as $type)
                                <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                        @error('data.event_type') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Title <span class="text-berry-500">*</span></label>
                        <input type="text" wire:model="data.title" class="form-input" placeholder="e.g. Newcastle vaccination">
                        @error('data.title') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Animal</label>
                        <select wire:model="data.animal_id" class="form-input">
                            <option value="">Whole farm / batch</option>
                            @foreach ($animalOptions as $id => $label)
                                <option value="{{ $id }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Batch</label>
                        <select wire:model="data.animal_batch_id" class="form-input">
                            <option value="">None</option>
                            @foreach ($batchOptions as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Medicine / vaccine</label>
                        <input type="text" wire:model="data.medicine_name" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Dosage</label>
                        <input type="text" wire:model="data.dosage" class="form-input" placeholder="e.g. 2ml IM">
                    </div>
                    <div>
                        <label class="form-label">Administered date <span class="text-berry-500">*</span></label>
                        <input type="date" wire:model="data.administered_date" class="form-input">
                        @error('data.administered_date') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Withdrawal period (days)</label>
                        <input type="number" min="0" wire:model="data.withdrawal_period_days" class="form-input">
                        @error('data.withdrawal_period_days') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Safe consumption date</label>
                        <input type="date" wire:model="data.safe_consumption_date" class="form-input">
                        <p class="mt-1 text-xs text-leaf-500">Leave blank to auto-calculate from the withdrawal period.</p>
                        @error('data.safe_consumption_date') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Status</label>
                        <select wire:model="data.status" class="form-input">
                            <option value="completed">Completed</option>
                            <option value="pending">Pending</option>
                            <option value="scheduled">Scheduled</option>
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label">Clinical notes</label>
                        <textarea wire:model="data.clinical_notes" rows="3" class="form-input"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 border-t border-sand-100 pt-4 sm:col-span-2">
                        <button type="button" wire:click="closeModal" class="rounded-xl px-4 py-2 text-sm font-semibold text-leaf-700 hover:bg-sand-100">Cancel</button>
                        <button type="submit" class="rounded-xl bg-leaf-600 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-leaf-700">
                            <span wire:loading.remove wire:target="save">Save</span>
                            <span wire:loading wire:target="save">Saving…</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
