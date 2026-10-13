<div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="font-display text-2xl font-bold text-forest-900">Tasks &amp; Reminders</h1>
            <p class="text-sm text-leaf-600">Chores and follow-ups for {{ $farm->name }}.</p>
        </div>
        <button wire:click="create" class="inline-flex items-center gap-2 rounded-xl bg-leaf-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-leaf-700">
            <x-ui.icon name="plus" class="h-4 w-4" /> Create Task
        </button>
    </div>

    <div class="mt-6 overflow-hidden rounded-2xl border border-sand-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-sand-100 text-sm">
            <thead class="bg-sand-50 text-left text-xs font-semibold uppercase tracking-wider text-leaf-600">
                <tr>
                    <th class="px-4 py-3">Task</th>
                    <th class="px-4 py-3">Category</th>
                    <th class="px-4 py-3">Due</th>
                    <th class="px-4 py-3">Priority</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-sand-100">
                @forelse ($tasks as $task)
                    @php
                        $priorityTone = match($task->priority) {
                            'urgent', 'high' => 'bg-berry-100 text-berry-700',
                            'low' => 'bg-slate-100 text-slate-600',
                            default => 'bg-gold-100 text-gold-700',
                        };
                        $isDone = $task->status === 'completed';
                    @endphp
                    <tr wire:key="task-{{ $task->id }}" class="hover:bg-sand-50/60">
                        <td class="px-4 py-3">
                            <p class="font-medium text-forest-900 {{ $isDone ? 'line-through opacity-60' : '' }}">{{ $task->title }}</p>
                            @if ($task->description)
                                <p class="text-xs text-leaf-500">{{ \Illuminate\Support\Str::limit($task->description, 60) }}</p>
                            @endif
                        </td>
                        <td class="px-4 py-3 capitalize text-leaf-700">{{ $task->category }}</td>
                        <td class="px-4 py-3 {{ $task->due_date?->isPast() && ! $isDone ? 'font-semibold text-berry-600' : 'text-leaf-700' }}">
                            {{ optional($task->due_date)->format('d M Y') }}
                        </td>
                        <td class="px-4 py-3">
                            <span class="rounded-full px-2.5 py-0.5 text-xs font-semibold capitalize {{ $priorityTone }}">{{ $task->priority }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <button wire:click="toggleStatus({{ $task->id }})" class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-xs font-semibold capitalize {{ $isDone ? 'bg-emerald-100 text-emerald-700' : 'bg-sand-200 text-leaf-700' }}">
                                {{ str_replace('_', ' ', $task->status) }}
                            </button>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button wire:click="edit({{ $task->id }})" class="text-xs font-semibold text-leaf-600 hover:text-leaf-800">Edit</button>
                            <button wire:click="delete({{ $task->id }})" wire:confirm="Remove this task?" class="ml-3 text-xs font-semibold text-berry-600 hover:text-berry-800">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-10 text-center text-leaf-600">No tasks yet. Create your first chore or reminder.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $tasks->links() }}</div>

    @if ($showModal)
        <div class="fixed inset-0 z-[80] flex items-start justify-center overflow-y-auto bg-forest-950/50 p-4 sm:p-8">
            <div class="w-full max-w-xl rounded-2xl bg-white shadow-2xl">
                <div class="flex items-center justify-between border-b border-sand-100 px-6 py-4">
                    <h2 class="font-display text-lg font-bold text-forest-900">{{ $editingId ? 'Edit Task' : 'Create Task' }}</h2>
                    <button wire:click="closeModal" class="text-leaf-500 hover:text-leaf-800"><x-ui.icon name="close" class="h-5 w-5" /></button>
                </div>

                <form wire:submit="save" class="grid gap-4 px-6 py-5 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label class="form-label">Title <span class="text-berry-500">*</span></label>
                        <input type="text" wire:model="data.title" class="form-input">
                        @error('data.title') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Category</label>
                        <input type="text" wire:model="data.category" class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Due date <span class="text-berry-500">*</span></label>
                        <input type="date" wire:model="data.due_date" class="form-input">
                        @error('data.due_date') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Priority</label>
                        <select wire:model="data.priority" class="form-input">
                            @foreach (['low', 'normal', 'high', 'urgent'] as $option)
                                <option value="{{ $option }}">{{ ucfirst($option) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Status</label>
                        <select wire:model="data.status" class="form-input">
                            @foreach (['pending', 'in_progress', 'completed', 'cancelled'] as $option)
                                <option value="{{ $option }}">{{ ucfirst(str_replace('_', ' ', $option)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Assign to (optional)</label>
                        <select wire:model="data.assigned_to" class="form-input">
                            <option value="">—</option>
                            @foreach ($memberOptions as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="form-label">Description</label>
                        <textarea wire:model="data.description" rows="2" class="form-input"></textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 border-t border-sand-100 pt-4 sm:col-span-2">
                        <button type="button" wire:click="closeModal" class="rounded-xl px-4 py-2 text-sm font-semibold text-leaf-700 hover:bg-sand-100">Cancel</button>
                        <button type="submit" class="rounded-xl bg-leaf-600 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-leaf-700">
                            <span wire:loading.remove wire:target="save">Save</span>
                            <span wire:loading wire:target="save">Saving…</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
