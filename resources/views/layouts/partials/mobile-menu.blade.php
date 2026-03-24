<div class="mobile-menu" id="mobileMenu">
    <nav class="mobile-menu__nav">
        <ul>
            <li><a href="{{ route('home') }}">Главная</a></li>
            <li><a href="{{ route('services.index') }}">Услуги</a></li>
            <li><a href="{{ route('catalog.index') }}">Продукция</a></li>
            <li><a href="{{ route('portfolio.index') }}">Портфолио</a></li>
            <li><a href="{{ route('about') }}">О компании</a></li>
            <li><a href="{{ route('blog.index') }}">Блог</a></li>
            <li><a href="{{ route('contacts') }}">Контакты</a></li>
        </ul>
        <button class="btn btn--primary" onclick="openCallbackModal()">Заказать звонок</button>
    </nav>
</div>
