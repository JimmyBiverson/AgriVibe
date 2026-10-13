<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-display text-2xl font-bold text-forest-900">Livestock Registry</h1>
            <p class="text-sm text-leaf-600">Individual animals tracked under {{ $farm->name }}.</p>
        </div>
        <button wire:click="create" class="inline-flex items-center gap-2 rounded-xl bg-leaf-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-leaf-700">
            <x-ui.icon name="plus" class="h-4 w-4" /> Register Animal
        </button>
    </div>

    <div class="mt-6 overflow-hidden rounded-2xl border border-sand-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-sand-100 text-sm">
            <thead class="bg-sand-50 text-left text-xs font-semibold uppercase tracking-wider text-leaf-600">
                <tr>
                    <th class="px-4 py-3">Tag</th>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Species / Breed</th>
                    <th class="px-4 py-3">Gender</th>
                    <th class="px-4 py-3">Health</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-sand-100">
                @forelse ($animals as $animal)
                    <tr wire:key="animal-{{ $animal->id }}" class="hover:bg-sand-50/60">
                        <td class="px-4 py-3 font-mono text-xs font-semibold text-forest-900">{{ $animal->tag_number }}</td>
                        <td class="px-4 py-3 text-leaf-900">{{ $animal->name ?: '—' }}</td>
                        <td class="px-4 py-3 text-leaf-700">{{ $animal->species?->name ?? '—' }}@if ($animal->breed) · {{ $animal->breed->name }}@endif</td>
                        <td class="px-4 py-3 capitalize text-leaf-700">{{ $animal->gender }}</td>
                        <td class="px-4 py-3">
                            <span class="rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold capitalize text-emerald-700">{{ str_replace('_', ' ', $animal->health_status) }}</span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button wire:click="edit({{ $animal->id }})" class="text-xs font-semibold text-leaf-600 hover:text-leaf-800">Edit</button>
                            <button wire:click="delete({{ $animal->id }})" wire:confirm="Remove this animal?" class="ml-3 text-xs font-semibold text-berry-600 hover:text-berry-800">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-10 text-center text-leaf-600">
                            No animals yet. Click <strong>Register Animal</strong> to add your first one.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $animals->links() }}
    </div>

    @if ($showModal)
        <div class="fixed inset-0 z-[80] flex items-start justify-center overflow-y-auto bg-forest-950/50 p-4 sm:p-8">
            <div class="w-full max-w-2xl rounded-2xl bg-white shadow-2xl">
                <div class="flex items-center justify-between border-b border-sand-100 px-6 py-4">
                    <h2 class="font-display text-lg font-bold text-forest-900">{{ $editingId ? 'Edit Animal' : 'Register Animal' }}</h2>
                    <button wire:click="closeModal" class="text-leaf-500 hover:text-leaf-800"><x-ui.icon name="close" class="h-5 w-5" /></button>
                </div>

                <form wire:submit="save" class="grid gap-4 px-6 py-5 sm:grid-cols-2">
                    <div>
                        <label class="form-label">Tag number <span class="text-berry-500">*</span></label>
                        <input type="text" wire:model="data.tag_number" class="form-input">
                        @error('data.tag_number') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Name</label>
                        <input type="text" wire:model="data.name" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Species</label>
                        <select wire:model="data.species_id" class="form-input">
                            <option value="">Select species</option>
                            @foreach ($speciesOptions as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Breed</label>
                        <select wire:model="data.breed_id" class="form-input">
                            <option value="">Select breed</option>
                            @foreach ($breedOptions as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Gender</label>
                        <select wire:model="data.gender" class="form-input">
                            <option value="female">Female</option>
                            <option value="male">Male</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Date of birth</label>
                        <input type="date" wire:model="data.date_of_birth" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Weight (kg)</label>
                        <input type="number" step="0.01" wire:model="data.weight_kg" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Estimated value (UGX)</label>
                        <input type="number" step="0.01" wire:model="data.estimated_value" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Health status</label>
                        <input type="text" wire:model="data.health_status" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Reproductive status</label>
                        <input type="text" wire:model="data.reproductive_status" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Housing location</label>
                        <input type="text" wire:model="data.housing_location" class="form-input">
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
