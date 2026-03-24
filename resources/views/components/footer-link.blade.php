@props(['href'])

<li>
    <a href="{{ $href }}" {{ $attributes }}>
        {{ $slot }}
    </a>
</li>
