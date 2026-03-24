@extends('layouts.app')

@section('meta')
    {!! SEO::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    {!! JsonLd::generate() !!}
@endsection
@section('preload')
    @if ($featuredArticle ?? null)
        <link
            rel="preload"
            as="image"
            href="{{ $featuredArticle->detail->url }}"
            fetchpriority="high">
    @endif
    @foreach ($articles->take(4) as $article)
        <link
            rel="preload"
            as="image"
            href="{{ $article->preview->url }}"
            fetchpriority="low">
    @endforeach
@endsection
@section('content')
    <x-sections.hero
        :current="$page->title"
        itemtype="Blog"
        :image="$page->preview->url"
        :label="setting('blog.hero.label')"
        :title="setting('blog.hero.title')"
        :subtitle="setting('blog.hero.subtitle')" />
    <x-sections.featured-article :article="$article" />
    <x-sections.blog-content
        :articles="$articles"
        :tags="$tags"
        :categories="$categories"
        :total-count="$articles->count()" />

    <script>
        function filterBlog(btn, tagSlug) {
            // Переключаем активный класс на кнопках тегов
            document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
            btn.classList.add('active');

            // Сбрасываем активный класс в сайдбаре
            document.querySelectorAll('.blog-sidebar__cat').forEach(c => c.classList.remove('active'));

            // Фильтруем карточки по тегам
            document.querySelectorAll('.blog-page-card').forEach(card => {
                if (tagSlug === 'all') {
                    card.style.display = '';
                } else {
                    const cardTags = card.dataset.tags.split(' ');
                    card.style.display = cardTags.includes(tagSlug) ? '' : 'none';
                }
            });
        }

        function filterBlogSidebar(element, catSlug) {
            // Переключаем активный класс в сайдбаре
            document.querySelectorAll('.blog-sidebar__cat').forEach(c => c.classList.remove('active'));
            element.classList.add('active');

            // Сбрасываем активный класс в табах тегов
            document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
            document.querySelector('.filter-tab[onclick*="all"]').classList.add('active');

            // Фильтруем карточки по категориям
            document.querySelectorAll('.blog-page-card').forEach(card => {
                if (catSlug === 'all') {
                    card.style.display = '';
                } else {
                    card.style.display = (card.dataset.category === catSlug) ? '' : 'none';
                }
            });
        }
    </script>
@endsection
