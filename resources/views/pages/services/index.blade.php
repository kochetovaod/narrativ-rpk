@extends('layouts.app')

@section('title', 'Услуги — Нарратив')

@section('content')
    <!-- Page Hero -->
    <x-sections.hero
        :current="$page->title"
        itemtype="ServivePage"
        :image="$page->preview->url"
        :label="setting('services.hero.label')"
        :title="setting('services.hero.title')"
        :subtitle="setting('services.hero.subtitle')" />
    <!-- Services Grid -->
    <section class="section section--dark">
        <div class="container">
            <div class="services-page__grid" id="servicesGrid">
                @foreach ($services as $index => $service)
                    <a href="{{ route('services.show', $service->slug) }}"
                        class="service-card-large">
                        <img src="{{ $service->preview->url }}" alt="{{ $service->title }}" loading="lazy">
                        <div class="service-card-large__overlay"></div>
                        <div class="service-card-large__body">
                            <h2 class="service-card-large__title">{{ $service->title }}</h2>
                            <p class="service-card-large__desc">{{ $service->except }}</p>
                            <span class="service-card-large__arrow">Подробнее
                                <x-icon name="arrow" width="16" height="16" />
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Process -->
    <section class="section section--gray">
        <div class="container">
            <div class="section-label">@setting('services.process.label')</div>
            <h2 class="section-title">@setting('services.process.label')</h2>
            <div class="steps-container">
                <div class="steps-divider"></div>

                <!-- Steps -->
                @php
                    $properties = json_decode($page->properties, true) ?? [];
                @endphp

                @foreach ($properties as $index => $item)
                    <div class="step-item">
                        <div class="step-number">0{{ $index + 1 }}</div>
                        <h3 class="step-title">{{ $item['value'] }}</h3>
                        <p class="step-description">{{ $item['key'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
