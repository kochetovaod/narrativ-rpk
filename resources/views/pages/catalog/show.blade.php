@extends('layouts.app')

@section('title', $product->title . ' — ' . $category->title . ' — SLP')

@section('content')

    {{-- ======================== HERO ТОВАРА ======================== --}}
    <section class="section product-hero-section">
        <div class="container">
            <x-navigation.breadcrumb
                :items="[
                    [
                        'url' => route('catalog.index'),
                        'title' => 'Каталог',
                    ],
                    [
                        'url' => route('catalog.category', $category->slug),
                        'title' => $category->title,
                    ],
                ]"
                :current="$product->title" />



            <div class="product-hero">
                {{-- Галерея --}}
                <div class="product-gallery">
                    <div class="product-gallery__main">
                        @if ($product->detail)
                            <img src="{{ $product->detail->url }}" alt="{{ $product->title }}" id="galleryMain"
                                loading="eager">
                        @elseif($product->preview)
                            <img src="{{ $product->preview->url }}" alt="{{ $product->title }}" id="galleryMain"
                                loading="eager">
                        @else
                            <div class="product-gallery__placeholder">
                                <svg width="64" height="64" fill="none" stroke="currentColor" stroke-width="1"
                                    viewBox="0 0 24 24" opacity="0.2">
                                    <rect x="3" y="3" width="18" height="18" rx="2" />
                                    <circle cx="8.5" cy="8.5" r="1.5" />
                                    <path d="m21 15-5-5L5 21" />
                                </svg>
                            </div>
                        @endif
                        {{-- Бейджи фильтров --}}
                        <div class="product-hero__labels">
                            @foreach ($product->filterValues->take(3) as $fv)
                                <span class="product-label product-label--popular">{{ $fv->value }}</span>
                            @endforeach
                        </div>
                    </div>

                    {{-- Дополнительные миниатюры (если есть прикреплённые файлы) --}}
                    @if ($product->attachment && $product->attachment->count() > 1)
                        <div class="product-gallery__thumbs">
                            @foreach ($product->attachment->take(5) as $i => $att)
                                <button class="gallery-thumb @if ($i === 0) active @endif"
                                    onclick="switchGallery(this, '{{ $att->url }}')"
                                    type="button">
                                    <img src="{{ $att->url }}" alt="">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Инфо --}}
                <div class="product-info">
                    <div class="product-info__type">{{ $category->title }}</div>
                    <h1 class="product-info__title">{{ $product->title }}</h1>
                    <p class="product-info__excerpt">{{ $product->excerpt }}</p>

                    {{-- Ключевые характеристики --}}
                    @if ($product->properties)
                        <div class="product-info__props">
                            @foreach (json_decode($product->properties) as $key => $val)
                                @if ($val && !is_bool($val))
                                    <div class="product-prop">
                                        <span class="product-prop__key">{{ ucfirst(str_replace('_', ' ', $key)) }}</span>
                                        <span class="product-prop__val">{{ $val }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif

                    {{-- Цена --}}
                    @if ($product->price_from)
                        <div class="product-info__price">
                            <span class="product-info__price-label">Стоимость от</span>
                            <span class="product-info__price-val">{{ number_format($product->price_from, 0, '.', ' ') }}
                                ₽</span>
                        </div>
                    @endif

                    {{-- CTA --}}
                    <div class="product-info__actions">
                        <a href="#consult" class="btn btn--primary btn--lg">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                            </svg>
                            Рассчитать стоимость
                        </a>
                        <a href="tel:+78462000000" class="btn btn--outline btn--lg">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path
                                    d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 10.8a19.79 19.79 0 01-3.07-8.64A2 2 0 012 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 14.92v2z" />
                            </svg>
                            Позвонить
                        </a>
                    </div>

                    {{-- Гарантии-иконки --}}
                    <div class="product-guarantees">
                        <div class="product-guarantee">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                            </svg>
                            Гарантия на работы
                        </div>
                        <div class="product-guarantee">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path d="M3 21V8l9-6 9 6v13M9 21V12h6v9" />
                            </svg>
                            Собственное производство
                        </div>
                        <div class="product-guarantee">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 6v6l4 2" />
                            </svg>
                            Монтаж под ключ
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ======================== ТАБЫ ======================== --}}
    <section class="section product-tabs-section">
        <div class="container">
            <div class="tabs-nav">
                <button class="tab-btn active" onclick="switchTab('desc', this)">Описание</button>
                <button class="tab-btn" onclick="switchTab('chars', this)">Характеристики</button>
                <button class="tab-btn" onclick="switchTab('works', this)">Примеры работ</button>
            </div>

            {{-- Таб 1: Описание --}}
            <div class="tab-content active" id="tab-desc">
                <div class="tab-prose">
                    @if ($product->content)
                        {!! $product->content !!}
                    @else
                        <p>{{ $product->excerpt }}</p>
                    @endif
                </div>
            </div>

            {{-- Таб 2: Характеристики --}}
            <div class="tab-content" id="tab-chars">
                @if ($product->properties)
                    <div class="chars-table">
                        @foreach (json_decode($product->properties) as $key => $val)
                            <div class="chars-row">
                                <span class="chars-row__key">{{ ucfirst(str_replace('_', ' ', $key)) }}</span>
                                <span class="chars-row__dots"></span>
                                <span class="chars-row__val">
                                    @if (is_bool($val))
                                        {{ $val ? 'Да' : 'Нет' }}
                                    @else
                                        {{ $val }}
                                    @endif
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="tab-empty">Характеристики уточняются. Свяжитесь с нами для получения точных данных.</p>
                @endif
            </div>

            {{-- Таб 4: Примеры работ --}}
            <div class="tab-content" id="tab-works">
                @if (isset($portfolios) && $portfolios->count())
                    <div class="works-grid">
                        @foreach ($portfolios as $portfolio)
                            <a href="{{ route('portfolio.show', $portfolio->slug) }}" class="work-item">
                                @if ($portfolio->preview)
                                    <img src="{{ $portfolio->preview->url }}" alt="{{ $portfolio->title }}"
                                        loading="lazy">
                                @endif
                                <div class="work-item__overlay">
                                    <span class="work-item__title">{{ $portfolio->title }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="tab-empty">Примеры работ по данному решению скоро появятся. Посмотрите <a
                            href="{{ route('portfolio.index') }}">все наши проекты</a>.</p>
                @endif
            </div>
        </div>
    </section>

    {{-- ======================== ПОХОЖИЕ РЕШЕНИЯ ======================== --}}
    @if (isset($related) && $related->count())
        <section class="section section--dark">
            <div class="container">
                <div class="section-header">
                    <div class="section-label">Также выбирают</div>
                    <h2 class="section-title">Похожие решения</h2>
                </div>
                <div class="product-grid">
                    @foreach ($related->take(3) as $rel)
                        <article class="product-card">
                            <div class="product-card__image">
                                @if ($rel->preview)
                                    <img src="{{ $rel->preview->url }}" alt="{{ $rel->title }}" loading="lazy">
                                @endif
                            </div>
                            <div class="product-card__body">
                                <div class="product-card__type">{{ $category->title }}</div>
                                <h3 class="product-card__title">{{ $rel->title }}</h3>
                                <p class="product-card__desc">{{ $rel->excerpt }}</p>
                                <div class="product-card__footer">
                                    <div class="product-card__price">
                                        @if ($rel->price_from)
                                            <strong>от {{ number_format($rel->price_from, 0, '.', ' ') }} ₽</strong>
                                        @else
                                            <strong>По запросу</strong>
                                        @endif
                                    </div>
                                    <a href="{{ route('catalog.show', [$category->slug, $rel->slug]) }}"
                                        class="product-card__order">
                                        Подробнее
                                        <svg width="14" height="14" fill="none" stroke="currentColor"
                                            stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M5 12h14M12 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection

@push('styles')
    <style>
        /* ===== PRODUCT HERO ===== */
        .product-hero-section {
            padding-top: 100px;
        }


        .product-hero {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: start;
        }

        /* ===== GALLERY ===== */
        .product-gallery__main {
            border-radius: 16px;
            overflow: hidden;
            background: #0c0c0c;
            aspect-ratio: 4/3;
            position: relative;
        }

        .product-gallery__main img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-gallery__placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-hero__labels {
            position: absolute;
            top: 16px;
            left: 16px;
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .product-gallery__thumbs {
            display: flex;
            gap: 10px;
            margin-top: 12px;
        }

        .gallery-thumb {
            width: 72px;
            height: 52px;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid transparent;
            cursor: pointer;
            padding: 0;
            background: none;
            transition: border-color 0.2s;
        }

        .gallery-thumb.active,
        .gallery-thumb:hover {
            border-color: var(--color-primary);
        }

        .gallery-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* ===== PRODUCT INFO ===== */
        .product-info__type {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--color-primary);
            margin-bottom: 12px;
        }

        .product-info__title {
            font-size: clamp(26px, 3vw, 40px);
            font-weight: 800;
            color: #fff;
            line-height: 1.15;
            letter-spacing: -0.5px;
            margin-bottom: 16px;
        }

        .product-info__excerpt {
            font-size: 15px;
            color: var(--color-text-dim);
            line-height: 1.7;
            margin-bottom: 28px;
        }

        .product-info__props {
            display: flex;
            flex-direction: column;
            gap: 0;
            margin-bottom: 28px;
            border: 1px solid rgba(184, 134, 11, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .product-prop {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 11px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
        }

        .product-prop:last-child {
            border-bottom: none;
        }

        .product-prop:nth-child(odd) {
            background: rgba(255, 255, 255, 0.01);
        }

        .product-prop__key {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.4);
        }

        .product-prop__val {
            font-size: 13px;
            font-weight: 600;
            color: #fff;
        }

        .product-info__price {
            margin-bottom: 28px;
        }

        .product-info__price-label {
            display: block;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.3);
            margin-bottom: 4px;
        }

        .product-info__price-val {
            font-size: 36px;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.5px;
        }

        .product-info__actions {
            display: flex;
            gap: 12px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .btn--lg {
            padding: 14px 28px;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .product-guarantees {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .product-guarantee {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.35);
        }

        .product-guarantee svg {
            color: var(--color-primary);
            opacity: 0.7;
        }

        /* ===== TABS ===== */
        .product-tabs-section {
            padding-top: 0;
        }

        .tabs-nav {
            display: flex;
            gap: 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            margin-bottom: 40px;
            overflow-x: auto;
        }

        .tab-btn {
            padding: 14px 24px;
            background: none;
            border: none;
            border-bottom: 2px solid transparent;
            margin-bottom: -1px;
            color: rgba(255, 255, 255, 0.4);
            font-size: 14px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            white-space: nowrap;
            transition: all 0.2s;
        }

        .tab-btn:hover {
            color: rgba(255, 255, 255, 0.7);
        }

        .tab-btn.active {
            color: var(--color-primary);
            border-bottom-color: var(--color-primary);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* Таб: Описание */
        .tab-prose {
            max-width: 800px;
            font-size: 15px;
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.8;
        }

        .tab-prose p {
            margin-bottom: 16px;
        }

        .tab-prose ul {
            padding-left: 20px;
            margin-bottom: 16px;
        }

        .tab-prose li {
            margin-bottom: 8px;
        }

        .tab-prose h2,
        .tab-prose h3 {
            color: #fff;
            margin: 28px 0 12px;
        }

        /* Таб: Характеристики */
        .chars-table {
            max-width: 640px;
        }

        .chars-row {
            display: flex;
            align-items: baseline;
            gap: 8px;
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .chars-row:last-child {
            border-bottom: none;
        }

        .chars-row__key {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.4);
            min-width: 180px;
            flex-shrink: 0;
        }

        .chars-row__dots {
            flex: 1;
            height: 1px;
            border-bottom: 1px dotted rgba(255, 255, 255, 0.1);
        }

        .chars-row__val {
            font-size: 14px;
            font-weight: 600;
            color: #fff;
            text-align: right;
        }

        /* Таб: Работы */
        .works-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .work-item {
            display: block;
            border-radius: 10px;
            overflow: hidden;
            aspect-ratio: 4/3;
            position: relative;
        }

        .work-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .work-item:hover img {
            transform: scale(1.06);
        }

        .work-item__overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
            opacity: 0;
            transition: opacity 0.3s;
            display: flex;
            align-items: flex-end;
            padding: 16px;
        }

        .work-item:hover .work-item__overlay {
            opacity: 1;
        }

        .work-item__title {
            font-size: 13px;
            font-weight: 600;
            color: #fff;
        }




        .tab-empty {
            font-size: 15px;
            color: rgba(255, 255, 255, 0.3);
            padding: 40px 0;
        }

        .tab-empty a {
            color: var(--color-primary);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1024px) {
            .product-hero {
                grid-template-columns: 1fr;
                gap: 36px;
            }
        }

        @media (max-width: 768px) {
            .works-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .tabs-nav {
                gap: 0;
            }

            .tab-btn {
                padding: 12px 16px;
                font-size: 13px;
            }

            .chars-row__key {
                min-width: 130px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // ===== TABS =====
        function switchTab(id, btn) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
            document.getElementById('tab-' + id).classList.add('active');
            btn.classList.add('active');
        }

        // ===== GALLERY =====
        function switchGallery(btn, src) {
            document.getElementById('galleryMain').src = src;
            document.querySelectorAll('.gallery-thumb').forEach(t => t.classList.remove('active'));
            btn.classList.add('active');
        }
    </script>
@endpush
