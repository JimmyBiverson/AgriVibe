<?php

namespace App\Livewire\Farm;

use App\Livewire\Concerns\InteractsWithFarm;
use App\Models\Animal;
use App\Models\AnimalBatch;
use App\Models\HealthEvent;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class HealthManager extends Component
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
        $event = $this->query()->findOrFail($id);

        $this->editingId = $event->id;
        $this->data = [
            'animal_id' => $event->animal_id,
            'animal_batch_id' => $event->animal_batch_id,
            'event_type' => $event->event_type,
            'title' => $event->title,
            'medicine_name' => $event->medicine_name,
            'dosage' => $event->dosage,
            'administered_date' => optional($event->administered_date)->format('Y-m-d'),
            'withdrawal_period_days' => $event->withdrawal_period_days,
            'safe_consumption_date' => optional($event->safe_consumption_date)->format('Y-m-d'),
            'status' => $event->status,
            'clinical_notes' => $event->clinical_notes,
        ];
        $this->showModal = true;
    }

    public function save(): void
    {
        $validated = $this->validate()['data'];

        $withdrawal = (int) ($validated['withdrawal_period_days'] ?? 0);

        if ($withdrawal > 0 && blank($validated['safe_consumption_date'] ?? null) && filled($validated['administered_date'] ?? null)) {
            $validated['safe_consumption_date'] = Carbon::parse($validated['administered_date'])
                ->addDays($withdrawal)
                ->toDateString();
        }

        $validated = array_filter($validated, fn ($value) => $value !== '');

        if ($this->editingId) {
            $this->query()->findOrFail($this->editingId)->update($validated);
            $this->dispatch('notify', message: 'Health record updated.');
        } else {
            HealthEvent::create([...$validated, 'farm_id' => $this->farm()->id]);
            $this->dispatch('notify', message: 'Health record saved.');
        }

        $this->showModal = false;
        $this->resetForm();
    }

    public function delete(int $id): void
    {
        $this->query()->findOrFail($id)->delete();
        $this->dispatch('notify', message: 'Health record deleted.');
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    protected function query()
    {
        return HealthEvent::query()->where('farm_id', $this->farm()->id);
    }

    protected function resetForm(): void
    {
        $this->editingId = null;
        $this->data = [
            'animal_id' => '',
            'animal_batch_id' => '',
            'event_type' => 'vaccination',
            'title' => '',
            'medicine_name' => '',
            'dosage' => '',
            'administered_date' => now()->toDateString(),
            'withdrawal_period_days' => 0,
            'safe_consumption_date' => '',
            'status' => 'completed',
            'clinical_notes' => '',
        ];
        $this->resetErrorBag();
    }

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'data.animal_id' => ['nullable', 'exists:animals,id'],
            'data.animal_batch_id' => ['nullable', 'exists:animal_batches,id'],
            'data.event_type' => ['required', 'in:vaccination,treatment,deworming,checkup,mortality,other'],
            'data.title' => ['required', 'string', 'max:150'],
            'data.medicine_name' => ['nullable', 'string', 'max:150'],
            'data.dosage' => ['nullable', 'string', 'max:100'],
            'data.administered_date' => ['required', 'date'],
            'data.withdrawal_period_days' => ['nullable', 'integer', 'min:0', 'max:365'],
            'data.safe_consumption_date' => ['nullable', 'date', 'after_or_equal:data.administered_date'],
            'data.status' => ['required', 'in:completed,pending,scheduled'],
            'data.clinical_notes' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function render()
    {
        return view('livewire.farm.health-manager', [
            'farm' => $this->farm(),
            'events' => $this->query()->with(['animal', 'batch'])->latest('administered_date')->paginate(10),
            'animalOptions' => Animal::where('farm_id', $this->farm()->id)->orderBy('tag_number')->get()
                ->mapWithKeys(fn (Animal $a) => [$a->id => trim($a->tag_number.' '.($a->name ? "· {$a->name}" : ''))]),
            'batchOptions' => AnimalBatch::where('farm_id', $this->farm()->id)->orderBy('name')->pluck('name', 'id'),
            'withdrawalCount' => $this->query()->whereDate('safe_consumption_date', '>', now())->count(),
        ]);
    }
}
