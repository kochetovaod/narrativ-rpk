@props(['items'])

<section class="section section--gray">
    <div class="container">
        <x-sections.header :label="setting('equipment.main.label')" :title="setting('equipment.main.title')" />
        <div class="equipment-main-grid">
            @foreach ($items->take(2) as $item)
                <x-cards.equipment :item="$item" :i="$loop->iteration" />
            @endforeach
        </div>
        <div class="equipment-side-grid">
            @foreach ($items->slice(2) as $item)
                <x-cards.equipment
                    :item="$item"
                    :i="$loop->iteration + 2" />
            @endforeach
        </div>
    </div>
</section>
