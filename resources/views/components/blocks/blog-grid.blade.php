@props(['articles'])

<div class="blog-page__grid" id="blogGrid">
    @foreach ($articles as $article)
        <x-cards.blog-article :article="$article" />
    @endforeach
</div>

{{-- Если используете пагинацию --}}
@if (method_exists($articles, 'links'))
    <div class="pagination-wrapper">
        {{ $articles->links() }}
    </div>
@endif
