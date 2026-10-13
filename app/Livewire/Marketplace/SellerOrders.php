<?php

namespace App\Livewire\Marketplace;

use App\Models\MarketplaceOrder;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class SellerOrders extends Component
{
    use WithPagination;

    public string $statusFilter = 'open';

    public ?int $paymentOrderId = null;

    /** @var array<string, mixed> */
    public array $data = [];

    public function setFilter(string $filter): void
    {
        $this->statusFilter = $filter;
        $this->resetPage();
    }

    public function confirm(int $id): void
    {
        $this->query()->findOrFail($id)->update(['status' => 'confirmed']);
        $this->dispatch('notify', message: 'Order confirmed.');
    }

    public function markDispatched(int $id): void
    {
        $this->query()->findOrFail($id)->update([
            'status' => 'dispatched',
            'dispatched_at' => now(),
        ]);
        $this->dispatch('notify', message: 'Order marked as dispatched.');
    }

    public function markDelivered(int $id): void
    {
        $this->query()->findOrFail($id)->update([
            'status' => 'delivered',
            'delivered_at' => now(),
        ]);
        $this->dispatch('notify', message: 'Order marked as delivered.');
    }

    public function complete(int $id): void
    {
        $order = $this->query()->findOrFail($id);

        $order->update(['status' => 'completed']);
        $this->dispatch('notify', message: 'Order completed.');
    }

    public function cancel(int $id): void
    {
        $this->query()->findOrFail($id)->update(['status' => 'cancelled']);
        $this->dispatch('notify', message: 'Order cancelled.');
    }

    public function recordPayment(int $id): void
    {
        $order = $this->query()->findOrFail($id);

        $this->paymentOrderId = $order->id;
        $this->data = [
            'amount' => $order->balance,
            'payment_method' => 'cash',
            'payment_reference' => '',
        ];
        $this->resetErrorBag();
    }

    public function savePayment(): void
    {
        $order = $this->query()->findOrFail($this->paymentOrderId);
        $validated = $this->validate()['data'];

        $amountPaid = (float) $order->amount_paid + (float) $validated['amount'];

        $order->update([
            'amount_paid' => $amountPaid,
            'payment_status' => match (true) {
                $amountPaid <= 0 => 'unpaid',
                $amountPaid >= (float) $order->total_amount => 'paid',
                default => 'partial',
            },
            'payment_method' => $validated['payment_method'],
            'payment_reference' => $validated['payment_reference'] ?: null,
        ]);

        $this->dispatch('notify', message: 'Payment recorded.');
        $this->paymentOrderId = null;
        $this->data = [];
    }

    public function closeModal(): void
    {
        $this->paymentOrderId = null;
        $this->data = [];
        $this->resetErrorBag();
    }

    protected function query()
    {
        return MarketplaceOrder::query()->where('seller_id', auth()->id());
    }

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'data.amount' => ['required', 'numeric', 'min:0.01'],
            'data.payment_method' => ['required', 'in:cash,mobile_money,bank_transfer'],
            'data.payment_reference' => ['nullable', 'string', 'max:100'],
        ];
    }

    public function render(): View
    {
        $orders = $this->query()->with(['buyer', 'item']);

        match ($this->statusFilter) {
            'open' => $orders->whereIn('status', ['pending', 'confirmed', 'dispatched', 'delivered']),
            'completed' => $orders->where('status', 'completed'),
            'cancelled' => $orders->where('status', 'cancelled'),
            'all' => null,
            default => null,
        };

        return view('livewire.marketplace.seller-orders', [
            'orders' => $orders->latest()->paginate(10),
            'totals' => [
                'revenue' => (float) $this->query()->sum('amount_paid'),
                'outstanding' => (float) $this->query()
                    ->whereNotIn('status', ['cancelled'])
                    ->selectRaw('COALESCE(SUM(total_amount - amount_paid), 0) as balance')
                    ->value('balance'),
                'openCount' => $this->query()->whereIn('status', ['pending', 'confirmed', 'dispatched'])->count(),
            ],
            'paymentOrder' => $this->paymentOrderId ? $this->query()->find($this->paymentOrderId) : null,
        ]);
    }
}
