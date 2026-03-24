@props(['tags'])

@if ($tags->isNotEmpty())
    <div class="article-tags">
        @foreach ($tags as $tag)
            <a
                href="{{ route('blog.index', ['tag' => $tag->slug]) }}"
                class="article-tag">
                #{{ $tag->title }}
            </a>
        @endforeach
    </div>
@endif
