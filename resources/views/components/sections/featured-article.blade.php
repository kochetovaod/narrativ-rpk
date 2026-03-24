@props(['article'])

@if ($article)
    <section class="section section--dark">
        <div class="container">
            <x-cards.featured-article :article="$article" />
        </div>
    </section>
@endif
