@props(['article'])

<div class="article-hero">
    <img
        class="article-hero__img"
        src="{{ $article->detail->url }}"
        alt="{{ $article->title }}">
    <div class="article-hero__overlay"></div>
    <div class="article-hero__content">
        <div class="container">
            <x-navigation.breadcrumb
                :items="[
                    [
                        'url' => route('blog.index'),
                        'title' => 'Блог',
                    ],
                ]"
                :current="$article->title" />

            <span class="article-hero__tag">
                {{ $article->category->title ?? 'Блог' }}
            </span>

            <h1 class="article-hero__title">{{ $article->title }}</h1>

            <div class="article-hero__meta">
                <x-cards.author-mini :employee="$article->employee" />
                <x-blocks.article-meta :article="$article" />
            </div>
        </div>
    </div>
</div>
