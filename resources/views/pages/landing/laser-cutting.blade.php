@extends('layouts.app')

@section('title', 'Лазерная резка — Нарратив')

@section('content')
    <!-- Page Hero -->
    <section class="page-hero">
        <div class="container">
            <div class="page-hero__breadcrumb">
                <a href="{{ route('home') }}">Главная</a>
                <span>›</span>
                <a href="{{ route('services.index') }}">Услуги</a>
                <span>›</span>
                <span>Лазерная резка</span>
            </div>
            <div class="section-label">Услуга</div>
            <h1 class="page-hero__title">Лазерная резка</h1>
            <p class="page-hero__subtitle">Точная резка любых материалов с помощью современного лазерного оборудования</p>
        </div>
    </section>

    <!-- Service Details -->
    <section class="section section--dark">
        <div class="container">
            <p style="color:var(--color-text-dim);">Лазерная резка — современный метод обработки материалов...</p>
        </div>
    </section>

    <!-- CTA -->
    @include('components.sections.cta-block')
@endsection
