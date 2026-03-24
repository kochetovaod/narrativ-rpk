@props(['title'])

<div class="footer__column">
    <h4 class="footer__heading">{{ $title }}</h4>
    <ul class="footer__links">
        {{ $slot }}
    </ul>
</div>
