@props(['name', 'label' => null, 'value' => '', 'rows' => 5, 'required' => false])

<div class="mb-4">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">
            {{ $label }}
            @if($required) <span class="text-red-500">*</span> @endif
        </label>
    @endif
    <textarea 
        name="{{ $name }}" 
        id="{{ $name }}"
        rows="{{ $rows }}"
        {{ $attributes->merge(['class' => 'w-full border-gray-300 rounded-md shadow-sm focus:ring-maroon-500 focus:border-maroon-500']) }}
        @if($required) required @endif
    >{{ old($name, $value) }}</textarea>
    @error($name)
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>