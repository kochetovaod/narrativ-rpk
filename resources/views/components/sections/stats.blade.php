    @props(['items'])
    <section class="section section--gray" itemscope itemtype="https://schema.org/ItemList">
        <div class="container">
            <div class="about-stats">
                <meta itemprop="name" content="Ключевые показатели компании">
                <meta itemprop="description" content="Статистика и факты о работе нашей команды">
                <meta itemprop="numberOfItems" content="{{ count($items) }}">

                @foreach ($items as $item)
                    <div class="about-stat" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <meta itemprop="position" content="{{ $loop->index + 1 }}" />
                        <div class="about-stat__num" itemprop="name">{{ $item->title }}</div>
                        <div class="about-stat__label" itemprop="description">{{ $item->excerpt }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
