@props(['status', 'type' => 'default'])

@php
$colors = [
    'published' => ['bg' => 'bg-green-100', 'text' => 'text-green-800'],
    'unpublished' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
    'archived' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800'],
    'active' => ['bg' => 'bg-green-100', 'text' => 'text-green-800'],
    'inactive' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800'],
    'open' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800'],
    'excluded' => ['bg' => 'bg-red-100', 'text' => 'text-red-800'],
    'green' => ['bg' => 'bg-green-100', 'text' => 'text-green-800'],
    'yellow' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800'],
    'red' => ['bg' => 'bg-red-100', 'text' => 'text-red-800'],
];

$color = $colors[$status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800'];
$label = ucfirst(str_replace('-', ' ', $status));
@endphp

<span class="px-2 py-1 text-xs rounded-full {{ $color['bg'] }} {{ $color['text'] }}">
    {{ $slot ?? $label }}
</span>