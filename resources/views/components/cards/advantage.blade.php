@props(['item', 'position' => 1, 'iconSize' => 28])

<div class="advantage-card"
    itemprop="itemListElement"
    itemscope
    itemtype="https://schema.org/ListItem">

    <meta itemprop="position" content="{{ $position }}">

    <div itemprop="item"
        itemscope
        itemtype="https://schema.org/Service"
        class="advantage-card__content">

        <meta itemprop="name" content="{{ $item->title }}">
        <meta itemprop="description" content="{{ Str::limit(strip_tags($item->content), 200) }}">
        <meta itemprop="serviceType" content="Преимущество компании">
        <meta itemprop="provider" content="{{ setting('site_name') }}">

        <div class="advantage-card__icon" aria-hidden="true">
            <x-icon
                :name="$item->excerpt"
                :width="$iconSize"
                :height="$iconSize" />
        </div>

        {{-- Заголовок --}}
        <h3 class="advantage-card__title" itemprop="name">
            {{ $item->title }}
        </h3>

        {{-- Описание --}}
        @if ($item->content)
            <p class="advantage-card__text" itemprop="description">
                {{ $item->content }}
            </p>
        @endif
    </div>
</div>
