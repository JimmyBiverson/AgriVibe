<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-display text-2xl font-bold text-forest-900">Production Records</h1>
            <p class="text-sm text-leaf-600">Milk, eggs, meat and other yields for {{ $farm->name }}.</p>
        </div>
        <button wire:click="create" class="inline-flex items-center gap-2 rounded-xl bg-leaf-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-leaf-700">
            <x-ui.icon name="plus" class="h-4 w-4" /> Record Production
        </button>
    </div>

    <div class="mt-6 overflow-hidden rounded-2xl border border-sand-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-sand-100 text-sm">
            <thead class="bg-sand-50 text-left text-xs font-semibold uppercase tracking-wider text-leaf-600">
                <tr>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Product</th>
                    <th class="px-4 py-3">Quantity</th>
                    <th class="px-4 py-3">Sold</th>
                    <th class="px-4 py-3">Unit price</th>
                    <th class="px-4 py-3">Source</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-sand-100">
                @forelse ($records as $record)
                    <tr wire:key="record-{{ $record->id }}" class="hover:bg-sand-50/60">
                        <td class="px-4 py-3">{{ optional($record->record_date)->format('d M Y') }}</td>
                        <td class="px-4 py-3 font-medium capitalize text-forest-900">{{ $record->product_type }}</td>
                        <td class="px-4 py-3 text-leaf-800">{{ number_format((float) $record->quantity, 1) }} {{ $record->unit }}</td>
                        <td class="px-4 py-3 text-leaf-700">{{ number_format((float) $record->sold_quantity, 1) }}</td>
                        <td class="px-4 py-3 text-leaf-700">{{ number_format((float) $record->unit_selling_price) }}</td>
                        <td class="px-4 py-3 text-leaf-600">{{ $record->animal?->tag_number ?? $record->batch?->name ?? '—' }}</td>
                        <td class="px-4 py-3 text-right">
                            <button wire:click="edit({{ $record->id }})" class="text-xs font-semibold text-leaf-600 hover:text-leaf-800">Edit</button>
                            <button wire:click="delete({{ $record->id }})" wire:confirm="Remove this record?" class="ml-3 text-xs font-semibold text-berry-600 hover:text-berry-800">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-10 text-center text-leaf-600">No production recorded yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $records->links() }}</div>

    @if ($showModal)
        <div class="fixed inset-0 z-[80] flex items-start justify-center overflow-y-auto bg-forest-950/50 p-4 sm:p-8">
            <div class="w-full max-w-2xl rounded-2xl bg-white shadow-2xl">
                <div class="flex items-center justify-between border-b border-sand-100 px-6 py-4">
                    <h2 class="font-display text-lg font-bold text-forest-900">{{ $editingId ? 'Edit Record' : 'Record Production' }}</h2>
                    <button wire:click="closeModal" class="text-leaf-500 hover:text-leaf-800"><x-ui.icon name="close" class="h-5 w-5" /></button>
                </div>

                <form wire:submit="save" class="grid gap-4 px-6 py-5 sm:grid-cols-2">
                    <div>
                        <label class="form-label">Product type <span class="text-berry-500">*</span></label>
                        <select wire:model="data.product_type" class="form-input">
                            @foreach (['milk', 'eggs', 'meat', 'fish', 'grain'] as $option)
                                <option value="{{ $option }}">{{ ucfirst($option) }}</option>
                            @endforeach
                        </select>
                        @error('data.product_type') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Date <span class="text-berry-500">*</span></label>
                        <input type="date" wire:model="data.record_date" class="form-input">
                        @error('data.record_date') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Quantity <span class="text-berry-500">*</span></label>
                        <input type="number" step="0.01" wire:model="data.quantity" class="form-input">
                        @error('data.quantity') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Unit</label>
                        <input type="text" wire:model="data.unit" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Sold quantity</label>
                        <input type="number" step="0.01" wire:model="data.sold_quantity" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Unit selling price</label>
                        <input type="number" step="0.01" wire:model="data.unit_selling_price" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Retained for home use</label>
                        <input type="number" step="0.01" wire:model="data.retained_home_use" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Cracked / damaged qty</label>
                        <input type="number" wire:model="data.cracked_damaged_qty" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Animal (optional)</label>
                        <select wire:model="data.animal_id" class="form-input">
                            <option value="">—</option>
                            @foreach ($animalOptions as $id => $tag)
                                <option value="{{ $id }}">{{ $tag }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Batch (optional)</label>
                        <select wire:model="data.animal_batch_id" class="form-input">
                            <option value="">—</option>
                            @foreach ($batchOptions as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
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
