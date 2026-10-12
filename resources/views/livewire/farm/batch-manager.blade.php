<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    <x-farm.nav :farm="$farm" :farms="$farms" />

    <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-display text-2xl font-bold text-forest-900">Batches &amp; Flocks</h1>
            <p class="text-sm text-leaf-600">Grouped populations such as poultry flocks or fish ponds.</p>
        </div>
        <button wire:click="create" class="inline-flex items-center gap-2 rounded-xl bg-leaf-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-leaf-700">
            <x-ui.icon name="plus" class="h-4 w-4" /> Add Batch
        </button>
    </div>

    <div class="mt-6 overflow-hidden rounded-2xl border border-sand-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-sand-100 text-sm">
            <thead class="bg-sand-50 text-left text-xs font-semibold uppercase tracking-wider text-leaf-600">
                <tr>
                    <th class="px-4 py-3">Code</th>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Type</th>
                    <th class="px-4 py-3">Head count</th>
                    <th class="px-4 py-3">Livability</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-sand-100">
                @forelse ($batches as $batch)
                    <tr wire:key="batch-{{ $batch->id }}" class="hover:bg-sand-50/60">
                        <td class="px-4 py-3 font-mono text-xs font-semibold text-forest-900">{{ $batch->batch_code }}</td>
                        <td class="px-4 py-3 text-leaf-900">{{ $batch->name }}</td>
                        <td class="px-4 py-3 capitalize text-leaf-700">{{ $batch->type }}</td>
                        <td class="px-4 py-3 text-leaf-800">{{ number_format($batch->current_quantity) }} <span class="text-xs text-leaf-500">/ {{ number_format($batch->initial_quantity) }}</span></td>
                        <td class="px-4 py-3">
                            <span class="rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-700">{{ $batch->livability_percent }}%</span>
                        </td>
                        <td class="px-4 py-3 capitalize text-leaf-700">{{ $batch->status }}</td>
                        <td class="px-4 py-3 text-right">
                            <button wire:click="edit({{ $batch->id }})" class="text-xs font-semibold text-leaf-600 hover:text-leaf-800">Edit</button>
                            <button wire:click="delete({{ $batch->id }})" wire:confirm="Remove this batch?" class="ml-3 text-xs font-semibold text-berry-600 hover:text-berry-800">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-10 text-center text-leaf-600">No batches yet. Add a flock or pond to get started.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $batches->links() }}</div>

    @if ($showModal)
        <div class="fixed inset-0 z-[80] flex items-start justify-center overflow-y-auto bg-forest-950/50 p-4 sm:p-8">
            <div class="w-full max-w-2xl rounded-2xl bg-white shadow-2xl">
                <div class="flex items-center justify-between border-b border-sand-100 px-6 py-4">
                    <h2 class="font-display text-lg font-bold text-forest-900">{{ $editingId ? 'Edit Batch' : 'Add Batch' }}</h2>
                    <button wire:click="closeModal" class="text-leaf-500 hover:text-leaf-800"><x-ui.icon name="close" class="h-5 w-5" /></button>
                </div>

                <form wire:submit="save" class="grid gap-4 px-6 py-5 sm:grid-cols-2">
                    <div>
                        <label class="form-label">Batch code <span class="text-berry-500">*</span></label>
                        <input type="text" wire:model="data.batch_code" class="form-input">
                        @error('data.batch_code') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Name <span class="text-berry-500">*</span></label>
                        <input type="text" wire:model="data.name" class="form-input">
                        @error('data.name') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Type</label>
                        <select wire:model="data.type" class="form-input">
                            @foreach (['poultry', 'fish', 'pig', 'goat', 'cattle', 'other'] as $option)
                                <option value="{{ $option }}">{{ ucfirst($option) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Species</label>
                        <select wire:model="data.species_id" class="form-input">
                            <option value="">—</option>
                            @foreach ($speciesOptions as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Breed</label>
                        <select wire:model="data.breed_id" class="form-input">
                            <option value="">—</option>
                            @foreach ($breedOptions as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Housing unit</label>
                        <input type="text" wire:model="data.housing_unit" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Initial quantity <span class="text-berry-500">*</span></label>
                        <input type="number" wire:model="data.initial_quantity" class="form-input">
                        @error('data.initial_quantity') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Current quantity <span class="text-berry-500">*</span></label>
                        <input type="number" wire:model="data.current_quantity" class="form-input">
                        @error('data.current_quantity') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Mortality count</label>
                        <input type="number" wire:model="data.mortality_count" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Start date <span class="text-berry-500">*</span></label>
                        <input type="date" wire:model="data.start_date" class="form-input">
                        @error('data.start_date') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Expected end date</label>
                        <input type="date" wire:model="data.expected_end_date" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Average weight (kg)</label>
                        <input type="number" step="0.001" wire:model="data.average_weight_kg" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Target FCR</label>
                        <input type="number" step="0.01" wire:model="data.target_fcr" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Status</label>
                        <select wire:model="data.status" class="form-input">
                            @foreach (['active', 'completed', 'sold', 'archived'] as $option)
                                <option value="{{ $option }}">{{ ucfirst($option) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label">Notes</label>
                        <textarea wire:model="data.notes" rows="2" class="form-input"></textarea>
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
