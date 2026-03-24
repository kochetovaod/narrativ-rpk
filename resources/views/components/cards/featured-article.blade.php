@props(['article'])

<a href="{{ route('blog.show', $article->slug) }}" class="blog-hero-card">
    <img
        src="{{ $article->detail->url }}"
        alt="{{ $article->detail->alt ?? $article->title }}"
        loading="lazy"
        onerror="this.style.background='#111'">
    <div class="blog-hero-card__overlay"></div>
    <div class="blog-hero-card__body">
        <span class="blog-hero-card__tag">{{ $article->category->title }}</span>
        <h2 class="blog-hero-card__title">{{ $article->title }}</h2>
        <div class="blog-hero-card__meta">
            {{ $article->published_at->isoFormat('D MMMM YYYY') }}&nbsp;•&nbsp;
            Читать {{ $article->time_read }} мин
        </div>
        <span class="blog-hero-card__read">
            Читать статью
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </span>
    </div>
</a>
