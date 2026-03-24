@props(['article'])

<div class="article-meta-items">
    <span>
        <x-icon name="date" width="18" height="18" />
        {{ $article->published_at->isoFormat('D MMMM YYYY') }}
    </span>
    <span>
        <x-icon name="time" width="18" height="18" />
        Читать {{ $article->time_read }} мин
    </span>
    <span>
        <x-icon name="eye" width="18" height="18" />
        {{ $article->views }} просмотров
    </span>
</div>
