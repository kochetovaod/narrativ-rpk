@extends('layouts.app')

@section('title', 'Каталог рекламных решений — SLP')

@section('content')

    {{-- ======================== HERO ======================== --}}
    <section class="catalog-hero">
        <div class="container">
            <div class="catalog-hero__inner">
                <div class="catalog-hero__badge">Производство и монтаж</div>
                <h1 class="catalog-hero__title">
                    Каталог рекламных<br>решений <span class="catalog-hero__title-accent">под ключ</span>
                </h1>
                <p class="catalog-hero__sub">
                    Проектируем, производим и монтируем наружную и&nbsp;интерьерную рекламу в&nbsp;Самаре.
                    Собственное производство — сроки и&nbsp;качество под контролем.
                </p>
                <div class="catalog-hero__actions">
                    <a href="#consult" class="btn btn--primary">Получить консультацию</a>
                    <a href="#quiz" class="btn btn--outline">Подобрать решение</a>
                </div>
                <div class="catalog-hero__stats">
                    <div class="catalog-stat">
                        <span class="catalog-stat__num">12+</span>
                        <span class="catalog-stat__label">лет на рынке</span>
                    </div>
                    <div class="catalog-stat">
                        <span class="catalog-stat__num">2 000+</span>
                        <span class="catalog-stat__label">реализованных проектов</span>
                    </div>
                    <div class="catalog-stat">
                        <span class="catalog-stat__num">100%</span>
                        <span class="catalog-stat__label">собственное производство</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ======================== КАТЕГОРИИ ======================== --}}
    <section class="section">
        <div class="container">
            <div class="section-header">
                <div class="section-label">Направления</div>
                <h2 class="section-title">Все типы рекламных решений</h2>
                <p class="section-desc">Выберите нужную категорию, чтобы увидеть варианты исполнения,&nbsp;материалы
                    и&nbsp;типы подсветки</p>
            </div>

            <div class="categories-grid">
                @foreach ($categories as $category)
                    <a href="{{ route('catalog.category', $category->slug) }}" class="cat-card">
                        <div class="cat-card__image">
                            @if ($category->preview)
                                <img src="{{ $category->preview->url }}" alt="{{ $category->title }}" loading="lazy">
                            @endif
                            <div class="cat-card__overlay"></div>
                        </div>
                        <div class="cat-card__body">
                            <h3 class="cat-card__title">{{ $category->title }}</h3>
                            <p class="cat-card__excerpt">{{ $category->excerpt }}</p>

                            {{-- Значки (фильтры первой группы) --}}
                            @if ($category->filters && $category->filters->first())
                                <div class="cat-card__badges">
                                    @foreach ($category->filters->first()->values->take(4) as $value)
                                        <span class="cat-badge">{{ $value->value }}</span>
                                    @endforeach
                                </div>
                            @endif

                            <span class="cat-card__cta">
                                Смотреть решения
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path d="M5 12h14M12 5l7 7-7 7" />
                                </svg>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ======================== КАК ВЫБРАТЬ (Quiz-блок) ======================== --}}
    <section class="section section--dark" id="quiz">
        <div class="container">
            <div class="quiz-block">
                <div class="quiz-block__left">
                    <div class="section-label">Подбор решения</div>
                    <h2 class="section-title">Не знаете, что подойдёт?</h2>
                    <p class="section-desc">Ответьте на несколько вопросов — мы поможем подобрать оптимальный вариант под
                        ваш объект и бюджет</p>
                    <a href="#consult" class="btn btn--primary">Поможем подобрать</a>
                </div>
                <div class="quiz-block__right">
                    <div class="quiz-questions">
                        <div class="quiz-q">
                            <span class="quiz-q__num">01</span>
                            <div class="quiz-q__text">
                                <strong>Где будет размещение?</strong>
                                <span>Улица / Фасад / Интерьер</span>
                            </div>
                        </div>
                        <div class="quiz-q">
                            <span class="quiz-q__num">02</span>
                            <div class="quiz-q__text">
                                <strong>Нужна ли подсветка?</strong>
                                <span>Да / Нет / Не определились</span>
                            </div>
                        </div>
                        <div class="quiz-q">
                            <span class="quiz-q__num">03</span>
                            <div class="quiz-q__text">
                                <strong>Хотите выделяться ночью?</strong>
                                <span>Важно / Не критично</span>
                            </div>
                        </div>
                        <div class="quiz-q">
                            <span class="quiz-q__num">04</span>
                            <div class="quiz-q__text">
                                <strong>Ограничен ли бюджет?</strong>
                                <span>Эконом / Стандарт / Премиум</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ======================== ПРЕИМУЩЕСТВА ======================== --}}
    <section class="section">
        <div class="container">
            <div class="section-header">
                <div class="section-label">Почему мы</div>
                <h2 class="section-title">Производство полного цикла</h2>
            </div>
            <div class="advantages-grid">
                <div class="adv-card">
                    <div class="adv-card__icon">
                        <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5"
                            viewBox="0 0 24 24">
                            <path d="M3 21V8l9-6 9 6v13M9 21V12h6v9" />
                        </svg>
                    </div>
                    <h3 class="adv-card__title">Собственное производство</h3>
                    <p class="adv-card__text">Изготавливаем сами — без посредников, без задержек. Полный контроль качества
                        на каждом этапе.</p>
                </div>
                <div class="adv-card">
                    <div class="adv-card__icon">
                        <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5"
                            viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 6v6l4 2" />
                        </svg>
                    </div>
                    <h3 class="adv-card__title">Под ключ</h3>
                    <p class="adv-card__text">От эскиза до монтажа. Вам не нужно координировать нескольких подрядчиков — всё
                        делаем мы.</p>
                </div>
                <div class="adv-card">
                    <div class="adv-card__icon">
                        <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5"
                            viewBox="0 0 24 24">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                        </svg>
                    </div>
                    <h3 class="adv-card__title">Гарантия на работы</h3>
                    <p class="adv-card__text">Даём гарантию на всю продукцию и монтаж. Устраняем любые замечания за наш
                        счёт.</p>
                </div>
                <div class="adv-card">
                    <div class="adv-card__icon">
                        <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="1.5"
                            viewBox="0 0 24 24">
                            <path d="M9 11l3 3L22 4M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11" />
                        </svg>
                    </div>
                    <h3 class="adv-card__title">Монтаж и согласования</h3>
                    <p class="adv-card__text">Выездные бригады, промышленные альпинисты, спецтехника. Помогаем согласовать
                        размещение.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ======================== КЕЙСЫ ======================== --}}
    @if (isset($portfolios) && $portfolios->count())
        <section class="section section--dark">
            <div class="container">
                <div class="section-header">
                    <div class="section-label">Наши работы</div>
                    <h2 class="section-title">Реализованные проекты</h2>
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
                                <span class="case-card__type">{{ $portfolio->category->title ?? '' }}</span>
                                <h3 class="case-card__title">{{ $portfolio->title }}</h3>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="section-footer">
                    <a href="{{ route('portfolio.index') }}" class="btn btn--outline">Смотреть все работы</a>
                </div>
            </div>
        </section>
    @endif

