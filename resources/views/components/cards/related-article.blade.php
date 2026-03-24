@props(['article'])

<a href="{{ route('blog.show', $article->slug) }}" class="related-card">
    <div class="related-card__img">
        @if ($article->preview)
            <img
                src="{{ $article->preview->url }}"
                alt="{{ $article->preview->alt ?? $article->title }}"
                loading="lazy"
                onerror="this.parentElement.style.background='#222'">
        @else
            <div style="width:100%; height:100%; background:#222;"></div>
        @endif
    </div>
    <div>
        <div class="related-card__title">{{ $article->title }}</div>
        <div class="related-card__date">
            {{ $article->published_at->isoFormat('D MMMM YYYY') }}
        </div>
    </div>
</a>
