<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="@setting('site_name')">
    <meta name="copyright" content="@setting('site_name')">
    <link rel="icon" type="image/x-icon" href="@image('favicon_ico')">
    <link rel="shortcut icon" type="image/x-icon" href="@image('favicon_ico')">
    <!-- Favicon - Современные форматы -->
    <link rel="icon" type="image/webp" sizes="16x16" href="@image('favicon_16')">
    <link rel="icon" type="image/webp" sizes="32x32" href="@image('favicon_32')">

    <!-- Apple Touch Icon (для iOS устройств) -->
    <link rel="apple-touch-icon" sizes="180x180" href="@image('apple_touch_icon')">
    <link rel="apple-touch-icon-precomposed" href="@image('apple_touch_icon')">
    <meta property="og:site_name" content="@setting('site_name')">
    <meta property="og:locale" content="ru_RU">
    <!-- Android Chrome Icons -->
    <link rel="icon" type="image/webp" sizes="192x192" href="@image('android_chrome_192')">
    <link rel="icon" type="image/webp" sizes="512x512" href="@image('android_chrome_512')">
    @yield('meta')
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @yield('preload')
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Vite CSS -->
    @vite(['resources/css/app.css'])

    @stack('styles')
</head>

<body class="@yield('body_class', '')">
    @include('partials.svg-sprite')
    <!-- Header -->
    @include('layouts.partials.header')

    <!-- Mobile Menu -->
    @include('layouts.partials.mobile-menu')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.partials.footer')

    <!-- Modals -->
    @include('layouts.partials.modals.callback')

    <!-- Vite JS -->
    @vite(['resources/js/app.js'])

    @stack('scripts')
</body>

</html>
