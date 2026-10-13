@props([
    'title' => 'No farm yet',
    'message' => 'Create your first farm to start managing livestock, production, finance and tasks.',
])

<div class="mx-auto max-w-lg px-4 py-16 text-center">
    <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-leaf-100 text-leaf-700">
        <x-ui.icon name="city" class="h-7 w-7" />
    </span>
    <h2 class="mt-4 font-display text-xl font-bold text-forest-900">{{ $title }}</h2>
    <p class="mt-2 text-sm text-leaf-600">{{ $message }}</p>
    <div class="mt-6">
        <a href="{{ url('/register') }}" class="inline-flex items-center gap-2 rounded-xl bg-leaf-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-leaf-700">
            <x-ui.icon name="plus" class="h-4 w-4" /> Set up a farm
        </a>
    </div>
</div>
