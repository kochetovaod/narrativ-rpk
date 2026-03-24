@extends('layouts.app')

@section('title', 'Нарратив - Производство наружной рекламы')
@section('body_class', 'page-home')

@section('meta')
    <meta name="description"
        content="Полный спектр услуг по производству наружной и интерьерной рекламы. От идеи до реализации.">
@endsection

@section('content')
    <!-- Hero Bridge Sections -->
    @include('components.blocks.hero.bridge-wrapper')

    <!-- Image Slider -->
    @include('components.blocks.image-slider')

    <!-- Services Preview -->
    @include('components.blocks.services-preview')

    <!-- Products Slider -->
    @include('components.blocks.products-slider')

    <!-- Equipment Grid -->
    @include('components.blocks.equipment-grid')

    <!-- Portfolio Preview -->
    @include('components.blocks.portfolio-preview')

    <!-- Blog Preview -->
    @include('components.blocks.blog-preview')

    <!-- FAQ Section -->
    @include('components.blocks.faq-section')

    <!-- Lead Form -->
    @include('components.blocks.lead-form')
@endsection
