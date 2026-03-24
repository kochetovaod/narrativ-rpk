@extends('layouts.app')

@section('title', 'FAQ — Нарратив')

@section('content')
    <x-sections.hero
        :current="$page->title"
        itemtype="FAQPage"
        :image="$page->preview->url"
        :label="setting('faq.hero.label')"
        :title="setting('faq.hero.title')"
        :subtitle="setting('faq.hero.subtitle')" />

    <section class="section section--dark">
        <div class="container">
            <div class="faq-layout">

                <!-- Nav -->
                <nav class="faq-nav" id="faqNav">
                    <div class="faq-nav__search">
                        <span class="faq-nav__search-icon">
                            <x-icon name="search" width="16" height="16" />
                        </span>
                        <input type="text" placeholder="Поиск по вопросам..." id="faqSearch"
                            oninput="searchFaq(this.value)">
                    </div>

                    <div class="faq-nav__list" id="faqNavList">
                        @foreach ($categories as $category)
                            <div class="faq-nav__item active" onclick="scrollToSection('{{ $category->slug }}', this)">
                                <div class="faq-nav__item-icon">
                                    <x-icon :name="$category->excerpt" width="16" height="16" />
                                </div>
                                {{ $category->title }}
                                <span class="faq-nav__count">{{ $category->questions->count() }}</span>
                            </div>
                        @endforeach
                    </div>
                </nav>

                <!-- Questions -->
                <div id="faqContent">
                    <div class="faq-no-results" id="faqNoResults">
                        <div class="faq-no-results__icon">
                            <x-icon name="search" width="32" height="32" />
                        </div>
                        <div class="nothing-found">Ничего не найдено</div>
                        <div class="nothing-found-txt">Попробуйте
                            другой запрос или задайте вопрос напрямую — мы ответим быстро.</div>
                    </div>
                    @foreach ($categories as $category)
                        <div class="faq-section" id="{{ $category->slug }}">
                            <div class="faq-section__header">
                                <div class="faq-section__icon">
                                    <x-icon :name="$category->excerpt" width="32" height="32" />

                                </div>
                                <div class="faq-section__title">{{ $category->title }}</div>
                                <div class="faq-section__count">{{ $category->questions->count() }}</div>
                            </div>
                            <div class="faq-accordion">
                                @foreach ($category->questions as $question)
                                    <div class="faq-item" onclick="toggleFaq(this)">
                                        <div class="faq-q">
                                            <span class="faq-q__text">{{ $question->title }}</span>
                                            <span class="faq-q__icon">
                                                <x-icon name="arrow" width="14" height="14" />
                                            </span>
                                        </div>
                                        <div class="faq-a">
                                            <div class="faq-a__inner">{!! $question->excerpt !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>


    <x-sections.cta />
    <script>
        function toggleFaq(el) {
            const isOpen = el.classList.contains('open');
            document.querySelectorAll('.faq-item.open').forEach(i => i.classList.remove('open'));
            if (!isOpen) el.classList.add('open');
        }

        function scrollToSection(id, navEl) {
            document.querySelectorAll('.faq-nav__item').forEach(i => i.classList.remove('active'));
            navEl.classList.add('active');
            const el = document.getElementById(id);
            if (el) el.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }

        function searchFaq(query) {
            const q = query.toLowerCase().trim();
            const items = document.querySelectorAll('.faq-item');
            let found = 0;

            items.forEach(item => {
                const text = item.querySelector('.faq-q__text').textContent.toLowerCase();
                const answerText = item.querySelector('.faq-a__inner') ? item.querySelector('.faq-a__inner')
                    .textContent.toLowerCase() : '';
                const match = !q || text.includes(q) || answerText.includes(q);

                item.classList.toggle('hidden-by-search', !match);
                if (match) found++;
            });

            document.getElementById('faqNoResults').classList.toggle('visible', found === 0 && q.length > 0);

            // Highlight
            items.forEach(item => {
                const qEl = item.querySelector('.faq-q__text');
                if (!q) {
                    qEl.innerHTML = qEl.textContent;
                    return;
                }
                const esc = q.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                qEl.innerHTML = qEl.textContent.replace(new RegExp(esc, 'gi'), m => `<mark>${m}</mark>`);
            });
        }

        // Highlight nav on scroll
        window.addEventListener('scroll', () => {
            // Получаем все секции FAQ
            const sections = document.querySelectorAll('.faq-section');
            const navItems = document.querySelectorAll('.faq-nav__item');

            if (sections.length === 0 || navItems.length === 0) return;

            let currentIndex = 0;

            // Находим текущую активную секцию
            sections.forEach((section, index) => {
                const rect = section.getBoundingClientRect();
                // Если верхняя граница секции находится в верхней части экрана (с отступом 140px)
                if (rect.top < 140) {
                    currentIndex = index;
                }
            });

            // Обновляем активный класс в навигации
            navItems.forEach((item, index) => {
                item.classList.toggle('active', index === currentIndex);
            });
        });

        // Добавляем обработчик для активации первого пункта меню при загрузке страницы
        document.addEventListener('DOMContentLoaded', function() {
            // Активируем первый пункт меню при загрузке
            const firstNavItem = document.querySelector('.faq-nav__item');
            if (firstNavItem) {
                firstNavItem.classList.add('active');
            }
        });
    </script>
@endsection
