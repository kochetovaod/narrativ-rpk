<section class="products" id="products">
    <div class="container">
        <h2 class="section-title">Типы продукции</h2>
        <div class="products__slider">
            <div class="products__track" id="productsTrack">
                <div class="product-card">
                    <div class="product-card__image">
                        <img src="{{ asset('images/Продукция/Объемные буквы.jpeg') }}" alt="Объемные буквы"
                            loading="lazy">
                    </div>
                    <div class="product-card__content">
                        <h3 class="product-card__title">Объемные буквы</h3>
                        <p class="product-card__desc">Различные варианты подсветки и исполнения</p>
                        <a href="#" class="btn btn--small">В каталог</a>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-card__image">
                        <img src="{{ asset('images/Продукция/Световые короба.jpeg') }}" alt="Световые короба"
                            loading="lazy">
                    </div>
                    <div class="product-card__content">
                        <h3 class="product-card__title">Световые короба</h3>
                        <p class="product-card__desc">От стандартных до фигурных решений</p>
                        <a href="#" class="btn btn--small">В каталог</a>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-card__image">
                        <img src="{{ asset('images/Продукция/Тонкие световые панели.jpeg') }}"
                            alt="Тонкие световые панели" loading="lazy">
                    </div>
                    <div class="product-card__content">
                        <h3 class="product-card__title">Тонкие световые панели</h3>
                        <p class="product-card__desc">Кристалайт и другие современные решения</p>
                        <a href="#" class="btn btn--small">В каталог</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="products__arrows">
            <button class="slider-arrow slider-arrow--prev" onclick="moveProductsSlider(-1)">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </button>
            <button class="slider-arrow slider-arrow--next" onclick="moveProductsSlider(1)">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </button>
        </div>
    </div>
</section>
