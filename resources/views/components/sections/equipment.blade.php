@props([
    'equipment',
    'label' => 'Наше производство',
    'title' => 'Оборудование',
    'subtitle' =>
        'Собственный цех оснащён современным оборудованием ведущих мировых брендов для любых задач производства.',
])

<style>
    .equipment__grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }

    .equipment__card_photo {
        aspect-ratio: 4/3;
        overflow: hidden;
        background: #111;
    }

    .equipment__card_photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .equipment__card_content {
        padding: 24px;
    }

    .equipment__card_title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .equipment__card_text {
        font-size: 14px;
        color: var(--color-text-dim);
    }


    @media (max-width: 1024px) {
        .equipment__grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .equipment__grid {
            grid-template-columns: 1fr;
        }
    }
</style>
<section class="section section--dark" itemscope itemtype="https://schema.org/ItemList">
    <div class="container">
        <x-sections.header :label="$label" :title="$title" :subtitle="$subtitle" />
        <meta itemprop="numberOfItems" content="{{ count($equipment) }}">
        <div class="equipment__grid">
            @foreach ($equipment as $item)
                <div class="equipment__card" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <meta itemprop="position" content="{{ $loop->index + 1 }}">
                    <div itemprop="item" itemscope itemtype="https://schema.org/HowToTool">
                        <div class="equipment__card_photo">
                            <img src="{{ $item->preview->url }}" alt="{{ $item->title }}" loading="lazy"
                                onerror="this.style.display='none'">
                        </div>
                    </div>
                    <div class="equipment__card_content">
                        <h3 class="equipment__card_title" itemprop="name">{{ $item->title }}</h3>
                        <p class="equipment__card_text" itemprop="description">{{ $item->excerpt }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <x-ui.btn-route-to :route="route('equipment')" label="Всё оборудование" />
    </div>
</section>
