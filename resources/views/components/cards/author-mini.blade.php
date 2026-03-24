@props(['employee'])

<div class="article-author">
    @if ($employee && $employee->preview)
        <div class="article-author__avatar">
            <img
                class="author-avatar_img"
                src="{{ $employee->preview->url }}"
                alt="фото {{ $employee->title }}">
        </div>
    @endif
    <div>
        <div class="article-author__name">{{ $employee->title ?? 'Нарратив' }}</div>
        <div class="article-author__role">{{ $employee->excerpt ?? 'Эксперт компании' }}</div>
    </div>
</div>
