<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-display text-2xl font-bold text-forest-900">Sales & Orders</h1>
            <p class="text-sm text-leaf-600">Fulfil orders, track payments and monitor your marketplace revenue.</p>
        </div>
        <div class="grid grid-cols-3 gap-3 text-center">
            <div class="rounded-xl border border-sand-200 bg-white px-3 py-2">
                <p class="text-[10px] uppercase text-leaf-500">Open</p>
                <p class="font-display text-sm font-bold text-forest-900">{{ $totals['openCount'] }}</p>
            </div>
            <div class="rounded-xl border border-sand-200 bg-white px-3 py-2">
                <p class="text-[10px] uppercase text-leaf-500">Revenue</p>
                <p class="font-display text-sm font-bold text-emerald-700">{{ number_format($totals['revenue']) }}</p>
            </div>
            <div class="rounded-xl border border-sand-200 bg-white px-3 py-2">
                <p class="text-[10px] uppercase text-leaf-500">Outstanding</p>
                <p class="font-display text-sm font-bold text-berry-600">{{ number_format($totals['outstanding']) }}</p>
            </div>
        </div>
    </div>

    <div class="mt-5 flex flex-wrap gap-2">
        @foreach (['open' => 'Open', 'completed' => 'Completed', 'cancelled' => 'Cancelled', 'all' => 'All'] as $key => $label)
            <button wire:click="setFilter('{{ $key }}')"
                class="rounded-xl border px-3 py-1.5 text-xs font-semibold transition {{ $statusFilter === $key ? 'border-leaf-600 bg-leaf-600 text-white' : 'border-sand-200 bg-white text-leaf-700 hover:bg-sand-50' }}">
                {{ $label }}
            </button>
        @endforeach
    </div>

    <div class="mt-6 space-y-3">
        @forelse ($orders as $order)
            <div wire:key="sale-{{ $order->id }}" class="rounded-2xl border border-sand-200 bg-white p-5 shadow-sm">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <div class="flex items-center gap-3">
                            <span class="font-mono text-xs font-semibold text-forest-900">{{ $order->order_number }}</span>
                            <span class="rounded-full bg-leaf-100 px-2.5 py-0.5 text-[10px] font-bold uppercase text-leaf-800">{{ $order->status }}</span>
                            @if ((float) $order->balance > 0 && $order->status !== 'cancelled')
                                <span class="rounded-full bg-amber-100 px-2.5 py-0.5 text-[10px] font-bold uppercase text-amber-800">{{ $order->payment_status }}</span>
                            @elseif ($order->status !== 'cancelled')
                                <span class="rounded-full bg-emerald-100 px-2.5 py-0.5 text-[10px] font-bold uppercase text-emerald-800">paid</span>
                            @endif
                        </div>
                        <h4 class="mt-2 font-display text-sm font-bold text-forest-900">{{ $order->item_title }}</h4>
                        <p class="text-xs text-leaf-600">
                            Buyer: {{ $order->buyer?->name }} · {{ rtrim(rtrim(number_format((float) $order->quantity, 2), '0'), '.') }} {{ $order->unit }} @ {{ number_format((float) $order->unit_price) }}
                        </p>
                        @if ($order->delivery_address)
                            <p class="mt-1 text-xs text-leaf-500">Deliver to: {{ $order->delivery_address }} ({{ $order->delivery_method }})</p>
                        @endif
                    </div>
                    <div class="text-right">
                        <p class="font-mono text-base font-black text-forest-900">{{ $order->currency }} {{ number_format((float) $order->total_amount) }}</p>
                        <p class="text-xs text-leaf-600">Paid: {{ number_format((float) $order->amount_paid) }}</p>
                    </div>
                </div>

                <div class="mt-4 flex flex-wrap items-center justify-end gap-2 border-t border-sand-100 pt-3">
                    @if ($order->status === 'pending')
                        <button wire:click="confirm({{ $order->id }})" class="rounded-lg bg-leaf-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-leaf-700">Confirm</button>
                    @endif
                    @if ($order->status === 'confirmed')
                        <button wire:click="markDispatched({{ $order->id }})" class="rounded-lg bg-leaf-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-leaf-700">Mark Dispatched</button>
                    @endif
                    @if ($order->status === 'dispatched')
                        <button wire:click="markDelivered({{ $order->id }})" class="rounded-lg bg-leaf-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-leaf-700">Mark Delivered</button>
                    @endif
                    @if ($order->status === 'delivered')
                        <button wire:click="complete({{ $order->id }})" class="rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-emerald-500">Complete</button>
                    @endif
                    @if ((float) $order->balance > 0 && ! in_array($order->status, ['cancelled'], true))
                        <button wire:click="recordPayment({{ $order->id }})" class="rounded-lg border border-sand-200 px-3 py-1.5 text-xs font-semibold text-leaf-700 hover:bg-sand-50">Record Payment</button>
                    @endif
                    @if (in_array($order->status, ['pending', 'confirmed'], true))
                        <button wire:click="cancel({{ $order->id }})" wire:confirm="Cancel this order?" class="text-xs font-semibold text-berry-600 hover:text-berry-800">Cancel</button>
                    @endif
                </div>
            </div>
        @empty
            <div class="rounded-2xl border border-dashed border-sand-300 bg-white px-4 py-12 text-center text-leaf-600">
                No orders in this view yet.
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>

    @if ($paymentOrder)
        <div class="fixed inset-0 z-[80] flex items-start justify-center overflow-y-auto bg-forest-950/50 p-4 sm:p-8">
            <div class="w-full max-w-lg rounded-2xl bg-white shadow-2xl">
                <div class="flex items-center justify-between border-b border-sand-100 px-6 py-4">
                    <div>
                        <h2 class="font-display text-lg font-bold text-forest-900">Record Payment</h2>
                        <p class="text-xs text-leaf-600">{{ $paymentOrder->order_number }} · balance {{ number_format($paymentOrder->balance) }}</p>
                    </div>
                    <button wire:click="closeModal" class="text-leaf-500 hover:text-leaf-800"><x-ui.icon name="close" class="h-5 w-5" /></button>
                </div>

                <form wire:submit="savePayment" class="grid gap-4 px-6 py-5">
                    <div>
                        <label class="form-label">Amount received (UGX) <span class="text-berry-500">*</span></label>
                        <input type="number" step="0.01" min="0.01" wire:model="data.amount" class="form-input">
                        @error('data.amount') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Payment method</label>
                        <select wire:model="data.payment_method" class="form-input">
                            <option value="cash">Cash</option>
                            <option value="mobile_money">Mobile money</option>
                            <option value="bank_transfer">Bank transfer</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Reference</label>
                        <input type="text" wire:model="data.payment_reference" class="form-input" placeholder="e.g. MoMo transaction ID">
                    </div>

                    <div class="flex items-center justify-end gap-3 border-t border-sand-100 pt-4">
                        <button type="button" wire:click="closeModal" class="rounded-xl px-4 py-2 text-sm font-semibold text-leaf-700 hover:bg-sand-100">Cancel</button>
                        <button type="submit" class="rounded-xl bg-leaf-600 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-leaf-700">
                            <span wire:loading.remove wire:target="savePayment">Save Payment</span>
                            <span wire:loading wire:target="savePayment">Saving…</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
