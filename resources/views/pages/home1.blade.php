@extends('layouts.app')

@section('title', 'Нарратив - Производство наружной рекламы')
@section('body_class', 'page-home')

@section('meta')
    <meta name="description"
        content="Полный спектр услуг по производству наружной и интерьерной рекламы. От идеи до реализации.">
@endsection
@push('styles')
    <style>
        /* ==========================================
                                                           ZERO BLOCK — Layered Scroll Animation
                                                           ========================================== */
        .zero-block {
            position: relative;
            height: 500vh;
        }

        .zero-sticky {
            position: sticky;
            top: 0;
            height: 100vh;
            overflow: hidden;
        }

        .zero-layer {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            transition: opacity 0.05s linear;
        }

        .zero-layer img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .zero-layer--1 {
            opacity: 1;
            z-index: 1;
        }

        .zero-layer--2 {
            opacity: 0;
            z-index: 2;
        }

        .zero-layer--3 {
            opacity: 0;
            z-index: 3;
        }

        .zero-layer--4 {
            opacity: 0;
            z-index: 4;
        }

        .zero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom,
                    rgba(0, 0, 0, 0.3) 0%,
                    rgba(0, 0, 0, 0.15) 40%,
                    rgba(0, 0, 0, 0.5) 100%);
            z-index: 10;
        }

        .zero-text-area {
            position: absolute;
            inset: 0;
            z-index: 11;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding: 0 8vw;
            pointer-events: none;
        }

        .zero-phrase {
            position: absolute;
            left: 8vw;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0;
            transition: opacity 0.4s ease;
            max-width: 680px;
        }

        .zero-phrase.active {
            opacity: 1;
        }

        .zero-phrase__label {
            font-family: var(--font-family);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: var(--color-primary);
            margin-bottom: 16px;
            display: block;
        }

        .zero-phrase__title {
            font-family: var(--font-family);
            font-size: clamp(42px, 6vw, 88px);
            font-weight: 300;
            line-height: 1.1;
            color: #ffffff;
            margin: 0;
            letter-spacing: -1px;
        }

        .zero-phrase__title em {
            font-style: italic;
            color: var(--color-accent-soft);
        }

        .zero-progress {
            position: absolute;
            bottom: 50px;
            left: 8vw;
            z-index: 12;
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .zero-progress__step {
            width: 32px;
            height: 2px;
            background: rgba(255, 255, 255, 0.25);
            transition: all 0.4s ease;
            cursor: default;
        }

        .zero-progress__step.active {
            background: var(--color-primary);
            width: 64px;
        }

        .zero-scroll-hint {
            position: absolute;
            bottom: 44px;
            right: 8vw;
            z-index: 12;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            color: rgba(255, 255, 255, 0.5);
        }

        .zero-scroll-hint span {
            font-size: 10px;
            letter-spacing: 3px;
            text-transform: uppercase;
            writing-mode: vertical-rl;
        }

        .zero-scroll-hint__line {
            width: 1px;
            height: 50px;
            background: linear-gradient(to bottom, var(--color-primary), transparent);
            animation: scrollLine 2s ease-in-out infinite;
        }

        @keyframes scrollLine {
            0% {
                transform: scaleY(0);
                transform-origin: top;
            }

            50% {
                transform: scaleY(1);
                transform-origin: top;
            }

            51% {
                transform: scaleY(1);
                transform-origin: bottom;
            }

            100% {
                transform: scaleY(0);
                transform-origin: bottom;
            }
        }

        /* ==========================================
                                                           IMAGO CAROUSEL — Image Slides
                                                           ========================================== */
        .imago-section {
            position: relative;
            height: 100vh;
            min-height: 600px;
            overflow: hidden;
            background: #000;
        }

        .imago-track {
            display: flex;
            height: 100%;
            transition: transform 0.9s cubic-bezier(0.77, 0, 0.18, 1);
            will-change: transform;
        }

        .imago-slide {
            min-width: 100%;
            height: 100%;
            position: relative;
            flex-shrink: 0;
        }

        .imago-slide__bg {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            transform: scale(1.05);
            transition: transform 0.9s ease;
        }

        .imago-slide.active .imago-slide__bg {
            transform: scale(1);
        }

        .imago-slide__overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.75) 0%, rgba(0, 0, 0, 0.2) 60%);
        }

        .imago-slide__content {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 0 10vw;
        }

        .imago-slide__num {
            font-family: var(--font-family);
            font-size: 120px;
            font-weight: 300;
            color: rgba(184, 134, 11, 0.12);
            line-height: 1;
            margin-bottom: -20px;
            user-select: none;
        }

        .imago-slide__stat {
            font-family: var(--font-family);
            font-size: clamp(52px, 7vw, 96px);
            font-weight: 600;
            color: #ffffff;
            line-height: 1;
            margin-bottom: 16px;
        }

        .imago-slide__stat span {
            color: var(--color-primary);
        }

        .imago-slide__desc {
            font-size: 15px;
            color: rgba(255, 255, 255, 0.7);
            max-width: 500px;
            line-height: 1.7;
            font-weight: 300;
        }

        .imago-controls {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 32px 10vw;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7), transparent);
        }

        .imago-dots {
            display: flex;
            gap: 10px;
        }

        .imago-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            cursor: pointer;
            transition: all 0.4s ease;
            border: none;
        }

        .imago-dot.active {
            background: var(--color-primary);
            width: 28px;
            border-radius: 3px;
        }

        .imago-arrows {
            display: flex;
            gap: 12px;
        }

        .imago-arrow {
            width: 48px;
            height: 48px;
            border: 1px solid rgba(184, 134, 11, 0.4);
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(8px);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .imago-arrow:hover {
            background: var(--color-primary);
            border-color: var(--color-primary);
        }

        /* Backgrounds for imago slides */
        .imago-slide:nth-child(1) .imago-slide__bg {
            background-image: linear-gradient(to bottom right, #1a1a2e, #16213e);
        }

        .imago-slide:nth-child(2) .imago-slide__bg {
            background-image: linear-gradient(to bottom right, #0d0d0d, #1a1000);
        }

        .imago-slide:nth-child(3) .imago-slide__bg {
            background-image: linear-gradient(to bottom right, #0d1a0d, #1a2a0d);
        }

        .imago-slide:nth-child(4) .imago-slide__bg {
            background-image: linear-gradient(to bottom right, #1a0d1a, #2a0d2a);
        }

        .imago-slide:nth-child(5) .imago-slide__bg {
            background-image: linear-gradient(to bottom right, #1a0a00, #2a1500);
        }

        /* ==========================================
                                                           SERVICES BLOCK
                                                           ========================================== */
        .services-section {
            padding: 120px 0;
            background: #000;
        }

        .section-header {
            margin-bottom: 60px;
        }

        .section-header__label {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: var(--color-primary);
            margin-bottom: 16px;
            display: block;
        }

        .section-header__title {
            font-family: var(--font-family);
            font-size: clamp(36px, 4vw, 64px);
            font-weight: 400;
            color: #fff;
            line-height: 1.1;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-template-rows: repeat(2, 280px);
            gap: 3px;
        }

        .service-tile {
            position: relative;
            overflow: hidden;
            cursor: pointer;
            background: #111;
        }

        .service-tile__bg {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            transition: transform 0.6s ease, filter 0.4s ease;
            filter: brightness(0.55);
        }

        .service-tile:hover .service-tile__bg {
            transform: scale(1.07);
            filter: brightness(0.7);
        }

        .service-tile__border {
            position: absolute;
            inset: 0;
            border: 2px solid transparent;
            transition: border-color 0.4s ease;
            z-index: 3;
            pointer-events: none;
        }

        .service-tile:hover .service-tile__border {
            border-color: var(--color-primary);
        }

        .service-tile__content {
            position: absolute;
            inset: 0;
            z-index: 2;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 28px;
        }

        .service-tile__icon {
            font-size: 28px;
            margin-bottom: 10px;
            opacity: 0.8;
        }

        .service-tile__name {
            font-size: 18px;
            font-weight: 600;
            color: #fff;
            line-height: 1.3;
            margin-bottom: 8px;
        }

        .service-tile__hint {
            font-size: 13px;
            color: rgba(255, 255, 255, 0);
            transition: color 0.4s ease, transform 0.4s ease;
            transform: translateY(6px);
            line-height: 1.5;
        }

        .service-tile:hover .service-tile__hint {
            color: rgba(255, 255, 255, 0.7);
            transform: translateY(0);
        }

        /* Gradient fallbacks for service tiles */
        .service-tile:nth-child(1) .service-tile__bg {
            background-image: linear-gradient(135deg, #1a1500 0%, #2d2400 100%);
        }

        .service-tile:nth-child(2) .service-tile__bg {
            background-image: linear-gradient(135deg, #001a15 0%, #002d25 100%);
        }

        .service-tile:nth-child(3) .service-tile__bg {
            background-image: linear-gradient(135deg, #1a0000 0%, #2d0000 100%);
        }

        .service-tile:nth-child(4) .service-tile__bg {
            background-image: linear-gradient(135deg, #00001a 0%, #00002d 100%);
        }

        .service-tile:nth-child(5) .service-tile__bg {
            background-image: linear-gradient(135deg, #001015 0%, #001d22 100%);
        }

        .service-tile:nth-child(6) .service-tile__bg {
            background-image: linear-gradient(135deg, #150015 0%, #220022 100%);
        }

        .services-footer {
            display: flex;
            justify-content: flex-end;
            margin-top: 32px;
        }

        /* ==========================================
                                                           PRODUCTS SLIDER
                                                           ========================================== */
        .products-section {
            padding: 120px 0;
            background: #080808;
            overflow: hidden;
        }

        .products-section .section-header {
            padding: 0 40px;
            max-width: 1400px;
            margin: 0 auto 60px;
        }

        .products-viewport {
            overflow: hidden;
            padding: 20px 0;
        }

        .products-rail {
            display: flex;
            gap: 24px;
            transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            padding: 0 40px;
        }

        .product-card {
            min-width: 320px;
            background: #111;
            border: 1px solid rgba(255, 255, 255, 0.06);
            overflow: hidden;
            transition: transform 0.3s ease, border-color 0.3s ease;
            flex-shrink: 0;
        }

        .product-card:hover {
            transform: translateY(-6px);
            border-color: rgba(184, 134, 11, 0.4);
        }

        .product-card__image {
            height: 240px;
            background: #1a1a1a;
            overflow: hidden;
            position: relative;
        }

        .product-card__image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-card:hover .product-card__image img {
            transform: scale(1.05);
        }

        .product-card__body {
            padding: 24px;
        }

        .product-card__name {
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            margin-bottom: 8px;
        }

        .product-card__specs {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.45);
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .product-card__cta {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 600;
            color: var(--color-primary);
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: gap 0.3s ease;
        }

        .product-card__cta:hover {
            gap: 16px;
        }

        .product-card__cta::after {
            content: '→';
        }

        .products-nav {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 0 40px;
            max-width: 1400px;
            margin: 40px auto 0;
        }

        .products-nav__btn {
            width: 48px;
            height: 48px;
            border: 1px solid rgba(184, 134, 11, 0.3);
            background: transparent;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .products-nav__btn:hover {
            background: var(--color-primary);
            border-color: var(--color-primary);
        }

        /* ==========================================
                                                           EQUIPMENT BLOCK
                                                           ========================================== */
        .equipment-section {
            padding: 120px 0;
            background: #000;
        }

        .equipment-inner {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }

        .equipment-text {}

        .equipment-tech-list {
            margin-top: 40px;
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .equipment-tech-item {
            display: flex;
            gap: 20px;
            align-items: flex-start;
            padding: 20px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.07);
        }

        .equipment-tech-item:first-child {
            border-top: 1px solid rgba(255, 255, 255, 0.07);
        }

        .equipment-tech-item__icon {
            width: 40px;
            height: 40px;
            background: rgba(184, 134, 11, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: var(--color-primary);
            font-size: 18px;
        }

        .equipment-tech-item__text h4 {
            font-size: 15px;
            font-weight: 600;
            color: #fff;
            margin-bottom: 4px;
        }

        .equipment-tech-item__text p {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.5);
            line-height: 1.6;
        }

        .equipment-slider {
            position: relative;
            overflow: hidden;
        }

        .eq-slider-track {
            display: flex;
            transition: transform 0.6s ease;
        }

        .eq-slide {
            min-width: 100%;
        }

        .eq-slide__img {
            width: 100%;
            height: 420px;
            background: #111;
            overflow: hidden;
            position: relative;
        }

        .eq-slide__img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .eq-slide__caption {
            padding: 20px 24px;
            background: #111;
            border-bottom: 2px solid var(--color-primary);
        }

        .eq-slide__caption h4 {
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            margin-bottom: 4px;
        }

        .eq-slide__caption p {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.5);
        }

        .eq-slider-nav {
            display: flex;
            gap: 8px;
            margin-top: 16px;
        }

        .eq-nav-btn {
            width: 40px;
            height: 40px;
            border: 1px solid rgba(184, 134, 11, 0.3);
            background: transparent;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .eq-nav-btn:hover {
            background: var(--color-primary);
            border-color: var(--color-primary);
        }

        /* ==========================================
                                                           PORTFOLIO
                                                           ========================================== */
        .portfolio-section {
            padding: 120px 0;
            background: #080808;
        }

        .portfolio-mosaic {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-template-rows: 320px 220px;
            gap: 3px;
            margin-top: 60px;
        }

        .portfolio-item {
            position: relative;
            overflow: hidden;
            cursor: pointer;
            background: #111;
        }

        .portfolio-item:nth-child(1) {
            grid-column: span 2;
            grid-row: span 1;
        }

        .portfolio-item:nth-child(2) {
            grid-column: span 2;
            grid-row: span 1;
        }

        .portfolio-item:nth-child(3) {
            grid-column: span 1;
        }

        .portfolio-item:nth-child(4) {
            grid-column: span 2;
        }

        .portfolio-item:nth-child(5) {
            grid-column: span 1;
        }

        .portfolio-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .portfolio-item__overlay {
            position: absolute;
            inset: 0;
            background: rgba(184, 134, 11, 0);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.4s ease;
        }

        .portfolio-item:hover .portfolio-item__overlay {
            background: rgba(184, 134, 11, 0.55);
        }

        .portfolio-item:hover img {
            transform: scale(1.06);
        }

        .portfolio-item__title {
            font-family: var(--font-family);
            font-size: clamp(20px, 3vw, 36px);
            font-weight: 600;
            color: #fff;
            text-align: center;
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.4s ease;
            padding: 20px;
            text-shadow: 0 2px 20px rgba(0, 0, 0, 0.5);
        }

        .portfolio-item:hover .portfolio-item__title {
            opacity: 1;
            transform: translateY(0);
        }

        .portfolio-footer {
            text-align: center;
            margin-top: 48px;
        }

        /* Portfolio fallback backgrounds */
        .portfolio-item:nth-child(1) {
            background: linear-gradient(135deg, #1a1500, #2d2400);
        }

        .portfolio-item:nth-child(2) {
            background: linear-gradient(135deg, #001a10, #002d18);
        }

        .portfolio-item:nth-child(3) {
            background: linear-gradient(135deg, #1a0010, #2d0018);
        }

        .portfolio-item:nth-child(4) {
            background: linear-gradient(135deg, #00101a, #00182d);
        }

        .portfolio-item:nth-child(5) {
            background: linear-gradient(135deg, #0f0f1a, #18182d);
        }

        /* ==========================================
                                                           BLOG
                                                           ========================================== */
        .blog-section {
            padding: 120px 0;
            background: #000;
        }

        .blog-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 32px;
            margin-top: 60px;
        }

        .blog-card {
            background: #0d0d0d;
            border: 1px solid rgba(255, 255, 255, 0.06);
            overflow: hidden;
            transition: transform 0.3s ease, border-color 0.3s ease;
            cursor: pointer;
        }

        .blog-card:hover {
            transform: translateY(-4px);
            border-color: rgba(184, 134, 11, 0.3);
        }

        .blog-card__cover {
            height: 220px;
            background: #1a1a1a;
            overflow: hidden;
            position: relative;
        }

        .blog-card__cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .blog-card:hover .blog-card__cover img {
            transform: scale(1.05);
        }

        .blog-card__body {
            padding: 28px;
        }

        .blog-card__date {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.35);
            letter-spacing: 2px;
            margin-bottom: 12px;
            display: block;
        }

        .blog-card__title {
            font-size: 17px;
            font-weight: 600;
            color: #fff;
            margin-bottom: 12px;
            line-height: 1.4;
        }

        .blog-card__excerpt {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.5);
            line-height: 1.7;
            margin-bottom: 20px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .blog-card__link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            font-weight: 600;
            color: var(--color-primary);
            letter-spacing: 2px;
            text-transform: uppercase;
            transition: gap 0.3s ease;
        }

        .blog-card__link:hover {
            gap: 16px;
        }

        .blog-card__link::after {
            content: '→';
            transition: transform 0.3s ease;
        }

        /* Blog fallback covers */
        .blog-card:nth-child(1) .blog-card__cover {
            background: linear-gradient(135deg, #1a1000, #2d1a00);
        }

        .blog-card:nth-child(2) .blog-card__cover {
            background: linear-gradient(135deg, #001510, #00241a);
        }

        .blog-card:nth-child(3) .blog-card__cover {
            background: linear-gradient(135deg, #100015, #1a0022);
        }

        /* ==========================================
                                                           FAQ BLOCK
                                                           ========================================== */
        .faq-section {
            padding: 120px 0;
            background: #080808;
        }

        .faq-inner {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 80px;
            align-items: start;
        }

        .faq-side__text {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.5);
            line-height: 1.8;
            margin-top: 24px;
        }

        .faq-list {
            display: flex;
            flex-direction: column;
        }

        .faq-item {
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .faq-item:first-child {
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .faq-question {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 24px 0;
            cursor: pointer;
            background: none;
            border: none;
            color: #fff;
            width: 100%;
            text-align: left;
            font-family: var(--font-family);
        }

        .faq-question__text {
            font-size: 16px;
            font-weight: 500;
            line-height: 1.4;
            transition: color 0.3s ease;
        }

        .faq-item.active .faq-question__text,
        .faq-question:hover .faq-question__text {
            color: var(--color-primary);
        }

        .faq-question__icon {
            width: 28px;
            height: 28px;
            border: 1px solid rgba(184, 134, 11, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: all 0.3s ease;
            color: var(--color-primary);
        }

        .faq-item.active .faq-question__icon {
            background: var(--color-primary);
            color: #000;
            transform: rotate(45deg);
        }

        .faq-answer {
            overflow: hidden;
            max-height: 0;
            transition: max-height 0.4s ease, padding 0.4s ease;
        }

        .faq-item.active .faq-answer {
            max-height: 400px;
        }

        .faq-answer__inner {
            padding-bottom: 24px;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.6);
            line-height: 1.8;
        }

        /* ==========================================
                                                           LEAD FORM
                                                           ========================================== */
        .lead-section {
            padding: 120px 0;
            background: #000;
            position: relative;
            overflow: hidden;
        }

        .lead-section::before {
            content: '';
            position: absolute;
            top: -200px;
            right: -200px;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(184, 134, 11, 0.07) 0%, transparent 70%);
            pointer-events: none;
        }

        .lead-inner {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 80px;
            align-items: center;
        }

        .lead-text__badge {
            display: inline-block;
            border: 1px solid rgba(184, 134, 11, 0.4);
            color: var(--color-primary);
            font-size: 11px;
            letter-spacing: 3px;
            text-transform: uppercase;
            padding: 8px 16px;
            margin-bottom: 24px;
        }

        .lead-text h2 {
            font-family: var(--font-family);
            font-size: clamp(36px, 4vw, 60px);
            font-weight: 400;
            color: #fff;
            line-height: 1.15;
            margin-bottom: 24px;
        }

        .lead-text h2 em {
            font-style: italic;
            color: var(--color-primary);
        }

        .lead-text p {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.55);
            line-height: 1.8;
        }

        .lead-advantages {
            margin-top: 32px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .lead-advantage {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.6);
        }

        .lead-advantage::before {
            content: '';
            width: 6px;
            height: 6px;
            background: var(--color-primary);
            flex-shrink: 0;
        }

        .lead-form-wrap {
            background: #0d0d0d;
            border: 1px solid rgba(184, 134, 11, 0.15);
            padding: 48px;
        }

        .lead-form .form-group {
            margin-bottom: 16px;
        }

        .lead-form label {
            display: block;
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.4);
            margin-bottom: 8px;
        }

        .lead-form input,
        .lead-form textarea {
            width: 100%;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            font-family: var(--font-family);
            font-size: 14px;
            padding: 14px 18px;
            outline: none;
            transition: border-color 0.3s ease;
            -webkit-appearance: none;
        }

        .lead-form input:focus,
        .lead-form textarea:focus {
            border-color: rgba(184, 134, 11, 0.5);
        }

        .lead-form input::placeholder,
        .lead-form textarea::placeholder {
            color: rgba(255, 255, 255, 0.2);
        }

        .lead-form textarea {
            resize: vertical;
            min-height: 100px;
        }

        .lead-form .file-upload {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px dashed rgba(255, 255, 255, 0.15);
            cursor: pointer;
            transition: border-color 0.3s ease;
        }

        .lead-form .file-upload:hover {
            border-color: rgba(184, 134, 11, 0.4);
        }

        .lead-form .file-upload span {
            font-size: 13px;
            color: rgba(255, 255, 255, 0.35);
        }

        .lead-form .file-upload svg {
            color: rgba(184, 134, 11, 0.6);
            flex-shrink: 0;
        }

        .lead-form .checkbox-row {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin: 20px 0;
        }

        .lead-form .checkbox-row input[type="checkbox"] {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            accent-color: var(--color-primary);
            margin-top: 2px;
        }

        .lead-form .checkbox-row label {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.35);
            letter-spacing: 0;
            text-transform: none;
            margin: 0;
        }

        .lead-form .checkbox-row a {
            color: var(--color-primary);
        }

        .lead-form .btn-submit {
            width: 100%;
            padding: 18px;
            background: var(--color-primary);
            color: #000;
            font-family: var(--font-family);
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .lead-form .btn-submit:hover {
            background: var(--color-accent-soft);
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(184, 134, 11, 0.3);
        }

        /* ==========================================
                                                           BUTTONS
                                                           ========================================== */
        .btn-gold {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 32px;
            background: var(--color-primary);
            color: #000;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            font-family: var(--font-family);
        }

        .btn-gold:hover {
            background: var(--color-accent-soft);
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(184, 134, 11, 0.3);
        }

        .btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 32px;
            background: transparent;
            color: var(--color-primary);
            border: 1px solid rgba(184, 134, 11, 0.5);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-ghost:hover {
            background: rgba(184, 134, 11, 0.1);
            border-color: var(--color-primary);
        }

        /* ==========================================
                                                           RESPONSIVE
                                                           ========================================== */
        @media (max-width: 1100px) {
            .services-grid {
                grid-template-columns: repeat(2, 1fr);
                grid-template-rows: repeat(3, 260px);
            }

            .portfolio-mosaic {
                grid-template-columns: repeat(2, 1fr);
                grid-template-rows: 280px 280px 220px;
            }

            .portfolio-item:nth-child(1) {
                grid-column: 1;
            }

            .portfolio-item:nth-child(2) {
                grid-column: 2;
            }

            .portfolio-item:nth-child(3) {
                grid-column: 1;
            }

            .portfolio-item:nth-child(4) {
                grid-column: 2;
            }

            .portfolio-item:nth-child(5) {
                grid-column: span 2;
            }

            .equipment-inner {
                grid-template-columns: 1fr;
                gap: 60px;
            }

            .faq-inner {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .lead-inner {
                grid-template-columns: 1fr;
                gap: 60px;
            }
        }

        @media (max-width: 768px) {
            .services-grid {
                grid-template-columns: 1fr;
                grid-template-rows: auto;
            }

            .service-tile {
                height: 200px;
            }

            .blog-grid {
                grid-template-columns: 1fr;
            }

            .portfolio-mosaic {
                grid-template-columns: 1fr;
                grid-template-rows: auto;
            }

            .portfolio-item {
                height: 220px;
            }

            .portfolio-item:nth-child(1),
            .portfolio-item:nth-child(2),
            .portfolio-item:nth-child(3),
            .portfolio-item:nth-child(4),
            .portfolio-item:nth-child(5) {
                grid-column: 1;
            }

            .imago-slide__num {
                font-size: 70px;
            }

            .imago-slide__stat {
                font-size: 48px;
            }

            .imago-controls {
                padding: 24px 20px;
            }

            .imago-slide__content {
                padding: 0 24px;
            }

            .lead-form-wrap {
                padding: 28px 20px;
            }

            .zero-phrase {
                left: 5vw;
            }

            .zero-phrase__title {
                font-size: 36px;
            }
        }

        /* ==========================================
                                                           HEADER OVERRIDES
                                                           ========================================== */
        .header .btn {
            background: var(--color-primary);
            color: #000;
        }

        .header .btn:hover {
            background: var(--color-accent-soft);
        }
    </style>
@endpush
@section('content')
    <!-- Hero Bridge Sections -->
    @include('components.blocks.hero.bridge-wrapper')

    <!-- ===== IMAGO CAROUSEL ===== -->
    {{-- <section class="imago-section" id="imagoSection">
        <div class="imago-track" id="imagoTrack">

            @foreach ($advantages as $index => $item)
                <div class="imago-slide @if ($index === 0) active @endif">
                    <div
                        class="imago-slide__bg"
                        style="
                        background-image: url('{{ $item->preview->url }}');
                        background-color: {{ $item->bg_color ?? '#1a1a2e' }};
                    ">
                    </div>

                    <div class="imago-slide__overlay"></div>

                    <div class="imago-slide__content">
                        <div class="imago-slide__num">
                            {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                        </div>

                        <div class="imago-slide__stat">
                            {!! $item->title !!}
                            @if (!empty($item->subtitle))
                                <span>{!! $item->subtitle !!}</span>
                            @endif
                        </div>

                        <p class="imago-slide__desc">
                            {{ $item->description }}
                        </p>
                    </div>
                </div>
            @endforeach

        </div>

        <div class="imago-controls">
            <div class="imago-dots" id="imagoDots">
                @foreach ($advantages as $index => $item)
                    <button
                        class="imago-dot @if ($index === 0) active @endif"
                        onclick="goImago({{ $index }})">
                    </button>
                @endforeach
            </div>

            <div class="imago-arrows">
                <button class="imago-arrow" onclick="moveImago(-1)" aria-label="Назад">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M12 4L6 10L12 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </button>

                <button class="imago-arrow" onclick="moveImago(1)" aria-label="Вперёд">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M8 4L14 10L8 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
        </div>
    </section> --}}

    <!-- ===== SERVICES ===== -->
    <section class="services-section" id="services">
        <div class="container">
            <x-sections.header
                label="Что мы делаем"
                title="Популярнуе услуги" />

            <div class="services-grid">
                @foreach ($services as $service)
                    <div class="service-tile">
                        <div
                            class="service-tile__bg"
                            style="background-image:url('{{ $service->preview->url }}');">
                        </div>

                        <div class="service-tile__border"></div>

                        <div class="service-tile__content">
                            <div class="service-tile__icon">
                                {{ $service->icon ?? '✦' }}
                            </div>

                            <div class="service-tile__name">
                                {{ $service->title }}
                            </div>

                            <div class="service-tile__hint">
                                {{ $service->excerpt }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="services-footer">
                <a href="{{ route('services.index') }}" class="btn-ghost">
                    Все услуги →
                </a>
            </div>
        </div>
    </section>

    <!-- ===== PRODUCTS ===== -->
    <section class="products-section" id="products">
        <div class="container">
            <x-sections.header
                label="Наш ассортимент"
                title="Продукция" />
        </div>

        <div class="products-viewport">
            <div class="products-rail" id="productsRail">

                @foreach ($products as $product)
                    <div class="product-card">
                        <div class="product-card__image">
                            <img
                                src="{{ $product->preview->url }}"
                                alt="{{ $product->title }}">
                        </div>

                        <div class="product-card__body">
                            <div class="product-card__name">
                                {{ $product->title }}
                            </div>

                            <div class="product-card__specs">
                                {!! nl2br(e($product->specs)) !!}
                            </div>

                            <a href="{{ route('catalog.index') }}" class="product-card__cta">
                                В каталог
                            </a>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>

        <div class="products-nav">
            <button class="products-nav__btn" onclick="moveProducts(-1)" aria-label="Назад">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                    <path d="M11 3L5 9L11 15"
                        stroke="currentColor"
                        stroke-width="1.5"
                        stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </button>

            <button class="products-nav__btn" onclick="moveProducts(1)" aria-label="Вперёд">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                    <path d="M7 3L13 9L7 15"
                        stroke="currentColor"
                        stroke-width="1.5"
                        stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </button>
        </div>
    </section>

    <!-- ===== EQUIPMENT ===== -->
    <section class="equipment-section" id="equipment">
        <div class="container">
            <x-sections.header
                label="Технологии"
                title="Мы работаем на современном оборудовании"
                subtitle=" Собственный цех 800 м² позволяет выполнять весь производственный цикл без привлечения субподрядчиков — от материала до готовой вывески. " />

            <div class="equipment-inner">

                <div class="equipment-tech-list">
                    @foreach ($equipment as $item)
                        <div class="equipment-tech-item">
                            <div class="equipment-tech-item__text">
                                <h4>{{ $item->title }}</h4>
                                <p>{{ $item->excerpt }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>


                {{-- SLIDER --}}
                <div class="equipment-slider">
                    <div class="eq-slider-track" id="eqTrack">

                        @foreach ($equipment as $item)
                            <div class="eq-slide">
                                <div class="eq-slide__img">
                                    <img
                                        src="{{ $item->preview->url }}"
                                        alt="{{ $item->title }}"
                                        onerror="this.parentElement.style.background='linear-gradient(135deg,#111,#222)'">
                                </div>

                                <div class="eq-slide__caption">
                                    <h4>{{ $item->title }}</h4>
                                    <p>{{ $item->description }}</p>
                                </div>
                            </div>
                        @endforeach

                    </div>

                    <div class="eq-slider-nav">
                        <button class="eq-nav-btn" onclick="moveEq(-1)" aria-label="Назад">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M10 3L5 8L10 13"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </button>

                        <button class="eq-nav-btn" onclick="moveEq(1)" aria-label="Вперёд">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M6 3L11 8L6 13"
                                    stroke="currentColor"
                                    stroke-width="1.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ===== PORTFOLIO ===== -->
    <section class="portfolio-section" id="portfolio">
        <div class="container">
            <x-sections.header
                label="Портфолио"
                title="Примеры выполненных работ" />
        </div>

        <div style="max-width:1600px;margin:0 auto;padding:0 20px;">
            <div class="portfolio-mosaic">

                @foreach ($portfolio as $item)
                    <a href="{{ route('portfolio.index') }}" class="portfolio-item">
                        <img
                            src="{{ $item->preview->url }}"
                            alt="{{ $item->title }}"
                            onerror="this.style.display='none'">

                        <div class="portfolio-item__overlay">
                            <div class="portfolio-item__title">
                                {!! nl2br(e($item->title)) !!}
                            </div>
                        </div>
                    </a>
                @endforeach

            </div>
        </div>

        <div class="portfolio-footer">
            <a href="{{ route('portfolio.index') }}" class="btn-ghost">
                Смотреть все проекты →
            </a>
        </div>
    </section>

    <!-- ===== BLOG ===== -->
    <section class="blog-section" id="blog">
        <div class="container">
            <div style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:20px;">
                <div>
                    <span class="section-header__label">Наши мысли</span>
                    <h2 class="section-header__title">Блог</h2>
                </div>
                <a href="{{ route('blog.index') }}" class="btn-ghost" style="flex-shrink:0;">
                    Все статьи →
                </a>
            </div>

            <div class="blog-grid">
                @foreach ($articles as $article)
                    <a href="{{ route('blog.show', $article->slug) }}" class="blog-card">
                        <div class="blog-card__cover">
                            <img
                                src="{{ $article->preview->url }}"
                                alt="{{ $article->title }}"
                                onerror="this.style.display='none'">
                        </div>

                        <div class="blog-card__body">
                            <span class="blog-card__date">
                                {{ $article->published_at?->translatedFormat('d F Y') }}
                            </span>

                            <div class="blog-card__title">
                                {{ $article->title }}
                            </div>

                            <div class="blog-card__excerpt">
                                {{ $article->excerpt }}
                            </div>

                            <span class="blog-card__link">
                                Читать статью
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ===== FAQ ===== -->
    <section class="faq-section" id="faq">
        <div class="container">
            <div class="faq-inner">

                <div class="faq-side">
                    <span class="section-header__label">Вопросы и ответы</span>
                    <h2 class="section-header__title">FAQ</h2>

                    <p class="faq-side__text">
                        Самые частые вопросы от клиентов — собрали здесь,
                        чтобы вы могли быстро найти нужную информацию.
                    </p>

                    <div style="margin-top:40px;">
                        <a href="{{ route('contacts') }}" class="btn-gold">
                            Задать вопрос
                        </a>
                    </div>
                </div>

                <div class="faq-list">
                    @foreach ($faqs as $index => $faq)
                        <div class="faq-item" id="faq-{{ $index }}">
                            <button
                                class="faq-question"
                                onclick="toggleFaqItem({{ $index }})">

                                <span class="faq-question__text">
                                    {{ $faq->title }}
                                </span>

                                <div class="faq-question__icon">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                                        <path d="M7 2v10M2 7h10"
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                            stroke-linecap="round" />
                                    </svg>
                                </div>
                            </button>

                            <div class="faq-answer">
                                <div class="faq-answer__inner">
                                    {!! nl2br(e($faq->excerpt)) !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </section>

    <!-- ===== LEAD FORM ===== -->
    <section class="lead-section" id="lead">
        <div class="container">
            <div class="lead-inner">
                <div class="lead-text">
                    <div class="lead-text__badge">Бесплатный расчёт</div>
                    <h2>Рассчитайте стоимость<br>вашего проекта<br><em>прямо сейчас</em></h2>
                    <p>Оставьте заявку — наш менеджер свяжется с вами в течение 15 минут и поможет с расчётом, даже если у
                        вас пока только идея.</p>
                    <div class="lead-advantages">
                        <div class="lead-advantage">Бесплатная консультация и замер</div>
                        <div class="lead-advantage">Коммерческое предложение за 24 часа</div>
                        <div class="lead-advantage">Без предоплаты до согласования проекта</div>
                        <div class="lead-advantage">Собственное производство, без посредников</div>
                    </div>
                </div>

                <div class="lead-form-wrap">
                    <form class="lead-form" onsubmit="submitLeadForm(event)">
                        <div class="form-group">
                            <label for="lead-name">Ваше имя</label>
                            <input type="text" id="lead-name" placeholder="Иван Иванов" required>
                        </div>
                        <div class="form-group">
                            <label for="lead-phone">Телефон</label>
                            <input type="tel" id="lead-phone" placeholder="+7 (___) ___-__-__" required>
                        </div>
                        <div class="form-group">
                            <label for="lead-comment">Комментарий к проекту</label>
                            <textarea id="lead-comment" placeholder="Опишите вашу задачу или объект..."></textarea>
                        </div>
                        <div class="form-group">
                            <label>Прикрепить эскиз или файл (необязательно)</label>
                            <label class="file-upload" for="lead-file">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M10 13V7M10 7L7 10M10 7L13 10" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <rect x="3" y="3" width="14" height="14" rx="2" stroke="currentColor"
                                        stroke-width="1.5" />
                                </svg>
                                <span>Перетащите файл или нажмите для выбора</span>
                                <input type="file" id="lead-file" style="display:none;"
                                    accept=".jpg,.jpeg,.png,.pdf,.ai,.cdr,.dxf">
                            </label>
                        </div>
                        <div class="checkbox-row">
                            <input type="checkbox" id="lead-agree" required>
                            <label for="lead-agree">Согласен(на) на обработку <a href="privacy.html">персональных
                                    данных</a></label>
                        </div>
                        <button type="submit" class="btn-submit">Получить расчёт</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script>
        // ==========================================
        // IMAGO CAROUSEL
        // ==========================================
        (function() {
            let currentImago = 0;
            const track = document.getElementById('imagoTrack');
            const slides = track ? track.querySelectorAll('.imago-slide') : [];
            const dots = document.querySelectorAll('.imago-dot');
            let imagoInterval;

            window.goImago = function(index) {
                slides[currentImago].classList.remove('active');
                currentImago = index;
                slides[currentImago].classList.add('active');
                track.style.transform = `translateX(-${currentImago * 100}%)`;
                dots.forEach((d, i) => d.classList.toggle('active', i === currentImago));
            };

            window.moveImago = function(dir) {
                let next = currentImago + dir;
                if (next < 0) next = slides.length - 1;
                if (next >= slides.length) next = 0;
                goImago(next);
            };

            function startImagoAuto() {
                imagoInterval = setInterval(() => window.moveImago(1), 5000);
            }

            function stopImagoAuto() {
                clearInterval(imagoInterval);
            }

            if (track) {
                track.parentElement.addEventListener('mouseenter', stopImagoAuto);
                track.parentElement.addEventListener('mouseleave', startImagoAuto);
                startImagoAuto();
            }
        })();

        // ==========================================
        // PRODUCTS SLIDER
        // ==========================================
        (function() {
            let currentProduct = 0;
            const rail = document.getElementById('productsRail');

            function getCardWidth() {
                const card = rail ? rail.querySelector('.product-card') : null;
                return card ? card.offsetWidth + 24 : 344;
            }

            window.moveProducts = function(dir) {
                if (!rail) return;
                const cards = rail.querySelectorAll('.product-card');
                const visibleCount = window.innerWidth > 1100 ? 3 : window.innerWidth > 768 ? 2 : 1;
                const max = cards.length - visibleCount;
                currentProduct = Math.min(Math.max(currentProduct + dir, 0), max);
                rail.style.transform = `translateX(-${currentProduct * getCardWidth()}px)`;
            };
        })();

        // ==========================================
        // EQUIPMENT SLIDER
        // ==========================================
        (function() {
            let currentEq = 0;
            const track = document.getElementById('eqTrack');

            window.moveEq = function(dir) {
                if (!track) return;
                const slides = track.querySelectorAll('.eq-slide');
                currentEq = (currentEq + dir + slides.length) % slides.length;
                track.style.transform = `translateX(-${currentEq * 100}%)`;
            };
        })();

        // ==========================================
        // FAQ
        // ==========================================
        window.toggleFaqItem = function(index) {
            const item = document.getElementById('faq-' + index);
            const isActive = item.classList.contains('active');
            document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('active'));
            if (!isActive) item.classList.add('active');
        };

        // ==========================================
        // LEAD FORM
        // ==========================================
        window.submitLeadForm = function(e) {
            e.preventDefault();
            alert('Спасибо! Мы свяжемся с вами в ближайшее время и рассчитаем стоимость вашего проекта.');
            e.target.reset();
        };

        // File upload label update
        const fileInput = document.getElementById('lead-file');
        if (fileInput) {
            fileInput.addEventListener('change', function() {
                const label = this.parentElement.querySelector('span');
                if (this.files.length > 0) {
                    label.textContent = this.files[0].name;
                }
            });
        }
    </script>
@endsection
