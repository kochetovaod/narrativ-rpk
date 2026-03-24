@extends('layouts.app')

@section('title', $service->title . ' — Нарратив')

@section('content')
    <!-- Page Hero -->
    <x-sections.hero
        :current="$service->title"
        :breadcrumbItems="[
            [
                'url' => route('services.index'),
                'title' => 'Услуги',
            ],
        ]"
        itemtype="ServicePage"
        :image="$service->preview->url"
        label="Это мы делаем"
        :title="$service->title"
        :subtitle="$service->excerpt" />

    <!-- Main content -->
    <section class="section section--dark">
        <div class="container">
            <div class="service-layout">

                {{-- ===================== ARTICLE ===================== --}}
                <article class="service-body">

                    {{-- Основной HTML-контент услуги --}}
                    <div class="service-content">
                        {!! $service->content !!}
                    </div>

                </article>

                {{-- ===================== SIDEBAR ===================== --}}
                <aside class="service-sidebar">

                    {{-- Карточка: характеристики + гарантия --}}
                    <div class="service-sidebar__card service-sidebar__card--sticky">

                        {{-- Цена --}}
                        @if ($service->price_from)
                            <div class="service-sidebar__price">
                                <span class="service-sidebar__price-label">Стоимость от</span>
                                <span class="service-sidebar__price-value">
                                    {{ number_format($service->price_from, 0, '.', ' ') }} ₽
                                </span>
                            </div>
                        @endif

                        {{-- Свойства --}}
                        @if ($service->properties && count($service->properties))
                            <ul class="service-props">
                                @foreach ($service->properties as $prop)
                                    <li class="service-props__item">
                                        <span class="service-props__key">{{ $prop['key'] }}</span>
                                        <span class="service-props__val">{{ $prop['value'] }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        {{-- Гарантия --}}
                        @if ($service->guarantee)
                            <div class="service-sidebar__guarantee">
                                <x-icon name="shield" width="18" height="18" />
                                <span>Гарантия — <strong>{{ $service->guarantee }}</strong></span>
                            </div>
                        @endif
                    </div>

                </aside>
                <section class="section section--gray">
                    <div class="container">
                        {{-- Блок: Этапы работы --}}
                        @if ($service->process_steps && count($service->process_steps))
                            <x-sections.header :title="setting('service.process.title')"
                                :label="setting('service.process.label')"
                                :subtitle="setting('service.process.subtitle')" />

                            <div class="service-process">
                                @foreach ($service->process_steps as $index => $step)
                                    <div class="step-card">
                                        <div class="step-card__num">{{ $index + 1 }}</div>
                                        <div class="step-card__body">
                                            <div class="step-card__title">{{ $step['key'] }}</div>
                                            <div class="step-card__text">{{ $step['value'] }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        @endif
                    </div>
                </section>
            </div>
        </div>
    </section>

    <!-- Portfolio preview -->
    <section class="section section--dark">
        <div class="container">
            <div class="section-label">Наши работы по этой услуге</div>
            <h2 class="section-title">Реализованные проекты</h2>
            <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-bottom:40px;">
                @foreach ($service->portfolios()->limit(3)->get() as $work)
                    <a href="{{ route('portfolio.show', $work->slug) }}"
                        style="border-radius:10px; overflow:hidden; display:block; aspect-ratio:4/3; position:relative;">
                        <img src="{{ $work->preview->url }}" alt="{{ $work->title }}"
                            style="width:100%;height:100%;object-fit:cover;"
                            onerror="this.parentElement.style.background='#111'">
                        <div
                            style="position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,.7) 0%,transparent 50%);display:flex;align-items:flex-end;padding:16px;">
                            <span style="font-size:13px;font-weight:600;color:#fff;">{{ $work->title }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
            <div style="text-align:center;">
                <a href="{{ route('portfolio.index') }}" class="btn btn--outline">Смотреть все работы →</a>
            </div>
        </div>
    </section>

@endsection
