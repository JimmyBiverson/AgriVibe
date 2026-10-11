@props(['label' => null, 'name' => null, 'options' => [], 'placeholder' => null, 'required' => false, 'selected' => null, 'error' => null])

<div>
    @if ($label)
        <label for="{{ $name }}" class="mb-1.5 block text-sm font-medium text-leaf-900">{{ $label }}
            @if ($required)
                <span class="text-berry-500">*</span>
            @endif
        </label>
    @endif
    <select
        name="{{ $name }}"
        id="{{ $name }}"
        @if ($required) required @endif
        {{ $attributes->merge(['class' => 'block w-full rounded-lg border-0 bg-white px-3.5 py-2.5 text-sm text-leaf-950 shadow-sm ring-1 ring-inset ring-sand-300 focus:ring-2 focus:ring-inset focus:ring-leaf-500']) }}
    >
        @if ($placeholder)
            <option value="" disabled @selected(old($name, $selected) === null)>{{ $placeholder }}</option>
        @endif
        @foreach ($options as $key => $value)
            <option value="{{ $key }}" @selected(old($name, $selected) == $key)>{{ $value }}</option>
        @endforeach
    </select>
    @error($name)
        <p class="mt-1.5 text-xs font-medium text-berry-500">{{ $message }}</p>
    @enderror
</div>