{{-- resources/views/includes/breadcrumb.blade.php --}}
@props(['items' => [], 'homeRoute' => 'home', 'homeText' => 'Главная', 'current'])

<div class="page-hero__breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
    {{-- Главная --}}
    <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
        <a href="{{ route($homeRoute) }}" itemprop="item">
            <span itemprop="name">{{ $homeText }}</span>
            <meta itemprop="position" content="0" />
        </a>
    </span>
    <span>›</span>

    {{-- Промежуточные элементы --}}
    @foreach ($items as $index => $item)
        <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <a href="{{ $item['url'] }}" itemprop="item">
                <span itemprop="name">{{ $item['title'] }}</span>
                <meta itemprop="position" content="{{ $index + 1 }}" />
            </a>
        </span>
        <span>›</span>
    @endforeach
    <span>{{ $current }}</span>
</div>
