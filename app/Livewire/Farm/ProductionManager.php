<?php

namespace App\Livewire\Farm;

use App\Livewire\Concerns\InteractsWithFarm;
use App\Models\Animal;
use App\Models\AnimalBatch;
use App\Models\ProductionRecord;
use Livewire\Component;
use Livewire\WithPagination;

class ProductionManager extends Component
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
        $record = $this->query()->findOrFail($id);

        $this->editingId = $record->id;
        $this->data = [
            'product_type' => $record->product_type,
            'record_date' => optional($record->record_date)->format('Y-m-d'),
            'quantity' => $record->quantity,
            'unit' => $record->unit,
            'cracked_damaged_qty' => $record->cracked_damaged_qty,
            'retained_home_use' => $record->retained_home_use,
            'sold_quantity' => $record->sold_quantity,
            'unit_selling_price' => $record->unit_selling_price,
            'animal_id' => $record->animal_id,
            'animal_batch_id' => $record->animal_batch_id,
            'notes' => $record->notes,
        ];
        $this->showModal = true;
    }

    public function save(): void
    {
        $validated = array_filter($this->validate()['data'], fn ($value) => $value !== '');

        if ($this->editingId) {
            $this->query()->findOrFail($this->editingId)->update($validated);
            $this->dispatch('notify', message: 'Production record updated.');
        } else {
            ProductionRecord::create([...$validated, 'farm_id' => $this->farm()->id]);
            $this->dispatch('notify', message: 'Production recorded successfully.');
        }

        $this->showModal = false;
        $this->resetForm();
    }

    public function delete(int $id): void
    {
        $this->query()->findOrFail($id)->delete();
        $this->dispatch('notify', message: 'Record removed.');
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    protected function query()
    {
        return ProductionRecord::query()->where('farm_id', $this->farm()->id);
    }

    protected function resetForm(): void
    {
        $this->editingId = null;
        $this->data = [
            'product_type' => 'milk',
            'record_date' => now()->format('Y-m-d'),
            'quantity' => '',
            'unit' => 'litres',
            'cracked_damaged_qty' => 0,
            'retained_home_use' => 0,
            'sold_quantity' => 0,
            'unit_selling_price' => 0,
            'animal_id' => '',
            'animal_batch_id' => '',
            'notes' => '',
        ];
        $this->resetErrorBag();
    }

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'data.product_type' => ['required', 'string', 'max:30'],
            'data.record_date' => ['required', 'date'],
            'data.quantity' => ['required', 'numeric', 'min:0'],
            'data.unit' => ['required', 'string', 'max:20'],
            'data.cracked_damaged_qty' => ['nullable', 'integer', 'min:0'],
            'data.retained_home_use' => ['nullable', 'numeric', 'min:0'],
            'data.sold_quantity' => ['nullable', 'numeric', 'min:0'],
            'data.unit_selling_price' => ['nullable', 'numeric', 'min:0'],
            'data.animal_id' => ['nullable', 'exists:animals,id'],
            'data.animal_batch_id' => ['nullable', 'exists:animal_batches,id'],
            'data.notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function render()
    {
        $farm = $this->farm();

        return view('livewire.farm.production-manager', [
            'farm' => $farm,
            'farms' => $this->availableFarms(),
            'records' => $this->query()->with(['animal', 'batch'])->latest('record_date')->paginate(10),
            'animalOptions' => Animal::where('farm_id', $farm->id)->orderBy('tag_number')->pluck('tag_number', 'id'),
            'batchOptions' => AnimalBatch::where('farm_id', $farm->id)->orderBy('name')->pluck('name', 'id'),
        ]);
    }
}
