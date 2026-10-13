<?php

namespace App\Livewire\Vet;

use App\Models\VetAppointment;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class VetConsole extends Component
{
    use WithPagination;

    public string $statusFilter = 'active';

    public ?int $completingId = null;

    /** @var array<string, mixed> */
    public array $data = [];

    public function mount(): void
    {
        abort_unless($this->isVet(), 403);
        $this->resetForm();
    }

    public function setFilter(string $filter): void
    {
        $this->statusFilter = $filter;
        $this->resetPage();
    }

    public function confirm(int $id): void
    {
        $this->query()->findOrFail($id)->update(['status' => 'confirmed']);
        $this->dispatch('notify', message: 'Appointment confirmed.');
    }

    public function cancel(int $id): void
    {
        $this->query()->findOrFail($id)->update(['status' => 'cancelled']);
        $this->dispatch('notify', message: 'Appointment cancelled.');
    }

    public function startComplete(int $id): void
    {
        $appointment = $this->query()->findOrFail($id);

        $this->completingId = $appointment->id;
        $this->data = [
            'diagnosis' => $appointment->diagnosis,
            'prescription' => $appointment->prescription,
            'fee_ugx' => $appointment->fee_ugx,
        ];
    }

    public function complete(): void
    {
        $this->validate()['data'];

        $this->query()->findOrFail($this->completingId)->update([
            'diagnosis' => $this->data['diagnosis'],
            'prescription' => $this->data['prescription'],
            'fee_ugx' => $this->data['fee_ugx'] ?: 0,
            'status' => 'completed',
        ]);

        $this->dispatch('notify', message: 'Consultation completed.');
        $this->completingId = null;
        $this->resetForm();
    }

    public function closeModal(): void
    {
        $this->completingId = null;
        $this->resetForm();
    }

    protected function isVet(): bool
    {
        $user = auth()->user();

        return $user->account_type === 'veterinarian' || $user->hasRole('veterinarian');
    }

    protected function query()
    {
        return VetAppointment::query()->where('vet_id', auth()->id());
    }

    protected function resetForm(): void
    {
        $this->data = [
            'diagnosis' => '',
            'prescription' => '',
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
            'data.diagnosis' => ['required', 'string', 'max:2000'],
            'data.prescription' => ['nullable', 'string', 'max:2000'],
            'data.fee_ugx' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    public function render(): View
    {
        $appointments = $this->query();
        $this->applyFilter($appointments);

        return view('livewire.vet.vet-console', [
            'appointments' => $appointments
                ->with(['farmer', 'farm', 'animal'])
                ->orderByRaw("CASE urgency WHEN 'emergency' THEN 0 WHEN 'urgent' THEN 1 ELSE 2 END")
                ->orderBy('scheduled_at')
                ->paginate(9),
            'counts' => [
                'active' => $this->query()->whereIn('status', ['pending', 'confirmed'])->count(),
                'completed' => $this->query()->where('status', 'completed')->count(),
                'cancelled' => $this->query()->where('status', 'cancelled')->count(),
                'all' => $this->query()->count(),
            ],
        ]);
    }

    protected function applyFilter($query): void
    {
        match ($this->statusFilter) {
            'completed' => $query->where('status', 'completed'),
            'cancelled' => $query->where('status', 'cancelled'),
            'all' => null,
            default => $query->whereIn('status', ['pending', 'confirmed']),
        };
    }
}
