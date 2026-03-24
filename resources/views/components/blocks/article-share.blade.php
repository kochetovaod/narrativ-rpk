@props(['article'])

<div class="article-share">
    <span class="article-share__label">Поделиться:</span>

    {{-- VK --}}
    <a href="https://vk.com/share.php?url={{ urlencode(request()->url()) }}&title={{ urlencode($article->title) }}"
        class="share-btn" target="_blank" title="ВКонтакте" rel="noopener noreferrer">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path
                d="M8.84 11.5h1.04s.31-.04.47-.2c.15-.16.14-.44.14-.44s-.02-1.34.6-1.53c.62-.2 1.42 1.3 2.27 1.87.64.43 1.12.33 1.12.33l2.24-.03s1.17-.07.62-.99c-.05-.07-.33-.7-1.72-1.97-1.46-1.33-1.26-1.11.49-3.42 1.07-1.42 1.5-2.3 1.36-2.66-.13-.35-.93-.26-.93-.26l-2.52.02s-.19-.02-.33.07c-.14.09-.22.3-.22.3s-.42 1.12-1 2.1c-1.2 2.04-1.68 2.15-1.88 2.02-.46-.3-.34-1.17-.34-1.8 0-1.96.3-2.77-.57-2.99-.29-.07-.5-.11-1.24-.12-.94-.01-1.73.01-2.18.22-.3.14-.53.46-.39.48.17.02.56.1.77.38.27.36.26 1.17.26 1.17s.15 2.3-.37 2.59c-.35.2-.84-.21-1.88-2.1-.55-.95-.97-2-.97-2s-.08-.2-.22-.3c-.16-.12-.4-.16-.4-.16l-2.4.02s-.36.01-.49.17c-.12.14-.01.43-.01.43s1.88 4.4 4 6.62c1.95 2.04 4.16 1.9 4.16 1.9z"
                fill="currentColor" fill-opacity=".5" />
        </svg>
    </a>

    {{-- Telegram --}}
    <a href="https://t.me/share/url?url={{ urlencode(request()->url()) }}&text={{ urlencode($article->title) }}"
        class="share-btn" target="_blank" title="Telegram" rel="noopener noreferrer">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path
                d="M8 1a7 7 0 100 14A7 7 0 008 1zm3.43 4.79l-1.31 6.18c-.1.43-.36.54-.72.33l-2-1.47-1.02 1a.23.23 0 01-.27.03l.23-2.04L9.9 6.6c.13-.12-.02-.18-.21-.07L4.8 9.5l-1.96-.61c-.43-.13-.44-.43.1-.64l7.65-2.95c.35-.13.66.09.54.59z"
                fill="currentColor" fill-opacity=".5" />
        </svg>
    </a>

    {{-- WhatsApp --}}
    <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . request()->url()) }}"
        class="share-btn" target="_blank" title="WhatsApp" rel="noopener noreferrer">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path
                d="M8 1C4.13 1 1 4.13 1 8c0 1.28.35 2.5.95 3.55L1 15l3.55-.93A6.94 6.94 0 008 15c3.87 0 7-3.13 7-7s-3.13-7-7-7zm3.5 9.5c-.15.42-1 .8-1.37.85-.34.05-.77.07-1.24-.08-.28-.09-.65-.21-1.12-.41-1.96-.85-3.24-2.84-3.34-2.97-.1-.13-.8-1.06-.8-2.03 0-.97.5-1.44.69-1.64.18-.2.4-.25.53-.25s.27.01.38.01c.12.01.29-.04.45.34.17.39.57 1.38.62 1.48.05.1.08.22.01.35-.07.13-.1.21-.2.32-.1.11-.21.24-.3.33-.1.1-.2.2-.09.4.12.2.52.86 1.12 1.39.77.68 1.42.9 1.62.99.2.1.32.08.44-.05.12-.13.5-.58.63-.78.13-.2.26-.17.44-.1.18.07 1.14.54 1.34.63.2.1.33.14.38.22.05.09.05.52-.1.94z"
                fill="currentColor" fill-opacity=".5" />
        </svg>
    </a>

    {{-- Копировать ссылку --}}
    <button class="share-btn" title="Скопировать ссылку" onclick="copyLink(event)">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
            <path d="M6.5 9.5a3.54 3.54 0 005 0l2-2a3.54 3.54 0 00-5-5l-1.1 1.1" stroke="currentColor"
                stroke-width="1.4" stroke-linecap="round" />
            <path d="M9.5 6.5a3.54 3.54 0 00-5 0l-2 2a3.54 3.54 0 005 5L8.6 12.4" stroke="currentColor"
                stroke-width="1.4" stroke-linecap="round" />
        </svg>
    </button>
</div>

@push('scripts')
    <script>
        window.copyLink = function(event) {
            const button = event.currentTarget;
            const url = window.location.href;

            navigator.clipboard.writeText(url).then(() => {
                const originalHtml = button.innerHTML;
                button.innerHTML =
                    '<svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M13 4L6 11L3 8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>';
                setTimeout(() => {
                    button.innerHTML = originalHtml;
                }, 2000);
            });
        };
    </script>
@endpush
