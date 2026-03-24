    @props(['advantages'])

    <section class="section section--dark"
        itemscope
        itemtype="https://schema.org/ItemList">
        <div class="container">
            <meta itemprop="name"
                content="Ключевые преимущества компании {{ setting('site_name') }}">
            <meta itemprop="description"
                content="Преимущества работы с нами, наши сильные стороны и конкурентные преимущества">
            <meta itemprop="numberOfItems"
                content="{{ count($advantages) }}">

            <x-sections.header
                :label="setting('about.advantages.label')"
                :title="setting('about.advantages.title')" />

            <div class="advantages-grid">
                @foreach ($advantages as $item)
                    <x-cards.advantage
                        :item="$item"
                        :position="$loop->iteration" />
                @endforeach
            </div>
        </div>
    </section>
