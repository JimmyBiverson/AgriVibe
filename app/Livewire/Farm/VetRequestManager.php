<?php

namespace App\Livewire\Farm;

use App\Livewire\Concerns\InteractsWithFarm;
use App\Models\Animal;
use App\Models\User;
use App\Models\VetAppointment;
use Livewire\Component;
use Livewire\WithPagination;

class VetRequestManager extends Component
{
    use InteractsWithFarm, WithPagination;

    public bool $showModal = false;

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

    public function save(): void
    {
        $validated = $this->validate()['data'];

        $validated = array_filter($validated, fn ($value) => $value !== '');

        VetAppointment::create([
            ...$validated,
            'farmer_id' => auth()->id(),
            'farm_id' => $this->farm()->id,
            'status' => 'pending',
        ]);

        $this->dispatch('notify', message: 'Vet request submitted. You will be contacted shortly.');
        $this->showModal = false;
        $this->resetForm();
    }

    public function cancel(int $id): void
    {
        $this->query()->findOrFail($id)->update(['status' => 'cancelled']);
        $this->dispatch('notify', message: 'Appointment cancelled.');
    }

    public function delete(int $id): void
    {
        $this->query()->findOrFail($id)->delete();
        $this->dispatch('notify', message: 'Request removed.');
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    protected function query()
    {
        return VetAppointment::query()
            ->where('farmer_id', auth()->id())
            ->where('farm_id', $this->farm()->id);
    }

    protected function resetForm(): void
    {
        $this->data = [
            'vet_id' => '',
            'animal_id' => '',
            'service_type' => 'telemedicine',
            'scheduled_at' => now()->addDay()->format('Y-m-d\TH:i'),
            'urgency' => 'normal',
            'symptoms_description' => '',
            'fee_ugx' => 0,
        ];
        $this->resetErrorBag();
    }

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'data.vet_id' => ['required', 'exists:users,id'],
            'data.animal_id' => ['nullable', 'exists:animals,id'],
            'data.service_type' => ['required', 'in:telemedicine,farm_visit,emergency,vaccination,consultation'],
            'data.scheduled_at' => ['required', 'date', 'after:now'],
            'data.urgency' => ['required', 'in:normal,urgent,emergency'],
            'data.symptoms_description' => ['required', 'string', 'max:2000'],
            'data.fee_ugx' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    public function render()
    {
        return view('livewire.farm.vet-request-manager', [
            'farm' => $this->farm(),
            'appointments' => $this->query()->with(['animal', 'vet'])->latest('scheduled_at')->paginate(10),
            'vetOptions' => User::query()
                ->where('account_type', 'veterinarian')
                ->where('status', 'active')
                ->orderBy('name')
                ->pluck('name', 'id'),
            'animalOptions' => Animal::where('farm_id', $this->farm()->id)->orderBy('tag_number')->get()
                ->mapWithKeys(fn (Animal $a) => [$a->id => trim($a->tag_number.' '.($a->name ? "· {$a->name}" : ''))]),
            'pendingCount' => $this->query()->whereIn('status', ['pending', 'confirmed'])->count(),
        ]);
    }
}
