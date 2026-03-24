@props(['articles', 'tags', 'categories', 'totalCount'])

<section class="section section--dark">
    <div class="container">
        <div class="blog-layout">
            {{-- Основная колонка со статьями --}}
            <div>
                {{-- Фильтр по тегам --}}
                <x-blocks.blog-filters :tags="$tags" />

                {{-- Сетка статей --}}
                <x-blocks.blog-grid :articles="$articles" />
            </div>

            {{-- Сайдбар --}}
            <x-blocks.blog-sidebar
                :categories="$categories"
                :total-count="$totalCount" />
        </div>
    </div>
</section>

@push('scripts')
    <script>
        function filterBlog(btn, tagSlug) {
            document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
            btn.classList.add('active');

            document.querySelectorAll('.blog-sidebar__cat').forEach(c => c.classList.remove('active'));

            document.querySelectorAll('.blog-page-card').forEach(card => {
                if (tagSlug === 'all') {
                    card.style.display = '';
                } else {
                    const cardTags = card.dataset.tags.split(' ');
                    card.style.display = cardTags.includes(tagSlug) ? '' : 'none';
                }
            });
        }

        function filterBlogSidebar(element, catSlug) {
            document.querySelectorAll('.blog-sidebar__cat').forEach(c => c.classList.remove('active'));
            element.classList.add('active');

            document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
            document.querySelector('.filter-tab[data-filter="all"]').classList.add('active');

            document.querySelectorAll('.blog-page-card').forEach(card => {
                if (catSlug === 'all') {
                    card.style.display = '';
                } else {
                    card.style.display = (card.dataset.category === catSlug) ? '' : 'none';
                }
            });
        }
    </script>
@endpush
