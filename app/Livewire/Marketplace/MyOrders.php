<?php

namespace App\Livewire\Marketplace;

use App\Models\MarketplaceOrder;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class MyOrders extends Component
{
    use WithPagination;

    public string $statusFilter = 'all';

    public function setFilter(string $filter): void
    {
        $this->statusFilter = $filter;
        $this->resetPage();
    }

    public function cancel(int $id): void
    {
        $order = $this->query()->findOrFail($id);

        abort_unless(in_array($order->status, ['pending', 'confirmed'], true), 403);

        $order->update(['status' => 'cancelled']);
        $this->dispatch('notify', message: 'Order cancelled.');
    }

    protected function query()
    {
        return MarketplaceOrder::query()->where('buyer_id', auth()->id());
    }

    public function render(): View
    {
        $orders = $this->query()->with(['seller', 'item']);

        if ($this->statusFilter !== 'all') {
            $orders->where('status', $this->statusFilter);
        }

        return view('livewire.marketplace.my-orders', [
            'orders' => $orders->latest()->paginate(10),
            'totals' => [
                'spent' => (float) $this->query()->sum('amount_paid'),
                'outstanding' => (float) $this->query()
                    ->whereNotIn('status', ['cancelled'])
                    ->selectRaw('COALESCE(SUM(total_amount - amount_paid), 0) as balance')
                    ->value('balance'),
                'count' => $this->query()->count(),
            ],
        ]);
    }
}
