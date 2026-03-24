@props(['href', 'active' => false])

@php
    $classes = 'nav__link' . ($active ? ' nav__link--active' : '');
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
