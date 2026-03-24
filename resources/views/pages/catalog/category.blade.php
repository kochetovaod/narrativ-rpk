@extends('layouts.app')

@section('title', $category->title . ' — Каталог — SLP')

@section('content')

    {{-- ======================== HERO КАТЕГОРИИ ======================== --}}
    <section class="section cat-hero-section">
        <div class="container">
            {{-- Хлебные крошки --}}
            <nav class="breadcrumbs">
                <a href="{{ route('catalog.index') }}">Каталог</a>
                <span class="breadcrumbs__sep">—</span>
                <span>{{ $category->title }}</span>
            </nav>

            <div class="cat-intro">
                <div class="cat-intro__content">
                    <div class="section-label">{{ $category->title }}</div>
                    <h1 class="section-title">{{ $category->title }} на заказ</h1>
                    <div class="cat-intro__text">
                        {!! $category->excerpt !!}
                    </div>
                    <div class="cat-intro__actions">
                        <a href="#consult" class="btn btn--primary">Получить консультацию</a>
                        <a href="#products" class="btn btn--outline">Смотреть варианты</a>
                    </div>
                </div>

                {{-- Карточки преимуществ категории --}}
                <div class="cat-intro__features">
                    <div class="cat-feature">
                        <div class="cat-feature__icon">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path d="M3 21V8l9-6 9 6v13M9 21V12h6v9" />
                            </svg>
                        </div>
                        <div>
                            <div class="cat-feature__title">Своё производство</div>
                            <div class="cat-feature__text">Изготавливаем на собственном оборудовании</div>
                        </div>
                    </div>
                    <div class="cat-feature">
                        <div class="cat-feature__icon">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 6v6l4 2" />
                            </svg>
                        </div>
                        <div>
                            <div class="cat-feature__title">Сроки от 5 дней</div>
                            <div class="cat-feature__text">Срочное производство доступно</div>
                        </div>
                    </div>
                    <div class="cat-feature">
                        <div class="cat-feature__icon">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                            </svg>
                        </div>
                        <div>
                            <div class="cat-feature__title">Гарантия</div>
                            <div class="cat-feature__text">На все виды работ и материалы</div>
                        </div>
                    </div>
                    <div class="cat-feature">
                        <div class="cat-feature__icon">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path d="M9 11l3 3L22 4M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11" />
                            </svg>
                        </div>
                        <div>
                            <div class="cat-feature__title">Монтаж под ключ</div>
                            <div class="cat-feature__text">С согласованием при необходимости</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ======================== ПРОДУКТЫ + ФИЛЬТРЫ ======================== --}}
    <section class="section" id="products">
        <div class="container">
            <div class="cat-layout">

                {{-- ---- ФИЛЬТРЫ ---- --}}
                <aside class="filters-panel" id="filters-sidebar">
                    <form id="filter-form" method="GET" action="{{ route('catalog.category', $category->slug) }}">

                        @foreach ($category->filters as $filter)
                            <div class="filter-block">
                                <div class="filter-block__title">
                                    {{ $filter->title }}
                                    <span>›</span>
                                </div>
                                @foreach ($filter->values->where('active', true) as $value)
                                    <label class="filter-option">
                                        <input
                                            type="checkbox"
                                            name="filters[{{ $filter->code }}][]"
                                            value="{{ $value->id }}"
                                            @if (in_array($value->id, (array) request('filters.' . $filter->code, []))) checked @endif
                                            onchange="document.getElementById('filter-form').submit()">
                                        <span class="filter-option__label">{{ $value->value }}</span>
                                        <span class="filter-option__count">{{ $value->products->count() }}</span>
                                    </label>
                                @endforeach
                            </div>
                        @endforeach

                        @if (request()->has('filters'))
                            <a href="{{ route('catalog.category', $category->slug) }}" class="filter-apply-btn"
                                style="display:block; text-align:center; text-decoration:none;">
                                Сбросить фильтры
                            </a>
                        @endif

                    </form>
                </aside>

                {{-- ---- СПИСОК ТОВАРОВ ---- --}}
                <div class="cat-content">

                    {{-- Toolbar --}}
                    <div class="cat-toolbar">
                        <div class="cat-toolbar__count">
                            Найдено: <strong>{{ $products->count() }}</strong>
                        </div>
                        <div class="cat-toolbar__right">
                            <select class="sort-select" onchange="window.location=this.value">
                                <option value="{{ request()->fullUrlWithQuery(['sort' => 'sort']) }}"
                                    @selected(request('sort', 'sort') === 'sort')>По умолчанию</option>
                                <option value="{{ request()->fullUrlWithQuery(['sort' => 'title']) }}"
                                    @selected(request('sort') === 'title')>По названию</option>
                            </select>
                        </div>
                    </div>

                    {{-- Сетка товаров --}}
                    @if ($products->count())
                        <div class="product-grid">
                            @foreach ($products as $product)
                                <article class="product-card">
                                    <div class="product-card__image">
                                        @if ($product->preview)
                                            <img src="{{ $product->preview->url }}" alt="{{ $product->title }}"
                                                loading="lazy">
                                        @endif
                                        <div class="product-card__quick">
                                            <button class="quick-view-btn" type="button"
                                                data-id="{{ $product->id }}"
                                                data-title="{{ $product->title }}"
                                                data-excerpt="{{ $product->excerpt }}"
                                                data-img="{{ $product->preview->url ?? '' }}"
                                                data-props="{{ json_encode($product->properties) }}"
                                                onclick="openQuickView(this)">
                                                Быстрый просмотр
                                            </button>
                                        </div>
                                        {{-- Бейджи фильтров --}}
                                        <div class="product-card__labels">
                                            @foreach ($product->filterValues->take(2) as $fv)
                                                <span
                                                    class="product-label product-label--popular">{{ $fv->value }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="product-card__body">
                                        <div class="product-card__type">{{ $category->title }}</div>
                                        <h2 class="product-card__title">{{ $product->title }}</h2>
                                        <p class="product-card__desc">{{ $product->excerpt }}</p>
                                        @if ($product->properties)
                                            <div class="product-card__params">

                                                @foreach (json_decode($product->properties) as $key => $val)
                                                    @if ($val && !is_bool($val))
                                                        <span class="param-tag">{{ $val }}</span>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif
                                        <div class="product-card__footer">
                                            @if ($product->price_from)
                                                <div class="product-card__price">
                                                    <span>от</span>
                                                    <strong>{{ number_format($product->price_from, 0, '.', ' ') }}
                                                        ₽</strong>
                                                </div>
                                            @else
                                                <div class="product-card__price">
                                                    <strong>Цена по запросу</strong>
                                                </div>
                                            @endif
                                            <a href="{{ route('catalog.show', ['category' => $category->slug, 'product' => $product->slug]) }}"
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
                    @else
                        <div class="empty-state">
                            <div class="empty-state__icon">
                                <svg width="48" height="48" fill="none" stroke="currentColor"
                                    stroke-width="1" viewBox="0 0 24 24">
                                    <circle cx="11" cy="11" r="8" />
                                    <path d="m21 21-4.35-4.35" />
                                </svg>
                            </div>
                            <h3>Ничего не найдено</h3>
                            <p>Попробуйте изменить или сбросить фильтры</p>
                            <a href="{{ route('catalog.category', $category->slug) }}" class="btn btn--outline">Сбросить
                                фильтры</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- ======================== SEO ТЕКСТ ======================== --}}
    @if ($category->content)
        <section class="section section--dark">
            <div class="container">
                <div class="seo-block">
                    <div class="seo-block__content">
                        {!! $category->content !!}
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- ======================== КЕЙСЫ КАТЕГОРИИ ======================== --}}
    @if (isset($portfolios) && $portfolios->count())
        <section class="section">
            <div class="container">
                <div class="section-header">
                    <div class="section-label">Наши работы</div>
                    <h2 class="section-title">Примеры {{ mb_strtolower($category->title) }}</h2>
                </div>
                <div class="cases-grid">
                    @foreach ($portfolios->take(6) as $portfolio)
                        <a href="{{ route('portfolio.show', $portfolio->slug) }}" class="case-card">
                            <div class="case-card__image">
                                @if ($portfolio->preview)
                                    <img src="{{ $portfolio->preview->url }}" alt="{{ $portfolio->title }}"
                                        loading="lazy">
                                @endif
                            </div>
                            <div class="case-card__body">
                                <span class="case-card__type">{{ $portfolio->title }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ======================== QUICK VIEW MODAL ======================== --}}
    <div class="quick-modal" id="quickModal">
        <div class="quick-modal__overlay" onclick="closeQuickView()"></div>
        <div class="quick-modal__box">
            <button class="quick-modal__close" onclick="closeQuickView()">✕</button>
            <div class="quick-modal__img">
                <img id="qvImg" src="" alt="">
            </div>
            <div class="quick-modal__info">
                <div class="quick-modal__type">{{ $category->title }}</div>
                <h3 class="quick-modal__title" id="qvTitle"></h3>
                <p class="quick-modal__desc" id="qvDesc"></p>
                <div class="quick-modal__specs" id="qvSpecs"></div>
                <div class="quick-modal__actions">
                    <a id="qvLink" href="#" class="btn btn--primary"
                        style="width:100%; text-align:center;">Подробнее о решении</a>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        .cat-hero-section {
            padding-top: 100px;
        }

        .breadcrumbs {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.35);
            margin-bottom: 40px;
        }

        .breadcrumbs a {
            color: rgba(255, 255, 255, 0.35);
            text-decoration: none;
            transition: color 0.2s;
        }

        .breadcrumbs a:hover {
            color: var(--color-primary);
        }

        .breadcrumbs__sep {
            opacity: 0.3;
        }

        .cat-intro__content {
            max-width: 520px;
        }

        .cat-intro__text {
            font-size: 15px;
            color: var(--color-text-dim);
            line-height: 1.75;
            margin-bottom: 28px;
        }

        .cat-intro__actions {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: rgba(255, 255, 255, 0.4);
        }

        .empty-state__icon {
            margin: 0 auto 20px;
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .empty-state h3 {
            font-size: 20px;
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 8px;
        }

        .empty-state p {
            font-size: 14px;
            margin-bottom: 24px;
        }

        .seo-block {
            max-width: 800px;
            margin: 0 auto;
        }

        .seo-block__content {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.45);
            line-height: 1.8;
        }

        .seo-block__content p {
            margin-bottom: 16px;
        }

        .seo-block__content ul {
            padding-left: 20px;
            margin-bottom: 16px;
        }

        .seo-block__content li {
            margin-bottom: 6px;
        }

        .seo-block__content h2,
        .seo-block__content h3 {
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 12px;
            margin-top: 24px;
        }

        .cases-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .case-card {
            display: block;
            text-decoration: none;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid rgba(184, 134, 11, 0.1);
            transition: all 0.3s;
        }

        .case-card:hover {
            border-color: rgba(184, 134, 11, 0.4);
            transform: translateY(-4px);
        }

        .case-card__image {
            aspect-ratio: 4/3;
            background: #111;
            overflow: hidden;
        }

        .case-card__image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .case-card:hover .case-card__image img {
            transform: scale(1.05);
        }

        .case-card__body {
            padding: 16px 20px;
            background: rgba(255, 255, 255, 0.02);
        }

        .case-card__type {
            font-size: 13px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.6);
        }

        @media (max-width: 1200px) {
            .cases-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .cases-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        function openQuickView(btn) {
            const modal = document.getElementById('quickModal');
            const props = JSON.parse(btn.dataset.props || '{}');

            document.getElementById('qvImg').src = btn.dataset.img;
            document.getElementById('qvImg').alt = btn.dataset.title;
            document.getElementById('qvTitle').textContent = btn.dataset.title;
            document.getElementById('qvDesc').textContent = btn.dataset.excerpt;

            // Specs
            const specsEl = document.getElementById('qvSpecs');
            specsEl.innerHTML = '';
            Object.entries(props).slice(0, 6).forEach(([key, val]) => {
                if (!val || val === true) return;
                specsEl.innerHTML += `
            <div class="quick-spec">
                <div class="quick-spec__label">${key.replace(/_/g,' ')}</div>
                <div class="quick-spec__val">${val}</div>
            </div>`;
            });

            modal.classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        function closeQuickView() {
            document.getElementById('quickModal').classList.remove('open');
            document.body.style.overflow = '';
        }

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeQuickView();
        });
    </script>
@endpush
