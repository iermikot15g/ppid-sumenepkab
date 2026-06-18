@props(['name', 'label' => null, 'accept' => '*', 'required' => false])

<div class="mb-4">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">
            {{ $label }}
            @if($required) <span class="text-red-500">*</span> @endif
        </label>
    @endif
    <input 
        type="file" 
        name="{{ $name }}" 
        id="{{ $name }}"
        accept="{{ $accept }}"
        {{ $attributes->merge(['class' => 'w-full border-gray-300 rounded-md shadow-sm']) }}
        @if($required) required @endif
    />
    @error($name)
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>