<?php

namespace App\Livewire\Farm;

use App\Livewire\Concerns\InteractsWithFarm;
use App\Models\FarmTask;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class TaskManager extends Component
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
        $task = $this->query()->findOrFail($id);

        $this->editingId = $task->id;
        $this->data = [
            'title' => $task->title,
            'category' => $task->category,
            'due_date' => optional($task->due_date)->format('Y-m-d'),
            'priority' => $task->priority,
            'status' => $task->status,
            'description' => $task->description,
            'assigned_to' => $task->assigned_to,
        ];
        $this->showModal = true;
    }

    public function save(): void
    {
        $validated = array_filter($this->validate()['data'], fn ($value) => $value !== '');

        if ($this->editingId) {
            $this->query()->findOrFail($this->editingId)->update($validated);
            $this->dispatch('notify', message: 'Task updated.');
        } else {
            FarmTask::create([...$validated, 'farm_id' => $this->farm()->id]);
            $this->dispatch('notify', message: 'Task created successfully.');
        }

        $this->showModal = false;
        $this->resetForm();
    }

    public function toggleStatus(int $id): void
    {
        $task = $this->query()->findOrFail($id);
        $task->update(['status' => $task->status === 'completed' ? 'pending' : 'completed']);
        $this->dispatch('notify', message: 'Task status updated.');
    }

    public function delete(int $id): void
    {
        $this->query()->findOrFail($id)->delete();
        $this->dispatch('notify', message: 'Task removed.');
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    protected function query()
    {
        return FarmTask::query()->where('farm_id', $this->farm()->id);
    }

    protected function resetForm(): void
    {
        $this->editingId = null;
        $this->data = [
            'title' => '',
            'category' => 'general',
            'due_date' => now()->format('Y-m-d'),
            'priority' => 'normal',
            'status' => 'pending',
            'description' => '',
            'assigned_to' => '',
        ];
        $this->resetErrorBag();
    }

    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'data.title' => ['required', 'string', 'max:200'],
            'data.category' => ['required', 'string', 'max:50'],
            'data.due_date' => ['required', 'date'],
            'data.priority' => ['required', 'in:low,normal,high,urgent'],
            'data.status' => ['required', 'in:pending,in_progress,completed,cancelled'],
            'data.description' => ['nullable', 'string', 'max:1000'],
            'data.assigned_to' => ['nullable', 'exists:users,id'],
        ];
    }

    public function render()
    {
        $farm = $this->farm();

        return view('livewire.farm.task-manager', [
            'farm' => $farm,
            'farms' => $this->availableFarms(),
            'tasks' => $this->query()->orderBy('due_date')->paginate(15),
            'memberOptions' => User::whereIn('id', function ($query) use ($farm) {
                $query->select('user_id')->from('farm_members')->where('farm_id', $farm->id);
            })->orderBy('name')->pluck('name', 'id'),
        ]);
    }
}
