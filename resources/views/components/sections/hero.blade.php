    @props([
        'itemtype' => 'WebPage',
        'breadcrumbItems' => [],
        'label',
        'title',
        'subtitle',
        'current',
        'image',
    ])
    <div class="article-hero">
        <img class="article-hero__img" src="{{ $image }}"
            onerror="this.parentElement.style.background='#111'">
        <div class="article-hero__overlay"></div>
        <section class="page-hero article-hero__content" itemscope itemtype="https://schema.org/{{ $itemtype }}">
            <div class="container">
                <x-navigation.breadcrumb :items="$breadcrumbItems" :current="$current" />
                <div class="page-hero_label" itemprop="name">{{ $label }}</div>
                <h1 class="page-hero__title" itemprop="headline">{{ $title }}</h1>
                <p class="page-hero__subtitle" itemprop="description">{{ $subtitle }}</p>
            </div>
        </section>
    </div>
