@props(['employee'])

@if ($employee)
    <div class="author-block">
        <div class="author-block__avatar">
            <img
                class="author-avatar_img"
                src="{{ $employee->preview->url }}"
                alt="фото {{ $employee->title }}">
        </div>
        <div>
            <div class="author-block__name">{{ $employee->title }}</div>
            <div class="author-block__role">{{ $employee->excerpt ?? 'Эксперт компании' }}</div>
            @if ($employee->content)
                <p class="author-block__bio">{{ $employee->content }}</p>
            @endif
        </div>
    </div>
@endif
