@props(['label' => null, 'name' => null, 'rows' => 4, 'required' => false, 'hint' => null, 'error' => null])

<div>
    @if ($label)
        <label for="{{ $name }}" class="mb-1.5 block text-sm font-medium text-leaf-900">{{ $label }}
            @if ($required)
                <span class="text-berry-500">*</span>
            @endif
        </label>
    @endif
    <textarea
        name="{{ $name }}"
        id="{{ $name }}"
        rows="{{ $rows }}"
        @if ($required) required @endif
        {{ $attributes->merge(['class' => 'block w-full rounded-lg border-0 bg-white px-3.5 py-2.5 text-sm text-leaf-950 shadow-sm ring-1 ring-inset ring-sand-300 placeholder:text-leaf-800/40 focus:ring-2 focus:ring-inset focus:ring-leaf-500']) }}
    >{{ old($name) }}</textarea>
    @if ($hint && !$error)
        <p class="mt-1.5 text-xs text-leaf-800/60">{{ $hint }}</p>
    @endif
    @error($name)
        <p class="mt-1.5 text-xs font-medium text-berry-500">{{ $message }}</p>
    @enderror
</div>