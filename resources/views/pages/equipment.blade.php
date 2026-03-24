@extends('layouts.app')

@section('title', 'Оборудование — Нарратив')

@section('content')

    <x-sections.hero
        :current="$page->title"
        itemtype="AboutPage"
        :image="$page->preview->url"
        :label="setting('equipment.hero.label')"
        :title="setting('equipment.hero.title')"
        :subtitle="setting('equipment.hero.subtitle')" />

    <x-sections.intro :page="$page">
        <x-cards.key-value :items="$page->properties" />
    </x-sections.intro>

    <x-blocks.icon-cards-grid
        metaname="Технологии"
        metadescription="Технологии, используемые в производстве"
        iconsize=40
        columns=3
        :label="setting('equipment.technology.label')"
        :title="setting('equipment.technology.title')"
        :items="$technologies" />

    <x-sections.main-equipment :items="$equipment" />

    <x-blocks.icon-cards-grid
        metaname="Материалы"
        metadescription="Материалы, используемые в производстве"
        iconsize=40
        columns=4
        :label="setting('equipment.material.label')"
        :title="setting('equipment.material.title')"
        :items="$materials" />

    <x-sections.cta />
@endsection
