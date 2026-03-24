@props(['route', 'label'])
<style>
    .route-to {
        text-align: center;
        margin-top: 40px;
    }
</style>
<div class="route-to">
    <a href="{{ $route }}" class="btn btn--outline">{{ $label }} →</a>
</div>