@endsection

@push('styles')
    <style>
        /* ===== CATALOG HERO ===== */
        .catalog-hero {
            padding: 120px 0 80px;
            position: relative;
            overflow: hidden;
        }

        .catalog-hero::before {
            content: '';
            position: absolute;
            top: -200px;
            right: -200px;
            width: 700px;
            height: 700px;
            background: radial-gradient(circle, rgba(184, 134, 11, 0.06) 0%, transparent 70%);
            pointer-events: none;
        }

        .catalog-hero__inner {
            max-width: 760px;
        }

        .catalog-hero__badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            color: var(--color-primary);
            border: 1px solid rgba(184, 134, 11, 0.3);
            padding: 6px 16px;
            border-radius: 100px;
            margin-bottom: 28px;
        }

        .catalog-hero__badge::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--color-primary);
        }

        .catalog-hero__title {
            font-size: clamp(40px, 5vw, 68px);
            font-weight: 800;
            line-height: 1.1;
            color: #fff;
            margin-bottom: 24px;
            letter-spacing: -1.5px;
        }

        .catalog-hero__title-accent {
            color: var(--color-primary);
            position: relative;
        }

        .catalog-hero__sub {
            font-size: 18px;
            color: var(--color-text-dim);
            line-height: 1.7;
            max-width: 560px;
            margin-bottom: 40px;
        }

        .catalog-hero__actions {
            display: flex;
            gap: 16px;
            margin-bottom: 64px;
            flex-wrap: wrap;
        }

        .catalog-hero__stats {
            display: flex;
            gap: 48px;
            flex-wrap: wrap;
        }

        .catalog-stat__num {
            display: block;
            font-size: 32px;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.5px;
        }

        .catalog-stat__label {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.35);
        }

        /* ===== CATEGORIES GRID ===== */
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .cat-card {
            display: flex;
            flex-direction: column;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(184, 134, 11, 0.12);
            border-radius: 14px;
            overflow: hidden;
            text-decoration: none;
            transition: all 0.35s ease;
        }

        .cat-card:hover {
            border-color: rgba(184, 134, 11, 0.45);
            transform: translateY(-5px);
            box-shadow: 0 24px 56px rgba(0, 0, 0, 0.4);
        }

        .cat-card__image {
            aspect-ratio: 4/3;
            overflow: hidden;
            background: #0c0c0c;
            position: relative;
        }

        .cat-card__image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .cat-card:hover .cat-card__image img {
            transform: scale(1.06);
        }

        .cat-card__overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.5) 0%, transparent 60%);
        }

        .cat-card__body {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .cat-card__title {
            font-size: 16px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 8px;
        }

        .cat-card__excerpt {
            font-size: 13px;
            color: var(--color-text-dim);
            line-height: 1.6;
            flex: 1;
            margin-bottom: 14px;
        }

        .cat-card__badges {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            margin-bottom: 16px;
        }

        .cat-badge {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.5px;
            padding: 3px 8px;
            background: rgba(184, 134, 11, 0.1);
            border: 1px solid rgba(184, 134, 11, 0.2);
            border-radius: 4px;
            color: rgba(184, 134, 11, 0.8);
        }

        .cat-card__cta {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 600;
            color: var(--color-primary);
            transition: gap 0.3s;
        }

        .cat-card:hover .cat-card__cta {
            gap: 10px;
        }

        /* ===== QUIZ BLOCK ===== */
        .quiz-block {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }

        .quiz-questions {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .quiz-q {
            display: flex;
            gap: 20px;
            align-items: flex-start;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid rgba(184, 134, 11, 0.1);
            background: rgba(255, 255, 255, 0.02);
        }

        .quiz-q__num {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            color: var(--color-primary);
            opacity: 0.6;
            padding-top: 2px;
            min-width: 24px;
        }

        .quiz-q__text strong {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #fff;
            margin-bottom: 4px;
        }

        .quiz-q__text span {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.35);
        }

        /* ===== ADVANTAGES ===== */
        .advantages-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .adv-card {
            padding: 28px;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(184, 134, 11, 0.1);
            border-radius: 12px;
            transition: border-color 0.3s;
        }

        .adv-card:hover {
            border-color: rgba(184, 134, 11, 0.35);
        }

        .adv-card__icon {
            width: 52px;
            height: 52px;
            background: rgba(184, 134, 11, 0.08);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-primary);
            margin-bottom: 18px;
        }

        .adv-card__title {
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 10px;
        }

        .adv-card__text {
            font-size: 13px;
            color: var(--color-text-dim);
            line-height: 1.65;
        }

        /* ===== CASES ===== */
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
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--color-primary);
            display: block;
            margin-bottom: 6px;
        }

        .case-card__title {
            font-size: 14px;
            font-weight: 600;
            color: #fff;
        }

        .section-footer {
            text-align: center;
            margin-top: 40px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1200px) {
            .categories-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .advantages-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .catalog-hero {
                padding: 80px 0 60px;
            }

            .categories-grid {
                grid-template-columns: 1fr;
            }

            .quiz-block {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .cases-grid {
                grid-template-columns: 1fr;
            }

            .catalog-hero__stats {
                gap: 24px;
            }

            .advantages-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush
