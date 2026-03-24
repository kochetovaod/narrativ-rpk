@extends('layouts.app')

@section('meta')
    {!! SEO::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    {!! JsonLd::generate() !!}
@endsection

@section('preload')
    @foreach ($clients as $client)
        <link
            rel="preload"
            as="image"
            href="{{ $client->preview->url }}"
            fetchpriority="high">
    @endforeach
@endsection
@section('content')
    <!-- Page Hero -->

    <x-sections.hero
        :current="$page->title"
        itemtype="AboutPage"
        :image="$page->preview->url"
        :label="setting('about.hero.label')"
        :title="setting('about.hero.title')"
        :subtitle="setting('about.hero.subtitle')" />

    <x-sections.intro :page="$page">
        <x-cards.primary_image
            :src="$page->detail->url"
            :title="$page->title" />
    </x-sections.intro>

    <x-sections.stats :items="$stats" />


    <x-blocks.icon-cards-grid
        metaname="Ключевые преимущества компании"
        metadescription="Преимущества работы с нами, наши сильные стороны и конкурентные преимущества"
        iconsize=40
        columns=3
        :label="setting('about.advantages.label')"
        :title="setting('about.advantages.title')"
        :items="$advantages" />

    <x-sections.partners
        :clients="$clients"
        :label="setting('about.partners.label')"
        :title="setting('about.partners.title')" />

    <x-sections.equipment
        :equipment="$equipment"
        :label="setting('about.equipment.label')"
        :title="setting('about.equipment.title')"
        :subtitle="setting('about.equipment.subtitle')" />

    <x-sections.portfolio
        :works="$works"
        :label="setting('about.portfolio.label')"
        :title="setting('about.portfolio.title')" />

    <x-sections.cta />
@endsection
