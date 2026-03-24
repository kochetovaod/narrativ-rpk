@extends('layouts.app')

@section('title', 'Поиск — Нарратив')

@section('content')
    <!-- Search Hero -->
    <section class="search-hero">
        <div class="container">
            <div class="page-hero__breadcrumb" style="margin-bottom: 20px;">
                <a href="{{ route('home') }}">Главная</a><span>›</span><span>Поиск</span>
            </div>
            <div class="search-hero__label">Поиск по сайту</div>
            <h1 class="search-hero__title">Результаты поиска по запросу <em id="queryDisplay">«объёмные буквы»</em></h1>

            <div class="search-bar">
                <input type="text" class="search-bar__input" id="mainSearchInput" value="объёмные буквы"
                    placeholder="Найти услугу, товар или статью...">
                <button class="search-bar__btn" onclick="doSearch()">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <circle cx="8" cy="8" r="5.5" stroke="currentColor" stroke-width="1.8" />
                        <path d="M13 13l3 3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                    </svg>
                    Найти
                </button>
            </div>

            <div class="search-hero__meta">Найдено <strong id="totalCount">14</strong> результатов</div>

            <div class="search-suggests">
                <span class="search-suggest" onclick="setQuery('световые буквы')">световые буквы</span>
                <span class="search-suggest" onclick="setQuery('вывеска на заказ')">вывеска на заказ</span>
                <span class="search-suggest" onclick="setQuery('лазерная резка')">лазерная резка</span>
                <span class="search-suggest" onclick="setQuery('неон')">неон</span>
                <span class="search-suggest" onclick="setQuery('световой короб')">световой короб</span>
                <span class="search-suggest" onclick="setQuery('монтаж вывески')">монтаж вывески</span>
            </div>
        </div>
    </section>

    <!-- Results -->
    <section class="section section--dark">
        <div class="container">
            <div class="search-layout">
                <!-- Main results -->
                <div>
                    <!-- Toolbar -->
                    <div class="results-toolbar">
                        <div class="results-count">Показано <strong>1–10</strong> из <strong>14</strong></div>
                        <div class="results-sort">
                            <span class="sort-label">Сортировка:</span>
                            <select class="sort-select">
                                <option>По релевантности</option>
                                <option>Сначала услуги</option>
                                <option>Сначала товары</option>
                                <option>Сначала статьи</option>
                            </select>
                        </div>
                    </div>

                    <!-- Results -->
                    <div id="resultsContainer">
                        <!-- Result 1 - Product -->
                        <a href="{{ route('catalog.show', ['category' => 'obyomnye-bukvy', 'product' => 'akrilovye']) }}"
                            class="result-card">
                            <div class="result-card__thumb">
                                <img src="{{ asset('images/Продукция/Объемные буквы.jpeg') }}" alt="">
                            </div>
                            <div class="result-card__body">
                                <span class="result-card__type result-card__type--product">Товар</span>
                                <div class="result-card__title">Акриловые <mark>объёмные буквы</mark> с торцевой
                                    LED-подсветкой</div>
                                <div class="result-card__excerpt">Молочный или цветной акрил, LED-лента Samsung 2835.
                                    Равномерное свечение по торцу, <mark>объёмные буквы</mark> любого шрифта и размера.
                                    Гарантия 1 год.</div>
                                <div class="result-card__footer">
                                    <span class="result-card__price">от 1 800 ₽/буква</span>
                                    <span class="result-card__arrow"><svg width="16" height="16" viewBox="0 0 16 16"
                                            fill="none">
                                            <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg></span>
                                </div>
                            </div>
                        </a>

                        <!-- Result 2 - Service -->
                        <a href="{{ route('services.show', 'izgotovlenie-vyivesok') }}" class="result-card">
                            <div class="result-card__thumb">
                                <img src="{{ asset('images/мост/Реализация.png') }}" alt="">
                            </div>
                            <div class="result-card__body">
                                <span class="result-card__type result-card__type--service">Услуга</span>
                                <div class="result-card__title">Изготовление вывесок с <mark>объёмными буквами</mark> на
                                    заказ</div>
                                <div class="result-card__excerpt">Полный цикл: замер, дизайн, производство, монтаж.
                                    <mark>Объёмные буквы</mark> из акрила, металла, ПВХ. Срок от 3 дней. Бесплатный расчёт.
                                </div>
                                <div class="result-card__footer">
                                    <span class="result-card__arrow"><svg width="16" height="16" viewBox="0 0 16 16"
                                            fill="none">
                                            <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg></span>
                                </div>
                            </div>
                        </a>

                        <!-- Result 3 - Category -->
                        <a href="{{ route('catalog.category', 'obyomnye-bukvy') }}" class="result-card">
                            <div class="result-card__thumb">
                                <img src="{{ asset('images/Продукция/Объемные буквы.jpeg') }}" alt="">
                            </div>
                            <div class="result-card__body">
                                <span class="result-card__type result-card__type--product">Каталог</span>
                                <div class="result-card__title"><mark>Объёмные буквы</mark> — каталог продукции</div>
                                <div class="result-card__excerpt">24 варианта <mark>объёмных букв</mark>: из акрила,
                                    нержавейки, алюминия, ПВХ, дерева. Торцевая, прямая и контражурная подсветка.</div>
                                <div class="result-card__footer">
                                    <span class="result-card__price">от 500 ₽/буква</span>
                                    <span class="result-card__arrow"><svg width="16" height="16"
                                            viewBox="0 0 16 16" fill="none">
                                            <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg></span>
                                </div>
                            </div>
                        </a>

                        <!-- Result 4 - Article -->
                        <a href="{{ route('blog.show', 'akril-ili-pvh') }}" class="result-card">
                            <div class="result-card__thumb">
                                <img src="{{ asset('images/Имиджевые блоки для слайдера/лазерная резка.webp') }}"
                                    alt="">
                            </div>
                            <div class="result-card__body">
                                <span class="result-card__type result-card__type--article">Статья</span>
                                <div class="result-card__title">Акрил или ПВХ для <mark>объёмных букв</mark>: в чём разница
                                </div>
                                <div class="result-card__excerpt">Сравниваем два главных материала для производства
                                    <mark>объёмных букв</mark>: долговечность, стоимость, поведение при разных температурах.
                                </div>
                                <div class="result-card__footer">
                                    <span class="result-card__date">20 января 2026</span>
                                    <span class="result-card__arrow"><svg width="16" height="16"
                                            viewBox="0 0 16 16" fill="none">
                                            <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg></span>
                                </div>
                            </div>
                        </a>

                        <!-- Result 5 - Portfolio -->
                        <a href="{{ route('portfolio.show', 'bodrost') }}" class="result-card">
                            <div class="result-card__thumb">
                                <img src="{{ asset('images/мост/Реализация.png') }}" alt="">
                            </div>
                            <div class="result-card__body">
                                <span class="result-card__type result-card__type--project">Портфолио</span>
                                <div class="result-card__title">Кейс: <mark>объёмные буквы</mark> для сети кофеен
                                    «Бодрость» — 12 точек</div>
                                <div class="result-card__excerpt">Изготовление и монтаж <mark>объёмных букв</mark> из
                                    акрила с торцевой подсветкой для 12 кофеен Москвы и МО за 14 рабочих дней.</div>
                                <div class="result-card__footer">
                                    <span class="result-card__date">2025 год</span>
                                    <span class="result-card__arrow"><svg width="16" height="16"
                                            viewBox="0 0 16 16" fill="none">
                                            <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg></span>
                                </div>
                            </div>
                        </a>

                        <!-- Result 6 - FAQ -->
                        <a href="{{ route('faq') }}#obyomnye-bukvy" class="result-card">
                            <div class="result-card__thumb"
                                style="background:rgba(0,196,184,.06); border:1px solid rgba(0,196,184,.15); display:flex; align-items:center; justify-content:center;">
                                <svg width="36" height="36" viewBox="0 0 36 36" fill="none">
                                    <circle cx="18" cy="18" r="14" stroke="#00c4b8" stroke-width="1.5" />
                                    <path d="M18 26v-9.5A2.5 2.5 0 0120.5 14" stroke="#00c4b8" stroke-width="1.5"
                                        stroke-linecap="round" />
                                    <circle cx="18" cy="28.5" r="1" fill="#00c4b8" />
                                </svg>
                            </div>
                            <div class="result-card__body">
                                <span class="result-card__type result-card__type--article">FAQ</span>
                                <div class="result-card__title">Часто задаваемые вопросы об <mark>объёмных буквах</mark>
                                </div>
                                <div class="result-card__excerpt">Сколько стоят <mark>объёмные буквы</mark>? Какой
                                    минимальный размер? Сколько прослужат? — отвечаем на всё.</div>
                                <div class="result-card__footer">
                                    <span class="result-card__arrow"><svg width="16" height="16"
                                            viewBox="0 0 16 16" fill="none">
                                            <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg></span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Pagination -->
                    <div class="results-pagination">
                        <button class="page-btn active">1</button>
                        <button class="page-btn">2</button>
                        <button class="page-btn page-btn--wide">Следующая →</button>
                    </div>
                </div>

                <!-- Sidebar -->
                <aside class="search-filters">
                    <div class="search-filter-block">
                        <div class="search-filter-block__title">Раздел сайта</div>
                        <label class="filter-radio"><input type="radio" name="section" checked><span
                                class="filter-radio__label">Все разделы</span><span
                                class="filter-radio__count">14</span></label>
                        <label class="filter-radio"><input type="radio" name="section"><span
                                class="filter-radio__label">Товары</span><span
                                class="filter-radio__count">6</span></label>
                        <label class="filter-radio"><input type="radio" name="section"><span
                                class="filter-radio__label">Услуги</span><span
                                class="filter-radio__count">2</span></label>
                        <label class="filter-radio"><input type="radio" name="section"><span
                                class="filter-radio__label">Статьи</span><span
                                class="filter-radio__count">3</span></label>
                        <label class="filter-radio"><input type="radio" name="section"><span
                                class="filter-radio__label">Портфолио</span><span
                                class="filter-radio__count">2</span></label>
                        <label class="filter-radio"><input type="radio" name="section"><span
                                class="filter-radio__label">FAQ</span><span class="filter-radio__count">1</span></label>
                    </div>

                    <div class="popular-block">
                        <div class="popular-block__title">Популярные запросы</div>
                        <div class="popular-item" onclick="setQuery('световые короба')">
                            <span class="popular-item__query">световые короба</span>
                            <span class="popular-item__count">↑ 324</span>
                        </div>
                        <div class="popular-item" onclick="setQuery('объёмные буквы')">
                            <span class="popular-item__query">объёмные буквы</span>
                            <span class="popular-item__count">↑ 289</span>
                        </div>
                        <div class="popular-item" onclick="setQuery('вывеска на заказ')">
                            <span class="popular-item__query">вывеска на заказ</span>
                            <span class="popular-item__count">↑ 241</span>
                        </div>
                        <div class="popular-item" onclick="setQuery('неон')">
                            <span class="popular-item__query">неон</span>
                            <span class="popular-item__count">↑ 188</span>
                        </div>
                        <div class="popular-item" onclick="setQuery('лазерная резка')">
                            <span class="popular-item__query">лазерная резка</span>
                            <span class="popular-item__count">↑ 152</span>
                        </div>
                    </div>

                    <div
                        style="margin-top:16px; padding:24px; background:rgba(0,196,184,.04); border:1px solid rgba(0,196,184,.2); border-radius:8px; text-align:center;">
                        <div style="font-size:13px; color:rgba(255,255,255,.5); line-height:1.65; margin-bottom:16px;">Не
                            нашли нужное? Наш менеджер ответит на любой вопрос.</div>
                        <button class="btn btn--primary" style="width:100%; font-size:14px;"
                            onclick="openCallbackModal()">Задать вопрос</button>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <script>
        function doSearch() {
            const q = document.getElementById('mainSearchInput').value.trim();
            if (q) {
                document.getElementById('queryDisplay').textContent = '«' + q + '»';
            }
        }

        function setQuery(q) {
            document.getElementById('mainSearchInput').value = q;
            document.getElementById('queryDisplay').textContent = '«' + q + '»';
        }
    </script>
@endsection
