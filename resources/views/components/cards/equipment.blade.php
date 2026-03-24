@props(['item', 'i'])
<div class="equipment-card">
    <div class="equipment-card__image">
        <img src="{{ $item->detail->url }}"
            alt="{{ $item->title }}"
            loading="lazy">
        <span class="equipment-card__badge">{{ $item->category->badge() }}</span>
    </div>
    <div class="equipment-card__body">
        <div class="equipment-card__num">
            {{ str_pad($i, 2, '0', STR_PAD_LEFT) }} /
            {{ $item->category->label() }}
        </div>
        <h3 class="equipment-card__title">{{ $item->title }}</h3>
        <div class="equipment-card__maker">
            Производитель: {{ $item->manufacturer }} · Год ввода: {{ $item->year }}
        </div>
        <p class="equipment-card__desc">{{ $item->content }}</p>
        <div class="equipment-card__specs">
            @foreach ($item->properties ?? [] as $property)
                <div class="spec-item">
                    <div class="spec-item__label">{{ $property['label'] }}</div>
                    <div class="spec-item__value">{{ $property['value'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>
