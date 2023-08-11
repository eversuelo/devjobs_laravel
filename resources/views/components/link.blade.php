@php
    $classes = 'text-sm text-sm text-gray-600 hover:text-gray-900 my-3';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
