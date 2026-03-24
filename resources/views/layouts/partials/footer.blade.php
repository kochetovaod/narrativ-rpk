<footer class="footer" id="contacts">
    <!-- Декоративные картинки с тегами img -->
    <div class="footer__decor footer__decor--top-left">
        <img src="@image('decor3')"
            alt=""
            aria-hidden="true"
            loading="lazy">
    </div>

    <div class="footer__decor footer__decor--bottom-right">
        <img src="@image('decor4')"
            alt=""
            aria-hidden="true"
            loading="lazy">
    </div>

    <div class="container">
        <div class="footer__content">
            <div class="footer__column">
                <div class="footer__logo">
                    <a href="{{ route('home') }}">
                        <img src="@image('site_logo_dark')" alt="Нарратив" class="logo">
                    </a>
                </div>
                <p class="footer__description">@setting('site_description')</p>
                <div class="footer__social">
                    <a href="@setting('social_whatsapp')" class="social-icon" aria-label="WhatsApp">
                        <x-icon name="social_whatsapp" width="24" height="24" />
                    </a>
                    <a href="@setting('social_telegram')" class="social-icon" aria-label="Telegram">
                        <x-icon name="social_telegram" width="24" height="24" />
                    </a>
                    <a href="@setting('social_instagram')" class="social-icon" aria-label="Instagram">
                        <x-icon name="social_instagram" width="24" height="24" />
                    </a>
                </div>
            </div>

            <div class="footer__column">
                <h4 class="footer__heading">Услуги</h4>
                <ul class="footer__links">
                    @forelse($navServices as $service)
                        <li>
                            <a href="{{ route('services.show', $service->slug ?? $service->id) }}">
                                {{ $service->title }}
                            </a>
                        </li>
                    @empty
                        <li>Нет доступных услуг</li>
                    @endforelse
                </ul>
            </div>

            <div class="footer__column">
                <h4 class="footer__heading">Продукция</h4>
                <ul class="footer__links">
                    @forelse($navCategories->take(6) as $category)
                        <li>
                            <a href="{{ route('catalog.category', $category->slug ?? $category->id) }}">
                                {{ $category->title }}
                            </a>
                        </li>
                    @empty
                        <li>Нет доступных категорий</li>
                    @endforelse
                </ul>
            </div>

            <div class="footer__column">
                <h4 class="footer__heading">Компания</h4>
                <ul class="footer__links">
                    <li><a href="{{ route('about') }}">О нас</a></li>
                    <li><a href="{{ route('portfolio.index') }}">Портфолио</a></li>
                    <li><a href="{{ route('blog.index') }}">Блог</a></li>
                    <li><a href="{{ route('equipment') }}">Оборудование</a></li>
                    <li><a href="{{ route('faq') }}">FAQ</a></li>
                </ul>
            </div>
            <div class="footer__column">
                <h4 class="footer__heading">Контакты</h4>
                <ul class="footer__contacts">
                    <li>
                        <x-icon name="social_phone" width="20" height="20" />
                        <a href="tel:@setting('contact_phone')">@setting('contact_phone')</a>
                    </li>
                    <li>
                        <x-icon name="social_email" width="20" height="20" />
                        <a href="mailto:@setting('contact_email')">@setting('contact_email')</a>
                    </li>
                    <li>
                        <x-icon name="social_clock" width="20" height="20" />
                        <span>@setting('working_hours')</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="footer__bottom">
            <div class="footer__copyright">
                © 2026 @setting('site_name') Все права защищены.
            </div>
            <div class="footer__legal">
                <a href="{{ route('privacy') }}">Политика конфиденциальности</a>
                <span class="footer__separator">•</span>
                <a href="#">Карта сайта</a>
            </div>
        </div>
    </div>
</footer>
