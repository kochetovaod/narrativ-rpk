@props(['title', 'text', 'tags', 'icon', 'position' => 1, 'iconsize' => 28])

<div class="icon-card-item"
    itemprop="itemListElement"
    itemscope
    itemtype="https://schema.org/ListItem">

    <meta itemprop="position" content="{{ $position }}">
    <div class="icon-card-item__icon">
        <x-icon
            :name="$icon"
            :width="$iconsize"
            :height="$iconsize" />
    </div>
    <div>
        <div class="icon-card-item__title">{{ $title }}</div>
        <div class="icon-card-item__text">{{ $text }}</div>
        <div class="icon-card-item__tags">
            @if ($tags)
                @foreach ($tags as $tag)
                    <span class="icon-card-item__tag">{{ $tag }}</span>
                @endforeach
            @endif
        </div>
    </div>
</div>
