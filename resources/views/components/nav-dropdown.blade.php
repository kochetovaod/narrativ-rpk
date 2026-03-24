@props(['title', 'route', 'items', 'itemRoute' => '#', 'itemSlug' => 'slug'])

<li class="nav__dropdown">
    <a href="{{ route($route) }}" class="nav__link">
        {{ $title }} <span class="arrow">▼</span>
    </a>
    @if ($items->isNotEmpty())
        <ul class="dropdown__menu">
            @foreach ($items as $item)
                <li>
                    {{-- Определяем маршрут динамически --}}
                    <a href="{{ route($itemRoute, $item->{$itemSlug} ?? $item->id) }}">
                        {{ $item->title }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</li>
