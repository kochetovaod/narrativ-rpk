@props(['page'])
<section class="section section--dark" itemscope itemtype="https://schema.org/AboutPage">
    <div class="container">
        <div class="about-intro">
            <div class="about-intro__text" itemprop="mainEntity" itemscope itemtype="https://schema.org/Organization">
                <div class="section-label" itemprop="slogan">{{ $page->excerpt }}</div>
                <div itemprop="description">{!! $page->content !!}</div>
                <div style="display:flex; gap:16px; margin-top:32px; flex-wrap:wrap;" itemprop="potentialAction"
                    itemscope itemtype="https://schema.org/Action">
                    <meta itemprop="name" content="Просмотр каталога">
                    <meta itemprop="description" content="Перейти в каталог продукции">
                    <a href="{{ route('catalog.index') }}" class="btn btn--primary" itemprop="url">Каталог продукции</a>
                    <a href="{{ route('contacts') }}" class="btn btn--outline">Связаться с нами</a>
                </div>
            </div>
            {{ $slot }}
        </div>
    </div>
</section>
