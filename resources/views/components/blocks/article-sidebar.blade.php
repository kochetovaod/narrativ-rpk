@props(['relatedArticles'])

<aside class="article-sidebar">
    {{-- Блок консультации --}}
    <x-blocks.consultation-block />

    {{-- Похожие статьи в сайдбаре --}}
    @if ($relatedArticles->isNotEmpty())
        <div class="article-sidebar__block">
            <div class="article-sidebar__title">Похожие статьи</div>
            <div>
                @foreach ($relatedArticles as $related)
                    <x-cards.related-article :article="$related" />
                @endforeach
            </div>
        </div>
    @endif
</aside>
