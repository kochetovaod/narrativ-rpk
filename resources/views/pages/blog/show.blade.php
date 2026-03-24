@extends('layouts.app')

@section('meta')
    {!! SEO::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    {!! JsonLd::generate() !!}
@endsection

@section('preload')
    <link
        rel="preload"
        as="image"
        href="{{ $article->detail->url }}"
        fetchpriority="high">
    @if ($article->employee?->preview?->url)
        <link
            rel="preload"
            as="image"
            href="{{ $article->employee->preview->url }}"
            fetchpriority="low">
    @endif
@endsection

@section('content')
    @php Carbon\Carbon::setLocale('ru'); @endphp

    {{-- Прогресс-бар чтения --}}
    <x-blocks.reading-progress />

    {{-- Hero статьи --}}
    <x-sections.article-hero :article="$article" />

    {{-- Основной контент статьи --}}
    <x-sections.article-content
        :article="$article"
        :related-articles="$relatedArticles" />

    {{-- Похожие статьи --}}
    <x-sections.related-articles :articles="$relatedArticles" />

    <script>
        // Reading progress bar
        window.addEventListener('scroll', () => {
            const article = document.getElementById('articleBody');
            const bar = document.getElementById('readProgress');
            const rect = article.getBoundingClientRect();
            const total = article.offsetHeight - window.innerHeight;
            const scrolled = Math.max(0, -rect.top);
            const pct = Math.min(100, (scrolled / total) * 100);
            bar.style.width = pct + '%';
        });

        // TOC active state
        const sections = document.querySelectorAll('[id]');
        const tocLinks = document.querySelectorAll('.article-toc a');
        if (tocLinks.length) {
            window.addEventListener('scroll', () => {
                let current = '';
                sections.forEach(s => {
                    if (window.scrollY >= s.offsetTop - 120) current = s.id;
                });
                tocLinks.forEach(link => {
                    link.classList.toggle('active', link.getAttribute('href') === '#' + current);
                });
            });
        }

        function copyLink(e) {
            e.preventDefault();
            navigator.clipboard.writeText(window.location.href).then(() => {
                const btn = e.currentTarget;
                btn.style.background = 'rgba(0,196,184,0.2)';
                setTimeout(() => btn.style.background = '', 1500);
            });
        }

        function openCallbackModal() {
            // Ваша логика открытия модалки с формой обратной связи
            console.log('Open callback modal');
        }
    </script>
@endsection
