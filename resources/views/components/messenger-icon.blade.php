@props(['href', 'type', 'ariaLabel' => null])

<a href="{{ $href }}" class="messenger-icon {{ $type }}" aria-label="{{ $ariaLabel ?? $type }}"
    target="_blank" rel="noopener noreferrer">
    <x-icon :name="$type" width="24" height="24" class="messenger-icon" />
</a>
