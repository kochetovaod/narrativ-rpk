@props(['tags'])

<div style="margin-bottom:36px;">
    <div class="filter-tabs">
        <button
            class="filter-tab active"
            data-filter="all"
            onclick="filterBlog(this,'all')">
            Все
        </button>
        @foreach ($tags as $tag)
            <button
                class="filter-tab"
                data-filter="{{ $tag->slug }}"
                onclick="filterBlog(this,'{{ $tag->slug }}')">
                {{ $tag->title }}
            </button>
        @endforeach
    </div>
</div>
