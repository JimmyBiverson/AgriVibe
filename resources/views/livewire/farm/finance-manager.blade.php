<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-display text-2xl font-bold text-forest-900">Farm Finance</h1>
            <p class="text-sm text-leaf-600">Income and expenses for {{ $farm->name }}.</p>
        </div>
        <button wire:click="create" class="inline-flex items-center gap-2 rounded-xl bg-leaf-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-leaf-700">
            <x-ui.icon name="plus" class="h-4 w-4" /> Log Transaction
        </button>
    </div>

    <div class="mt-6 grid gap-4 sm:grid-cols-3">
        <x-ui.stat-card title="Total Income" :value="'UGX '.number_format((float) $totalIncome)" icon="arrow-trending-up" color="emerald" description="All recorded sales" />
        <x-ui.stat-card title="Total Expense" :value="'UGX '.number_format((float) $totalExpense)" icon="arrow-trending-down" color="red" description="All recorded costs" />
        <x-ui.stat-card title="Net Balance" :value="'UGX '.number_format((float) ($totalIncome - $totalExpense))" icon="cash" color="gold" description="Income minus expenses" />
    </div>

    <div class="mt-6 overflow-hidden rounded-2xl border border-sand-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-sand-100 text-sm">
            <thead class="bg-sand-50 text-left text-xs font-semibold uppercase tracking-wider text-leaf-600">
                <tr>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Type</th>
                    <th class="px-4 py-3">Category</th>
                    <th class="px-4 py-3">Description</th>
                    <th class="px-4 py-3 text-right">Amount</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-sand-100">
                @forelse ($transactions as $txn)
                    <tr wire:key="txn-{{ $txn->id }}" class="hover:bg-sand-50/60">
                        <td class="px-4 py-3">{{ optional($txn->transaction_date)->format('d M Y') }}</td>
                        <td class="px-4 py-3">
                            @if ($txn->type === 'income')
                                <span class="rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-700">Income</span>
                            @else
                                <span class="rounded-full bg-berry-100 px-2.5 py-0.5 text-xs font-semibold text-berry-700">Expense</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 capitalize text-leaf-700">{{ $txn->category }}</td>
                        <td class="px-4 py-3 text-leaf-800">{{ $txn->description }}</td>
                        <td class="px-4 py-3 text-right font-mono font-semibold {{ $txn->type === 'income' ? 'text-emerald-700' : 'text-berry-700' }}">
                            {{ $txn->type === 'income' ? '+' : '-' }}{{ number_format((float) $txn->amount) }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button wire:click="edit({{ $txn->id }})" class="text-xs font-semibold text-leaf-600 hover:text-leaf-800">Edit</button>
                            <button wire:click="delete({{ $txn->id }})" wire:confirm="Remove this transaction?" class="ml-3 text-xs font-semibold text-berry-600 hover:text-berry-800">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-10 text-center text-leaf-600">No transactions recorded yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $transactions->links() }}</div>

    @if ($showModal)
        <div class="fixed inset-0 z-[80] flex items-start justify-center overflow-y-auto bg-forest-950/50 p-4 sm:p-8">
            <div class="w-full max-w-xl rounded-2xl bg-white shadow-2xl">
                <div class="flex items-center justify-between border-b border-sand-100 px-6 py-4">
                    <h2 class="font-display text-lg font-bold text-forest-900">{{ $editingId ? 'Edit Transaction' : 'Log Transaction' }}</h2>
                    <button wire:click="closeModal" class="text-leaf-500 hover:text-leaf-800"><x-ui.icon name="close" class="h-5 w-5" /></button>
                </div>

                <form wire:submit="save" class="grid gap-4 px-6 py-5 sm:grid-cols-2">
                    <div>
                        <label class="form-label">Type <span class="text-berry-500">*</span></label>
                        <select wire:model="data.type" class="form-input">
                            <option value="income">Income</option>
                            <option value="expense">Expense</option>
                        </select>
                        @error('data.type') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Category <span class="text-berry-500">*</span></label>
                        <select wire:model="data.category" class="form-input">
                            @foreach (['sales', 'feed', 'medicine', 'labour', 'chicks', 'equipment', 'utilities', 'other'] as $option)
                                <option value="{{ $option }}">{{ ucfirst($option) }}</option>
                            @endforeach
                        </select>
                        @error('data.category') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Date <span class="text-berry-500">*</span></label>
                        <input type="date" wire:model="data.transaction_date" class="form-input">
                        @error('data.transaction_date') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Amount <span class="text-berry-500">*</span></label>
                        <input type="number" step="0.01" wire:model="data.amount" class="form-input">
                        @error('data.amount') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Currency</label>
                        <input type="text" wire:model="data.currency" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Reference number</label>
                        <input type="text" wire:model="data.reference_number" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Linked batch (optional)</label>
                        <select wire:model="data.animal_batch_id" class="form-input">
                            <option value="">—</option>
                            @foreach ($batchOptions as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label">Description <span class="text-berry-500">*</span></label>
                        <input type="text" wire:model="data.description" class="form-input">
                        @error('data.description') <p class="form-error">{{ $message }}</p> @enderror
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
