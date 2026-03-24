@props(['articles'])

@if ($articles->isNotEmpty())
    <section class="section section--gray">
        <div class="container">
            <div class="section-label">Читайте также</div>
            <h2 class="section-title">Другие статьи</h2>

            <div class="blog-page__grid">
                @foreach ($articles as $article)
                    <x-cards.blog-article :article="$article" />
                @endforeach
            </div>

            <div style="text-align:center; margin-top:48px;">
                <a href="{{ route('blog.index') }}" class="btn btn--outline">
                    Все статьи блога →
                </a>
            </div>
        </div>
    </section>
@endif
