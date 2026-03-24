@extends('layouts.app')

@section('title', 'Портфолио — Нарратив')

@section('content')
    <!-- Page Hero -->
    <x-sections.hero
        :current="$page->title"
        itemtype="PortfolioPage"
        :image="$page->preview->url"
        :label="setting('portfolio.hero.label')"
        :title="setting('portfolio.hero.title')"
        :subtitle="setting('portfolio.hero.subtitle')" />

    <section class="section section--dark">
        <div class="container">
            <!-- Filters -->
            <div class="portfolio-filters">
                <button class="pf-btn active" onclick="filterPortfolio('all', this)">Все работы</button>

                @foreach ($allProducts as $product)
                    <button class="pf-btn"
                        data-filter="{{ $product->slug }}"
                        onclick="filterPortfolio('{{ $product->slug }}', this)">
                        {{ $product->title }}
                    </button>
                @endforeach

                @foreach ($allServices as $service)
                    <button class="pf-btn"
                        data-filter="{{ $service->slug }}"
                        onclick="filterPortfolio('{{ $service->slug }}', this)">
                        {{ $service->title }}
                    </button>
                @endforeach
            </div>

            <!-- Masonry grid -->
            <div class="portfolio-grid" id="portfolioGrid">
                @foreach ($works as $index => $work)
                    @php
                        // Определяем класс для сетки
                        if ($index % 3 == 0) {
                            $class = 'portfolio-item--wide';
                        } elseif ($index % 3 == 1) {
                            $class = 'portfolio-item--sq';
                        } else {
                            $class = 'portfolio-item--tall';
                        }

                        // Собираем все категории для этой работы (slug услуг и продуктов)
                        $categories = collect();
                        if ($work->services->isNotEmpty()) {
                            $categories = $categories->concat($work->services->pluck('slug'));
                        }
                        if ($work->products->isNotEmpty()) {
                            $categories = $categories->concat($work->products->pluck('slug'));
                        }
                    @endphp

                    <div class="portfolio-item {{ $class }}"
                        id="project{{ $index }}"
                        data-categories="{{ $categories->implode(',') }}"
                        data-services="{{ $work->services->pluck('slug')->implode(',') }}"
                        data-products="{{ $work->products->pluck('slug')->implode(',') }}"
                        data-city="Самара"
                        data-title="{{ $work->title }}"
                        data-year="{{ $work->completed_at }}"
                        data-client="{{ $work->client->title ?? '' }}"
                        data-excerpt="{{ $work->excerpt }}"
                        data-image="{{ $work->detail->url ?? $work->preview->url }}"
                        data-url="{{ route('portfolio.show', $work->slug) }}"
                        data-index="{{ $index }}">

                        <img src="{{ $work->preview->url }}" alt="{{ $work->title }}"
                            onerror="this.style.background='#1a1a1a'">

                        <div class="portfolio-item__overlay">
                            <div class="portfolio-item__title">{{ $work->title }}</div>
                            <div class="portfolio-item__meta">
                                <span>{{ $work->city ?? 'Самара' }}</span>
                                <span>{{ $work->completed_at }}</span>
                            </div>
                        </div>

                        <div class="portfolio-item__zoom" onclick="openLightbox({{ $index }})">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M10 2h4v4M6 10L14 2M6 14H2v-4" stroke="currentColor" stroke-width="1.4"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Lightbox -->
    <div class="lightbox" id="lightbox">
        <button class="lightbox__close" onclick="closeLightbox()">×</button>
        <button class="lightbox__prev" onclick="shiftLightbox(-1)">‹</button>
        <button class="lightbox__next" onclick="shiftLightbox(1)">›</button>
        <div class="lightbox__content">
            <div class="lightbox__img">
                <img id="lbImg" src="" alt="">
            </div>
            <div class="lightbox__info">
                <h2 class="lightbox__title" id="lbTitle"></h2>
                <p class="lightbox__desc" id="lbDesc"></p>
                <div class="lightbox__specs">
                    <div class="lb-spec">
                        <span class="lb-spec__label">Город</span>
                        <span class="lb-spec__val" id="lbCity"></span>
                    </div>
                    <div class="lb-spec">
                        <span class="lb-spec__label">Год</span>
                        <span class="lb-spec__val" id="lbYear"></span>
                    </div>
                    <div class="lb-spec">
                        <span class="lb-spec__label">Компания</span>
                        <span class="lb-spec__val" id="lbComp"></span>
                    </div>
                </div>
                <a id="lbLink" href="" class="btn btn--primary">Открыть проект →</a>
            </div>
        </div>
        <div class="lightbox__counter" id="lbCounter"></div>
    </div>
    <!-- Stats -->
    <section class="section section--dark">
        <div class="container">
            <div class="portfolio-stats">
                @if (is_string($page->properties) && !empty($page->properties))
                    @php
                        $items = json_decode($page->properties, true);
                    @endphp
                @else
                    @php
                        $items = $page->properties;
                    @endphp
                @endif
                @foreach ($items as $index => $item)
                    <div class="material-card">
                        <div class="portfolio-stat__num">{{ $item['value'] }}</div>
                        <div class="portfolio-stat__label">{{ $item['key'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        // Состояние приложения
        let currentIndex = 0;
        let projects = [];
        let visibleProjects = [];

        // Инициализация при загрузке страницы
        document.addEventListener('DOMContentLoaded', function() {
            // Получаем все проекты и преобразуем в массив для удобства
            projects = Array.from(document.querySelectorAll('.portfolio-item'));
            visibleProjects = [...projects];

            // Добавляем обработчики кликов на элементы (если нужно открывать по клику на весь блок)
            projects.forEach((project, index) => {
                project.addEventListener('click', function(e) {
                    // Проверяем, что клик не по кнопке зума (чтобы не было двойного срабатывания)
                    if (!e.target.closest('.portfolio-item__zoom')) {
                        openLightbox(index);
                    }
                });
            });
        });

        // Функция фильтрации
        function filterPortfolio(category, btnElement) {
            // Обновляем активную кнопку
            document.querySelectorAll('.pf-btn').forEach(btn => btn.classList.remove('active'));
            btnElement.classList.add('active');

            // Получаем все элементы портфолио
            const items = document.querySelectorAll('.portfolio-item');

            // Фильтруем и обновляем видимые проекты
            visibleProjects = [];

            items.forEach(item => {
                let match;

                if (category === 'all') {
                    match = true;
                } else {
                    // Проверяем, есть ли категория в data-categories
                    const categories = (item.dataset.categories || '').split(',');
                    match = categories.includes(category);
                }

                // Показываем или скрываем элемент
                item.style.display = match ? 'block' : 'none';

                // Сохраняем видимые проекты для навигации в lightbox
                if (match) {
                    visibleProjects.push(item);
                }
            });

            // Обновляем сетку (если используется masonry)
            if (window.updateMasonry) {
                window.updateMasonry();
            }
        }

        // Функция открытия lightbox
        function openLightbox(index) {
            // Получаем актуальный индекс в видимых проектах
            const actualProject = projects[index];
            const visibleIndex = visibleProjects.indexOf(actualProject);

            if (visibleIndex !== -1) {
                currentIndex = visibleIndex;
                renderLightbox();
                document.getElementById('lightbox').classList.add('open');
                document.body.style.overflow = 'hidden';
            }
        }

        // Функция отображения lightbox
        function renderLightbox() {
            if (visibleProjects.length === 0) return;

            const p = visibleProjects[currentIndex];

            document.getElementById('lbLink').href = p.dataset.url || '#';
            document.getElementById('lbImg').src = p.dataset.image || '';
            document.getElementById('lbTitle').textContent = p.dataset.title || '';
            document.getElementById('lbDesc').textContent = p.dataset.excerpt || '';
            document.getElementById('lbCity').textContent = p.dataset.city || 'Самара';
            document.getElementById('lbYear').textContent = p.dataset.year || '';
            document.getElementById('lbComp').textContent = p.dataset.client || '—';
            document.getElementById('lbCounter').textContent = (currentIndex + 1) + ' / ' + visibleProjects.length;
        }

        // Функция переключения lightbox
        function shiftLightbox(direction) {
            if (visibleProjects.length === 0) return;

            currentIndex = (currentIndex + direction + visibleProjects.length) % visibleProjects.length;
            renderLightbox();
        }

        // Функция закрытия lightbox
        function closeLightbox() {
            document.getElementById('lightbox').classList.remove('open');
            document.body.style.overflow = '';
        }

        // Обработчики клавиш
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeLightbox();
            }
            if (e.key === 'ArrowLeft') {
                shiftLightbox(-1);
            }
            if (e.key === 'ArrowRight') {
                shiftLightbox(1);
            }
        });

        // Если используется masonry (например, Masonry.js или Isotope)
        function initMasonry() {
            // Здесь можно инициализировать Masonry если нужно
            // const grid = document.querySelector('.portfolio-grid');
            // new Masonry(grid, { ... });
        }

        function updateMasonry() {
            // Обновление masonry после фильтрации
            // если используется библиотека
        }
    </script>
@endpush
