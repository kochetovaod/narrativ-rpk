# Содержимое папки: /resources/views/components/sections

Сгенерировано: 2026-02-25 11:04:56

## Структура файлов

```
resources/views/components/sections/advantages.blade.php
resources/views/components/sections/cta.blade.php
resources/views/components/sections/equipment.blade.php
resources/views/components/sections/header.blade.php
resources/views/components/sections/hero.blade.php
resources/views/components/sections/intro.blade.php
resources/views/components/sections/partners.blade.php
resources/views/components/sections/portfolio.blade.php
resources/views/components/sections/stats.blade.php
```

## Содержимое файлов

### resources/views/components/sections/advantages.blade.php

```php
    @props(['advantages', 'title', 'label'])
    <section class="section section--dark" itemscope itemtype="https://schema.org/ItemList">
        <div class="container">
            <meta itemprop="name" content="{{ $title }}">
            <meta itemprop="description" content="{{ $label }}">
            <meta itemprop="numberOfItems" content="{{ count($advantages) }}">
            <x-sections.header :label="$label" :title="$title" />
            <div class="advantages-grid">
                @foreach ($advantages as $item)
                    <div class="advantage-card" itemprop="itemListElement" itemscope
                        itemtype="https://schema.org/ListItem">
                        <meta itemprop="position" content="{{ $loop->iteration }}">
                        <div itemprop="item" itemscope itemtype="https://schema.org/Service">
                            <div class="advantage-card__icon">
                                <x-icon name="{{ $item->excerpt }}" width="28" height="28" />
                            </div>
                            <h3 class="advantage-card__title" itemprop="name">{{ $item->title }}</h3>
                            <p class="advantage-card__text" itemprop="description">{{ $item->content }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

```

### resources/views/components/sections/cta.blade.php

```php
<section class="section section--dark" itemscope itemtype="https://schema.org/ContactPage">
    <div class="container">
        <div class="cta-block" itemscope itemtype="https://schema.org/ContactPoint">
            <meta itemprop="contactType" content="customer support">
            <meta itemprop="availableLanguage" content="Russian">

            <div class="cta-block__label" itemprop="description">Готовы к сотрудничеству</div>
            <h2 class="cta-block__title" itemprop="name">Обсудим ваш проект?</h2>
            <p class="cta-block__subtitle" itemprop="description">Расскажите нам о вашем бизнесе и задачах — мы
                предложим лучшее решение и просчитаем смету.</p>

            <div class="cta-block__btns" itemprop="potentialAction" itemscope itemtype="https://schema.org/Action">
                <meta itemprop="name" content="Заказать звонок">
                <meta itemprop="description" content="Оставить заявку на обратный звонок">
                <button class="btn btn--primary btn--large" style="width:auto;" onclick="openCallbackModal()"
                    itemprop="url" content="modal:callback">Заказать звонок</button>

                <a href="{{ route('contacts') }}" class="btn btn--outline btn--large" style="width:auto;"
                    itemprop="url">Написать нам</a>
            </div>
        </div>
    </div>
</section>

```

### resources/views/components/sections/equipment.blade.php

```php
@props([
    'equipment',
    'label' => 'Наше производство',
    'title' => 'Оборудование',
    'subtitle' =>
        'Собственный цех оснащён современным оборудованием ведущих мировых брендов для любых задач производства.',
])

<style>
    .equipment__grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }

    .equipment__card_photo {
        aspect-ratio: 4/3;
        overflow: hidden;
        background: #111;
    }

    .equipment__card_photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .equipment__card_content {
        padding: 24px;
    }

    .equipment__card_title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .equipment__card_text {
        font-size: 14px;
        color: var(--color-text-dim);
    }


    @media (max-width: 1024px) {
        .equipment__grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .equipment__grid {
            grid-template-columns: 1fr;
        }
    }
</style>
<section class="section section--dark" itemscope itemtype="https://schema.org/ItemList">
    <div class="container">
        <x-sections.header :label="$label" :title="$title" :subtitle="$subtitle" />
        <meta itemprop="numberOfItems" content="{{ count($equipment) }}">
        <div class="equipment__grid">
            @foreach ($equipment as $item)
                <div class="equipment__card" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <meta itemprop="position" content="{{ $loop->index + 1 }}">
                    <div itemprop="item" itemscope itemtype="https://schema.org/HowToTool">
                        <div class="equipment__card_photo">
                            <img src="{{ $item->preview->url }}" alt="{{ $item->title }}" loading="lazy"
                                onerror="this.style.display='none'">
                        </div>
                    </div>
                    <div class="equipment__card_content">
                        <h3 class="equipment__card_title" itemprop="name">{{ $item->title }}</h3>
                        <p class="equipment__card_text" itemprop="description">{{ $item->excerpt }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <x-ui.btn-route-to :route="route('equipment')" label="Всё оборудование" />
    </div>
</section>

```

