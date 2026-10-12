<?php

namespace App\Livewire\Farm;

use App\Livewire\Concerns\InteractsWithFarm;
use App\Models\Animal;
use App\Models\Breed;
use App\Models\Species;
use Livewire\Component;
use Livewire\WithPagination;

class AnimalManager extends Component
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
        $animal = $this->query()->findOrFail($id);

        $this->editingId = $animal->id;
        $this->data = [
            'tag_number' => $animal->tag_number,
            'name' => $animal->name,
            'species_id' => $animal->species_id,
            'breed_id' => $animal->breed_id,
            'gender' => $animal->gender,
            'date_of_birth' => optional($animal->date_of_birth)->format('Y-m-d'),
            'weight_kg' => $animal->weight_kg,
            'health_status' => $animal->health_status,
            'reproductive_status' => $animal->reproductive_status,
            'housing_location' => $animal->housing_location,
            'estimated_value' => $animal->estimated_value,
            'notes' => $animal->notes,
        ];
        $this->showModal = true;
    }

    public function save(): void
    {
        $validated = $this->validate()['data'];

        $validated = array_filter($validated, fn ($value) => $value !== '');

        if ($this->editingId) {
            $this->query()->findOrFail($this->editingId)->update($validated);
            $this->dispatch('notify', message: 'Animal updated successfully.');
        } else {
            Animal::create([...$validated, 'farm_id' => $this->farm()->id]);
            $this->dispatch('notify', message: 'Animal registered successfully.');
        }

        $this->showModal = false;
        $this->resetForm();
    }

    public function delete(int $id): void
    {
        $this->query()->findOrFail($id)->delete();
        $this->dispatch('notify', message: 'Animal removed.');
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    protected function query()
    {
        return Animal::query()->where('farm_id', $this->farm()->id);
    }

    protected function resetForm(): void
    {
        $this->editingId = null;
        $this->data = [
            'tag_number' => '',
            'name' => '',
            'species_id' => '',
            'breed_id' => '',
            'gender' => 'female',
            'date_of_birth' => '',
            'weight_kg' => '',
            'health_status' => 'healthy',
            'reproductive_status' => 'open',
            'housing_location' => '',
            'estimated_value' => 0,
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
            'data.tag_number' => ['required', 'string', 'max:50'],
            'data.name' => ['nullable', 'string', 'max:100'],
            'data.species_id' => ['nullable', 'exists:species,id'],
            'data.breed_id' => ['nullable', 'exists:breeds,id'],
            'data.gender' => ['required', 'in:male,female'],
            'data.date_of_birth' => ['nullable', 'date'],
            'data.weight_kg' => ['nullable', 'numeric', 'min:0'],
            'data.health_status' => ['required', 'string', 'max:30'],
            'data.reproductive_status' => ['required', 'string', 'max:30'],
            'data.housing_location' => ['nullable', 'string', 'max:100'],
            'data.estimated_value' => ['nullable', 'numeric', 'min:0'],
            'data.notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function render()
    {
        return view('livewire.farm.animal-manager', [
            'farm' => $this->farm(),
            'farms' => $this->availableFarms(),
            'animals' => $this->query()->with(['species', 'breed'])->latest()->paginate(10),
            'speciesOptions' => Species::orderBy('name')->pluck('name', 'id'),
            'breedOptions' => Breed::orderBy('name')->pluck('name', 'id'),
        ]);
    }
}
