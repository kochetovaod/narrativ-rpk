@props(['article'])

<a
    href="{{ route('blog.show', $article->slug) }}"
    class="blog-page-card"
    data-category="{{ $article->category->slug }}"
    data-tags="{{ $article->tags->pluck('slug')->implode(' ') }}">

    <div class="blog-page-card__image">
        <img
            src="{{ $article->preview->url }}"
            alt="{{ $article->preview->alt ?? $article->title }}"
            loading="lazy"
            onerror="this.style.background='#111'">
        <div class="blog-page-card__tags">
            <span class="blog-page-card__tag">{{ $article->category->title }}</span>
        </div>
    </div>

    <div class="blog-page-card__body">
        <div class="blog-page-card__meta">
            <span>{{ $article->published_at->isoFormat('D MMM YYYY') }}</span>
            <span class="blog-page-card__meta-sep"></span>
            <span>{{ $article->time_read }} мин</span>
        </div>

        <h3 class="blog-page-card__title">{{ $article->title }}</h3>

        @if ($article->excerpt)
            <p class="blog-page-card__excerpt">{{ $article->excerpt }}</p>
        @endif

        <span class="blog-page-card__read">
            Читать статью
            <svg width="14" height="14" viewBox="0 0 16 16" fill="none">
                <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </span>
    </div>
</a>
