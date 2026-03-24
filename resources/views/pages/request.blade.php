@extends('layouts.app')

@section('title', 'Заявка — Нарратив')

@section('content')
    <!-- Page Hero -->
    <section class="page-hero">
        <div class="container">
            <div class="page-hero__breadcrumb">
                <a href="{{ route('home') }}">Главная</a>
                <span>›</span>
                <span>Заявка</span>
            </div>
            <div class="section-label">Оставьте заявку</div>
            <h1 class="page-hero__title">Оставить заявку</h1>
            <p class="page-hero__subtitle">Заполните форму, и мы свяжемся с вами в течение 15 минут</p>
        </div>
    </section>

    <!-- Request Form -->
    <section class="section section--dark">
        <div class="container">
            <div style="max-width:600px; margin:0 auto;">
                @include('components.blocks.lead-form')
            </div>
        </div>
    </section>
@endsection
