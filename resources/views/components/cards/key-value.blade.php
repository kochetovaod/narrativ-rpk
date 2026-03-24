@props(['items'])
@if (is_string($items) && !empty($items))
    @php
        $items = json_decode($items, true);
    @endphp
@endif
<div class="cards-grid">
    @foreach ($items as $index => $item)
        <div data-index="{{ $index }}"
            class="info_card {{ (floor($index / 2) + ($index % 2)) % 2 == 0 ? 'primary' : 'gold' }}">
            <div class="info_card-value">{{ $item['value'] }}</div>
            <div class="info_card-key">{{ $item['key'] }}</div>
        </div>
    @endforeach
</div>
