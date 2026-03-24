@props(['works', 'label', 'title'])
<style>
    .preview__portfolio-card-a {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        display: block;
    }

    .preview__portfolio-card-a img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }

    .preview__portfolio-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr;
        grid-template-rows: 260px 260px;
        gap: 16px;
    }

    .preview__portfolio-card-label {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.85) 0%, transparent 70%);
        display: flex;
        align-items: flex-end;
        padding: 28px;
    }

    .preview__portfolio-card-title {
        opacity: 0;
        font-size: 20px;
        font-weight: 400;
        color: #fff;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
        transition: opacity 0.3s ease;
    }

    .preview__portfolio-card-a:hover img {
        filter: brightness(0.5);
    }

    .preview__portfolio-card-a:hover .preview__portfolio-card-title {
        opacity: 1;
    }
</style>
<section class="section section--gray" itemscope itemtype="https://schema.org/CollectionPage">
    <div class="container">
        <x-sections.header :label="$label" :title="$title" />
        <div class="preview__portfolio-grid" itemscope itemtype="https://schema.org/ItemList">
            <meta itemprop="numberOfItems" content="{{ count($works) }}" />
            @foreach ($works as $index => $item)
                <a class="preview__portfolio-card-a" href="{{ route('portfolio.show', $item->slug) }}"
                    @if ($index === 0) style="grid-row:span 2;" @endif itemprop="itemListElement"
                    itemscope itemtype="https://schema.org/ListItem">
                    <meta itemprop="position" content="{{ $index + 1 }}" />
                    <div itemprop="item" itemscope itemtype="https://schema.org/CreativeWork">
                        <img src="{{ $item->preview->url }}" alt="{{ $item->title }}" itemprop="image" loading="lazy">
                        <div class="preview__portfolio-card-label">
                            <div>
                                <h3 class="preview__portfolio-card-title" itemprop="name">{{ $item->title }} </h3>
                                <meta itemprop="url" content="{{ route('portfolio.show', $item->slug) }}" />
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        <x-ui.btn-route-to :route="route('portfolio.index')" label="Смотреть все проекты" />
    </div>
</section>
