<?php

namespace App\Livewire\Marketplace;

use App\Models\MarketplaceItem;
use App\Models\MarketplaceOrder;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class ListingBrowser extends Component
{
    use WithPagination;

    public string $search = '';

    public string $category = '';

    public ?int $orderingId = null;

    /** @var array<string, mixed> */
    public array $data = [];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedCategory(): void
    {
        $this->resetPage();
    }

    public function startOrder(int $id): void
    {
        $item = MarketplaceItem::where('status', 'active')->findOrFail($id);

        abort_if($item->seller_id === auth()->id(), 403, 'You cannot order your own listing.');

        $this->orderingId = $item->id;
        $this->data = [
            'quantity' => 1,
            'delivery_method' => 'pickup',
            'delivery_address' => '',
            'notes' => '',
        ];
        $this->resetErrorBag();
    }

    public function placeOrder(): void
    {
        $item = MarketplaceItem::where('status', 'active')->findOrFail($this->orderingId);

        abort_if($item->seller_id === auth()->id(), 403);

        $validated = $this->validate()['data'];

        $quantity = (float) $validated['quantity'];
        $total = round($quantity * (float) $item->price, 2);

        MarketplaceOrder::create([
            'buyer_id' => auth()->id(),
            'seller_id' => $item->seller_id,
            'marketplace_item_id' => $item->id,
            'item_title' => $item->title,
            'quantity' => $quantity,
            'unit' => $item->unit,
            'unit_price' => $item->price,
            'currency' => 'UGX',
            'total_amount' => $total,
            'amount_paid' => 0,
            'payment_status' => 'unpaid',
            'status' => 'pending',
            'delivery_method' => $validated['delivery_method'] ?? null,
            'delivery_address' => $validated['delivery_address'] ?: null,
            'notes' => $validated['notes'] ?: null,
        ]);

        $this->dispatch('notify', message: 'Order placed successfully. The seller will confirm shortly.');
        $this->orderingId = null;
        $this->data = [];
        $this->resetPage();
    }

    public function closeModal(): void
    {
        $this->orderingId = null;
        $this->data = [];
        $this->resetErrorBag();
    }

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'data.quantity' => ['required', 'numeric', 'min:0.01'],
            'data.delivery_method' => ['required', 'in:pickup,delivery,courier'],
            'data.delivery_address' => ['nullable', 'string', 'max:255'],
            'data.notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function render(): View
    {
        $listings = MarketplaceItem::query()
            ->with('seller')
            ->where('status', 'active')
            ->when($this->search !== '', fn ($query) => $query->where('title', 'like', "%{$this->search}%"))
            ->when($this->category !== '', fn ($query) => $query->where('category', $this->category))
            ->latest()
            ->paginate(9);

        return view('livewire.marketplace.listing-browser', [
            'listings' => $listings,
            'categories' => MarketplaceItem::query()->where('status', 'active')->distinct()->orderBy('category')->pluck('category'),
            'selectedItem' => $this->orderingId ? MarketplaceItem::find($this->orderingId) : null,
        ]);
    }
}
