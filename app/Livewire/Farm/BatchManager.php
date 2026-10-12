<?php

namespace App\Livewire\Farm;

use App\Livewire\Concerns\InteractsWithFarm;
use App\Models\AnimalBatch;
use App\Models\Breed;
use App\Models\Species;
use Livewire\Component;
use Livewire\WithPagination;

class BatchManager extends Component
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
        $batch = $this->query()->findOrFail($id);

        $this->editingId = $batch->id;
        $this->data = [
            'batch_code' => $batch->batch_code,
            'name' => $batch->name,
            'type' => $batch->type,
            'species_id' => $batch->species_id,
            'breed_id' => $batch->breed_id,
            'initial_quantity' => $batch->initial_quantity,
            'current_quantity' => $batch->current_quantity,
            'mortality_count' => $batch->mortality_count,
            'start_date' => optional($batch->start_date)->format('Y-m-d'),
            'expected_end_date' => optional($batch->expected_end_date)->format('Y-m-d'),
            'average_weight_kg' => $batch->average_weight_kg,
            'target_fcr' => $batch->target_fcr,
            'housing_unit' => $batch->housing_unit,
            'status' => $batch->status,
            'notes' => $batch->notes,
        ];
        $this->showModal = true;
    }

    public function save(): void
    {
        $validated = array_filter($this->validate()['data'], fn ($value) => $value !== '');

        if ($this->editingId) {
            $this->query()->findOrFail($this->editingId)->update($validated);
            $this->dispatch('notify', message: 'Batch updated successfully.');
        } else {
            AnimalBatch::create([...$validated, 'farm_id' => $this->farm()->id]);
            $this->dispatch('notify', message: 'Batch created successfully.');
        }

        $this->showModal = false;
        $this->resetForm();
    }

    public function delete(int $id): void
    {
        $this->query()->findOrFail($id)->delete();
        $this->dispatch('notify', message: 'Batch removed.');
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    protected function query()
    {
        return AnimalBatch::query()->where('farm_id', $this->farm()->id);
    }

    protected function resetForm(): void
    {
        $this->editingId = null;
        $this->data = [
            'batch_code' => '',
            'name' => '',
            'type' => 'poultry',
            'species_id' => '',
            'breed_id' => '',
            'initial_quantity' => 0,
            'current_quantity' => 0,
            'mortality_count' => 0,
            'start_date' => now()->format('Y-m-d'),
            'expected_end_date' => '',
            'average_weight_kg' => '',
            'target_fcr' => 1.5,
            'housing_unit' => '',
            'status' => 'active',
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
            'data.batch_code' => ['required', 'string', 'max:50'],
            'data.name' => ['required', 'string', 'max:100'],
            'data.type' => ['required', 'string', 'max:30'],
            'data.species_id' => ['nullable', 'exists:species,id'],
            'data.breed_id' => ['nullable', 'exists:breeds,id'],
            'data.initial_quantity' => ['required', 'integer', 'min:0'],
            'data.current_quantity' => ['required', 'integer', 'min:0'],
            'data.mortality_count' => ['required', 'integer', 'min:0'],
            'data.start_date' => ['required', 'date'],
            'data.expected_end_date' => ['nullable', 'date', 'after_or_equal:data.start_date'],
            'data.average_weight_kg' => ['nullable', 'numeric', 'min:0'],
            'data.target_fcr' => ['required', 'numeric', 'min:0'],
            'data.housing_unit' => ['nullable', 'string', 'max:100'],
            'data.status' => ['required', 'string', 'max:30'],
            'data.notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function render()
    {
        return view('livewire.farm.batch-manager', [
            'farm' => $this->farm(),
            'farms' => $this->availableFarms(),
            'batches' => $this->query()->with(['species', 'breed'])->latest()->paginate(10),
            'speciesOptions' => Species::orderBy('name')->pluck('name', 'id'),
            'breedOptions' => Breed::orderBy('name')->pluck('name', 'id'),
        ]);
    }
}