### resources/views/components/sections/header.blade.php

```php
        @props(['label', 'title', 'subtitle' => null])
        <style>
            .section-label {
                font-size: 12px;
                font-weight: 600;
                letter-spacing: 3px;
                text-transform: uppercase;
                color: var(--color-primary);
                margin-bottom: 12px;
            }

            .section-title {
                font-size: 42px;
                font-weight: 700;
                text-align: center;
                margin-bottom: 50px;
                color: var(--color-primary);
                letter-spacing: 2px;
                text-transform: uppercase;
            }

            .section-subtitle {
                font-size: 16px;
                color: var(--color-text-dim);
                max-width: 600px;
                margin: 0 auto 60px;
                text-align: center;
                line-height: 1.7;
            }

            @media (max-width: 1024px) {
                .section-title {
                    font-size: 32px;
                }
            }

            @media (max-width: 768px) {
                .section-title {
                    font-size: 32px;
                    margin-bottom: 40px;
                }
            }
        </style>
        <div class="section-label" itemprop="alternativeHeadline">{{ $label }}</div>
        <h2 class="section-title" itemprop="name headline">{{ $title }}</h2>
        @if ($subtitle !== null)
            <p class="section-subtitle" itemprop="description">{{ $subtitle }}</p>
        @endif

```

### resources/views/components/sections/hero.blade.php

```php
    @props([
        'itemtype' => 'WebPage',
        'breadcrumbItems' => [],
        'label',
        'title',
        'subtitle',
        'current',
    ])
    <style>
        .page-hero_label {
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--color-primary);
            margin-bottom: 12px;
        }

        .page-hero {
            padding: 160px 0 80px;
            background: linear-gradient(135deg, #0a0a0a 0%, #111 100%);
            border-bottom: 1px solid rgba(184, 134, 11, 0.2);
            position: relative;
            overflow: hidden;
        }

        .page-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(ellipse at 30% 50%, rgba(0, 196, 184, 0.05) 0%, transparent 60%);
            pointer-events: none;
        }

        .page-hero__title {
            font-size: 56px;
            font-weight: 700;
            color: transparent;
            text-shadow: 1px 1px 0px var(--color-primary);
            margin-bottom: 16px;
            line-height: 1.1;
        }

        .page-hero__subtitle {
            font-size: 18px;
            color: var(--color-text-dim);
            max-width: 600px;
            line-height: 1.6;
        }

        @media (max-width: 1024px) {
            .page-hero__title {
                font-size: 40px;
            }
        }

        @media (max-width: 768px) {
            .page-hero__title {
                font-size: 32px;
            }

            .page-hero {
                padding: 120px 0 60px;
            }
        }

        @media (max-width: 480px) {
            .page-hero__title {
                font-size: 26px;
            }
        }
    </style>

    <section class="page-hero" itemscope itemtype="https://schema.org/{{ $itemtype }}">
        <div class="container">
            <x-navigation.breadcrumb :items="$breadcrumbItems" :current="$current" />
            <div class="page-hero_label" itemprop="name">{{ $label }}</div>
            <h1 class="page-hero__title" itemprop="headline">{{ $title }}</h1>
            <p class="page-hero__subtitle" itemprop="description">{{ $subtitle }}</p>
        </div>
    </section>

```

### resources/views/components/sections/intro.blade.php

```php
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
            <div class="about-intro__image" itemprop="primaryImageOfPage" itemscope
                itemtype="https://schema.org/ImageObject">
                <img src="{{ $page->detail->url }}" alt="{{ $page->title }}" itemprop="contentUrl"
                    onerror="this.style='background:#111;height:400px;border-radius:8px;display:block;'">
                <meta itemprop="name" content="{{ $page->title }}">
                <meta itemprop="description" content="Изображение компании {{ $page->title }}">
                <meta itemprop="representativeOfPage" content="true">
            </div>
        </div>
    </div>
</section>

```

### resources/views/components/sections/partners.blade.php

```php
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

```

### resources/views/components/sections/portfolio.blade.php

```php
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

```

### resources/views/components/sections/stats.blade.php

```php
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

```

