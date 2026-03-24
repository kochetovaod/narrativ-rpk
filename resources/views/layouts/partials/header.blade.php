<header class="header" id="header">
    <div class="header__container">
        <div class="header__logo">
            <a href="{{ route('home') }}">
                <img src="@image('site_logo_dark')" alt="@setting('site_name')" class="logo logo--default">
            </a>
        </div>

        <nav class="header__nav">
            <ul class="nav__menu">
                <li><x-nav-link :href="route('home')">Главная</x-nav-link></li>
                <x-nav-dropdown title="Услуги" route="services.index" :items="$navServices" itemRoute="services.show" />
                <x-nav-dropdown title="Продукция" route="catalog.index" :items="$navCategories"
                    itemRoute="catalog.category" />

                <li><x-nav-link :href="route('portfolio.index')">Портфолио</x-nav-link></li>
                <li class="nav__dropdown">
                    <a href="{{ route('about') }}" class="nav__link">
                        О компании <span class="arrow">▼</span>
                    </a>
                    <ul class="dropdown__menu">
                        <li><x-nav-link :href="route('about')">О нас</x-nav-link></li>
                        <li><x-nav-link :href="route('blog.index')">Блог</x-nav-link></li>
                        <li><x-nav-link :href="route('equipment')">Оборудование</x-nav-link></li>
                        <li><x-nav-link :href="route('faq')">FAQ</x-nav-link></li>
                    </ul>
                </li>
                <li><x-nav-link :href="route('contacts')">Контакты</x-nav-link></li>
            </ul>
        </nav>

        <div class="header__contacts">
            <a href="tel:@setting('contact_phone')" class="header__phone">
                @setting('contact_phone')
            </a>
            <div class="header__messengers">
                <a href="@setting('social_whatsapp')" class="messenger-icon whatsapp" aria-label="whatsapp"
                    target="_blank" rel="noopener noreferrer">
                    <x-icon name="social_whatsapp" width="28" height="28" class="messenger-icon" />
                </a>
                <a href="@setting('social_telegram')" class="messenger-icon telegram" aria-label="telegram"
                    target="_blank" rel="noopener noreferrer">
                    <x-icon name="social_telegram" width="28" height="28" class="messenger-icon" />
                </a>
            </div>

            <button class="btn btn--primary" onclick="openCallbackModal()">
                @setting('callback_button_text', 'Заказать звонок')
            </button>
        </div>

        <button class="burger" id="burger" onclick="toggleMobileMenu()">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</header>
