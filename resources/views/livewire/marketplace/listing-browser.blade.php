<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-display text-2xl font-bold text-forest-900">Marketplace</h1>
            <p class="text-sm text-leaf-600">Source verified produce, inputs, livestock and services from trusted sellers.</p>
        </div>
        <div class="flex flex-col gap-2 sm:flex-row">
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-leaf-400"><x-ui.icon name="search" class="h-4 w-4" /></span>
                <input type="search" wire:model.live.debounce.400ms="search" placeholder="Search listings…" class="form-input pl-9 sm:w-64">
            </div>
            <select wire:model.live="category" class="form-input sm:w-48">
                <option value="">All categories</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat }}">{{ ucfirst($cat) }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse ($listings as $listing)
            <div wire:key="listing-{{ $listing->id }}" class="card-3d flex flex-col rounded-2xl border border-sand-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <span class="rounded-full bg-sand-100 px-2.5 py-0.5 text-[10px] font-bold uppercase text-leaf-700">{{ $listing->category }}</span>
                    @if ($listing->seller?->is_verified)
                        <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-bold uppercase text-emerald-700">Verified</span>
                    @endif
                </div>
                <h4 class="mt-2 font-display text-base font-bold text-forest-900">{{ $listing->title }}</h4>
                <p class="mt-1 text-xs text-leaf-600">Seller: {{ $listing->seller?->name }} · {{ $listing->location }}</p>
                <p class="mt-2 flex-1 text-xs text-leaf-700">{{ \Illuminate\Support\Str::limit($listing->description, 90) }}</p>
                <div class="mt-4 flex items-center justify-between border-t border-sand-100 pt-3">
                    <div>
                        <p class="font-mono text-sm font-black text-forest-900">UGX {{ number_format((float) $listing->price) }}</p>
                        <p class="text-[10px] text-leaf-500">per {{ $listing->unit }} · {{ rtrim(rtrim(number_format((float) $listing->available_stock, 2), '0'), '.') }} in stock</p>
                    </div>
                    <button wire:click="startOrder({{ $listing->id }})" class="rounded-xl bg-forest-900 px-4 py-2 text-xs font-bold text-white hover:bg-forest-800">
                        Order
                    </button>
                </div>
            </div>
        @empty
            <div class="rounded-2xl border border-dashed border-sand-300 bg-white px-4 py-12 text-center text-leaf-600 sm:col-span-2 lg:col-span-3">
                No listings match your filters yet.
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $listings->links() }}
    </div>

    @if ($selectedItem)
        <div class="fixed inset-0 z-[80] flex items-start justify-center overflow-y-auto bg-forest-950/50 p-4 sm:p-8">
            <div class="w-full max-w-xl rounded-2xl bg-white shadow-2xl">
                <div class="flex items-center justify-between border-b border-sand-100 px-6 py-4">
                    <div>
                        <h2 class="font-display text-lg font-bold text-forest-900">Place Order</h2>
                        <p class="text-xs text-leaf-600">{{ $selectedItem->title }}</p>
                    </div>
                    <button wire:click="closeModal" class="text-leaf-500 hover:text-leaf-800"><x-ui.icon name="close" class="h-5 w-5" /></button>
                </div>

                <form wire:submit="placeOrder" class="grid gap-4 px-6 py-5 sm:grid-cols-2">
                    <div class="sm:col-span-2 flex items-center justify-between rounded-xl border border-sand-100 bg-sand-25 p-3 text-sm">
                        <span class="text-leaf-700">Unit price</span>
                        <span class="font-mono font-bold text-forest-900">UGX {{ number_format((float) $selectedItem->price) }} / {{ $selectedItem->unit }}</span>
                    </div>
                    <div>
                        <label class="form-label">Quantity ({{ $selectedItem->unit }}) <span class="text-berry-500">*</span></label>
                        <input type="number" step="0.01" min="0.01" wire:model.live="data.quantity" class="form-input">
                        @error('data.quantity') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Delivery method</label>
                        <select wire:model="data.delivery_method" class="form-input">
                            <option value="pickup">Pickup</option>
                            <option value="delivery">Delivery</option>
                            <option value="courier">Courier</option>
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label">Delivery address</label>
                        <input type="text" wire:model="data.delivery_address" class="form-input" placeholder="Village, district (if delivery)">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label">Notes to seller</label>
                        <textarea wire:model="data.notes" rows="2" class="form-input"></textarea>
                    </div>

                    <div class="sm:col-span-2 flex items-center justify-between rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3">
                        <span class="text-sm font-semibold text-emerald-900">Estimated total</span>
                        <span class="font-mono text-lg font-black text-emerald-900">
                            UGX {{ number_format(((float) ($data['quantity'] ?? 0)) * (float) $selectedItem->price) }}
                        </span>
                    </div>

                    <div class="flex items-center justify-end gap-3 border-t border-sand-100 pt-4 sm:col-span-2">
                        <button type="button" wire:click="closeModal" class="rounded-xl px-4 py-2 text-sm font-semibold text-leaf-700 hover:bg-sand-100">Cancel</button>
                        <button type="submit" class="rounded-xl bg-leaf-600 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-leaf-700">
                            <span wire:loading.remove wire:target="placeOrder">Confirm Order</span>
                            <span wire:loading wire:target="placeOrder">Placing…</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
