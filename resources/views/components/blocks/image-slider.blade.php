<section class="image-slider">
    <div class="slider-container">
        <div class="slider-track" id="sliderTrack">
            <div class="slide">
                <img src="{{ asset('images/Имиджевые блоки для слайдера/опыт команды.webp') }}" alt="15+ лет опыта"
                    loading="lazy">
                <div class="slide__content">
                    <h2 class="slide__title">15+ лет совокупного опыта команды</h2>
                    <p class="slide__text">Столько наши мастера работают с фрезеровкой, лазером и УФ-печатью. Мы не
                        просто делаем вывески — мы знаем материал.</p>
                </div>
            </div>
            <div class="slide">
                <img src="{{ asset('images/Имиджевые блоки для слайдера/лазерная резка.webp') }}" alt="Лазерная резка"
                    loading="lazy">
                <div class="slide__content">
                    <h2 class="slide__title">Лазерная резка с точностью до 0,1 мм</h2>
                    <p class="slide__text">Идеальный рез на сложных формах.</p>
                </div>
            </div>
            <div class="slide">
                <img src="{{ asset('images/Имиджевые блоки для слайдера/кастомные проекты.webp') }}"
                    alt="Кастомные проекты" loading="lazy">
                <div class="slide__content">
                    <h2 class="slide__title">100% кастомных проектов</h2>
                    <p class="slide__text">С нуля под ваш бизнес.</p>
                </div>
            </div>
            <div class="slide">
                <img src="{{ asset('images/Имиджевые блоки для слайдера/полный цил в одном цехе.webp') }}"
                    alt="Полный цикл" loading="lazy">
                <div class="slide__content">
                    <h2 class="slide__title">Полный цикл в одном цехе</h2>
                    <p class="slide__text">От фрезеровки и печати до сварки и монтажа.</p>
                </div>
            </div>
            <div class="slide">
                <img src="{{ asset('images/Имиджевые блоки для слайдера/живой свет.webp') }}" alt="Живой свет"
                    loading="lazy">
                <div class="slide__content">
                    <h2 class="slide__title">Уже 30+ компаний выбрали живой свет</h2>
                    <p class="slide__text">Добавьте к этому списку и свой бренд</p>
                </div>
            </div>
        </div>
    </div>
    <button class="slider-arrow slider-arrow--prev" onclick="moveSlider(-1)">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
        </svg>
    </button>
    <button class="slider-arrow slider-arrow--next" onclick="moveSlider(1)">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
        </svg>
    </button>
    <div class="slider-dots" id="sliderDots"></div>
</section>
