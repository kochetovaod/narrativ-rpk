@props(['clients', 'label', 'title'])

<!-- Partners -->
<section class="section section--gray" itemscope="" itemtype="https://schema.org/ItemList">
    <div class="container">
        <x-sections.header :label="$label" :title="$title" />
        <div class="partners-track-wrapper">
            <div class="partners-track" itemprop="knowsAbout" itemscope itemtype="https://schema.org/ItemList">
                <meta itemprop="name" content="Партнёры компании">
                <meta itemprop="numberOfItems" content="{{ count($clients) }}">

                @foreach ($clients as $index => $client)
                    <div class="partner-logo" itemprop="itemListElement" itemscope
                        itemtype="https://schema.org/ListItem">
                        <meta itemprop="position" content="{{ $index + 1 }}">

                        <div itemprop="item" itemscope itemtype="https://schema.org/Organization">
                            <img src="{{ $client->preview->url }}" alt="{{ $client->title }}" decoding="async"
                                fetchpriority="low" loading="lazy" itemprop="logo" itemscope
                                itemtype="https://schema.org/ImageObject">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
