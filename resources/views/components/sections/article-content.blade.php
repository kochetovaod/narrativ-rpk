@props(['article', 'relatedArticles'])

<section class="section section--dark">
    <div class="container">
        <div class="article-layout">
            {{-- Основной контент --}}
            <article class="article-body" id="articleBody">
                {!! $article->content !!}

                {{-- Теги --}}
                <x-blocks.article-tags :tags="$article->tags" />

                {{-- Кнопки поделиться --}}
                <x-blocks.article-share :article="$article" />

                {{-- Блок автора --}}
                <x-cards.author-block :employee="$article->employee" />
            </article>

            {{-- Сайдбар --}}
            <x-blocks.article-sidebar
                :related-articles="$relatedArticles" />
        </div>
    </div>
</section>
