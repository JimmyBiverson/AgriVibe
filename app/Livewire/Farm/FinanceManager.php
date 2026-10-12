<?php

namespace App\Livewire\Farm;

use App\Livewire\Concerns\InteractsWithFarm;
use App\Models\AnimalBatch;
use App\Models\FarmFinance;
use Livewire\Component;
use Livewire\WithPagination;

class FinanceManager extends Component
{
    use InteractsWithFarm, WithPagination;

    public bool $showModal = false;

    public ?int $editingId = null;

    /** @var array<string, mixed> */
    public array $data = [];

    public function mount(?int $farmId = null): void
    {
        $this->initializeFarm($farmId);
        $this->resetForm();
    }

    public function create(): void
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit(int $id): void
    {
        $finance = $this->query()->findOrFail($id);

        $this->editingId = $finance->id;
        $this->data = [
            'type' => $finance->type,
            'category' => $finance->category,
            'transaction_date' => optional($finance->transaction_date)->format('Y-m-d'),
            'amount' => $finance->amount,
            'currency' => $finance->currency,
            'description' => $finance->description,
            'reference_number' => $finance->reference_number,
            'animal_batch_id' => $finance->animal_batch_id,
        ];
        $this->showModal = true;
    }

    public function save(): void
    {
        $validated = array_filter($this->validate()['data'], fn ($value) => $value !== '');

        if ($this->editingId) {
            $this->query()->findOrFail($this->editingId)->update($validated);
            $this->dispatch('notify', message: 'Transaction updated.');
        } else {
            FarmFinance::create([...$validated, 'farm_id' => $this->farm()->id]);
            $this->dispatch('notify', message: 'Transaction recorded successfully.');
        }

        $this->showModal = false;
        $this->resetForm();
    }

    public function delete(int $id): void
    {
        $this->query()->findOrFail($id)->delete();
        $this->dispatch('notify', message: 'Transaction removed.');
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    protected function query()
    {
        return FarmFinance::query()->where('farm_id', $this->farm()->id);
    }

    protected function resetForm(): void
    {
        $this->editingId = null;
        $this->data = [
            'type' => 'income',
            'category' => 'sales',
            'transaction_date' => now()->format('Y-m-d'),
            'amount' => '',
            'currency' => 'UGX',
            'description' => '',
            'reference_number' => '',
            'animal_batch_id' => '',
        ];
        $this->resetErrorBag();
    }

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'data.type' => ['required', 'in:income,expense'],
            'data.category' => ['required', 'string', 'max:50'],
            'data.transaction_date' => ['required', 'date'],
            'data.amount' => ['required', 'numeric', 'min:0'],
            'data.currency' => ['required', 'string', 'max:5'],
            'data.description' => ['required', 'string', 'max:255'],
            'data.reference_number' => ['nullable', 'string', 'max:50'],
            'data.animal_batch_id' => ['nullable', 'exists:animal_batches,id'],
        ];
    }

    public function render()
    {
        $farm = $this->farm();

        return view('livewire.farm.finance-manager', [
            'farm' => $farm,
            'farms' => $this->availableFarms(),
            'transactions' => $this->query()->latest('transaction_date')->paginate(12),
            'totalIncome' => $this->query()->where('type', 'income')->sum('amount'),
            'totalExpense' => $this->query()->where('type', 'expense')->sum('amount'),
            'batchOptions' => AnimalBatch::where('farm_id', $farm->id)->orderBy('name')->pluck('name', 'id'),
        ]);
    }
}
