<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-display text-2xl font-bold text-forest-900">My Orders</h1>
            <p class="text-sm text-leaf-600">Track your marketplace purchases, payments and deliveries.</p>
        </div>
        <div class="grid grid-cols-3 gap-3 text-center">
            <div class="rounded-xl border border-sand-200 bg-white px-3 py-2">
                <p class="text-[10px] uppercase text-leaf-500">Orders</p>
                <p class="font-display text-sm font-bold text-forest-900">{{ $totals['count'] }}</p>
            </div>
            <div class="rounded-xl border border-sand-200 bg-white px-3 py-2">
                <p class="text-[10px] uppercase text-leaf-500">Paid</p>
                <p class="font-display text-sm font-bold text-emerald-700">{{ number_format($totals['spent']) }}</p>
            </div>
            <div class="rounded-xl border border-sand-200 bg-white px-3 py-2">
                <p class="text-[10px] uppercase text-leaf-500">Outstanding</p>
                <p class="font-display text-sm font-bold text-berry-600">{{ number_format($totals['outstanding']) }}</p>
            </div>
        </div>
    </div>

    <div class="mt-5 flex flex-wrap gap-2">
        @foreach (['all' => 'All', 'pending' => 'Pending', 'confirmed' => 'Confirmed', 'dispatched' => 'Dispatched', 'delivered' => 'Delivered', 'completed' => 'Completed', 'cancelled' => 'Cancelled'] as $key => $label)
            <button wire:click="setFilter('{{ $key }}')"
                class="rounded-xl border px-3 py-1.5 text-xs font-semibold transition {{ $statusFilter === $key ? 'border-leaf-600 bg-leaf-600 text-white' : 'border-sand-200 bg-white text-leaf-700 hover:bg-sand-50' }}">
                {{ $label }}
            </button>
        @endforeach
    </div>

    <div class="mt-6 overflow-hidden rounded-2xl border border-sand-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-sand-100 text-sm">
            <thead class="bg-sand-50 text-left text-xs font-semibold uppercase tracking-wider text-leaf-600">
                <tr>
                    <th class="px-4 py-3">Order</th>
                    <th class="px-4 py-3">Item</th>
                    <th class="px-4 py-3">Seller</th>
                    <th class="px-4 py-3">Total</th>
                    <th class="px-4 py-3">Payment</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-sand-100">
                @forelse ($orders as $order)
                    <tr wire:key="order-{{ $order->id }}" class="hover:bg-sand-50/60">
                        <td class="px-4 py-3 font-mono text-xs font-semibold text-forest-900">{{ $order->order_number }}</td>
                        <td class="px-4 py-3 text-leaf-900">
                            {{ $order->item_title }}
                            <span class="block text-xs text-leaf-500">{{ rtrim(rtrim(number_format((float) $order->quantity, 2), '0'), '.') }} {{ $order->unit }}</span>
                        </td>
                        <td class="px-4 py-3 text-leaf-700">{{ $order->seller?->name }}</td>
                        <td class="px-4 py-3 font-mono text-leaf-900">{{ $order->currency }} {{ number_format((float) $order->total_amount) }}</td>
                        <td class="px-4 py-3">
                            @php
                                $payColors = ['unpaid' => 'bg-sand-100 text-leaf-700', 'partial' => 'bg-amber-100 text-amber-800', 'paid' => 'bg-emerald-100 text-emerald-800'];
                            @endphp
                            <span class="rounded-full px-2.5 py-0.5 text-[10px] font-bold uppercase {{ $payColors[$order->payment_status] ?? 'bg-sand-100 text-leaf-700' }}">{{ $order->payment_status }}</span>
                            @if ((float) $order->balance > 0)
                                <span class="block text-[10px] text-leaf-500">Bal {{ number_format($order->balance) }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <span class="rounded-full bg-leaf-100 px-2.5 py-0.5 text-[10px] font-bold uppercase text-leaf-800">{{ $order->status }}</span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            @if (in_array($order->status, ['pending', 'confirmed'], true))
                                <button wire:click="cancel({{ $order->id }})" wire:confirm="Cancel this order?" class="text-xs font-semibold text-berry-600 hover:text-berry-800">Cancel</button>
                            @else
                                <span class="text-xs text-leaf-400">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-10 text-center text-leaf-600">
                            No orders yet. Browse the <a href="{{ route('marketplace.shop') }}" class="font-semibold text-leaf-700 underline">marketplace</a> to place your first order.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</div>
