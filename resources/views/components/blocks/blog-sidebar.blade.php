@props(['categories', 'totalCount'])

<div class="blog-sidebar">
    <div class="blog-sidebar__block">
        <div class="blog-sidebar__title">Категории</div>
        <div class="blog-sidebar__cats">
            <div
                class="blog-sidebar__cat active"
                onclick="filterBlogSidebar(this, 'all')">
                <span>Все статьи</span>
                <span class="blog-sidebar__cat-count">{{ $totalCount }}</span>
            </div>

            @foreach ($categories as $category)
                <div
                    class="blog-sidebar__cat"
                    onclick="filterBlogSidebar(this, '{{ $category->slug }}')">
                    <span>{{ $category->title }}</span>
                    <span class="blog-sidebar__cat-count">
                        {{ $category->articles()->published()->count() }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Можно добавить другие блоки сайдбара --}}
    {{-- <x-blocks.blog-sidebar-popular /> --}}
    {{-- <x-blocks.blog-sidebar-subscribe /> --}}
</div>
