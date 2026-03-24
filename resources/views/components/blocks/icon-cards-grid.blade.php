@props(['metaname', 'iconsize', 'columns', 'metadescription', 'label', 'title', 'items'])

<section class="section section--dark"
    itemscope
    itemtype="https://schema.org/ItemList">
    <div class="section__decor section__decor--bottom-left">
        <img src="@image('decor1')"
            alt=""
            aria-hidden="true"
            loading="lazy">
    </div>

    <div class="section__decor section__decor--top-right">
        <img src="@image('decor2')"
            alt=""
            aria-hidden="true"
            loading="lazy">
    </div>
    <div class="container">
        <meta itemprop="name"
            content="{{ $metaname }}">
        <meta itemprop="description"
            content="{{ $metadescription }}">
        <meta itemprop="numberOfItems"
            content="{{ count($items) }}">

        <x-sections.header
            :label="$label"
            :title="$title" />

        <div class="icon-cards-grid columns{{ $columns }}">
            @foreach ($items as $item)
                <x-cards.icon-card
                    :title="$item->title"
                    :text="$item->content"
                    :iconsize="$iconsize"
                    :tags="$item->properties"
                    :icon="$item->excerpt"
                    :position="$loop->iteration" />
            @endforeach
        </div>
    </div>
</section>
