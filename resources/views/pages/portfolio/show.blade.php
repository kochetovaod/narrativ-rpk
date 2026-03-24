@extends('layouts.app')

@section('title', $project->title . ' — Портфолио — Нарратив')

@section('content')
    <x-sections.hero
        :current="$project->title"
        :breadcrumbItems="[
            [
                'url' => route('portfolio.index'),
                'title' => 'Портфолио',
            ],
        ]"
        itemtype="PortfolioPage"
        :image="$project->preview->url"
        :label="trim(
            $project->city .
                ' ' .
                ($project->completed_at ? \Carbon\Carbon::parse($project->completed_at)->format('Y') : ''),
        )"
        :title="$project->title"
        :subtitle="$project->excerpt" />

    <!-- Main content -->
    <section class="section section--dark">
        <div class="container">
            <div class="project-layout">
                <!-- Основной контент -->
                <article class="project-body">
                    {!! $project->content !!}
                    <!-- Галерея изображений -->
                    @if ($project->attachments && $project->attachments->count() > 0)
                        <div class="project-gallery">
                            <h3 class="project-gallery__title">Фотогалерея проекта</h3>
                            <div class="project-gallery__grid">
                                @foreach ($project->attachments as $index => $attachment)
                                    <div class="project-gallery__item" onclick="zoomImg(this)">
                                        <img src="{{ $attachment->url }}"
                                            alt="{{ $project->title }} - фото {{ $index + 1 }}"
                                            loading="lazy"
                                            onerror="this.parentElement.style.background='#1a1a1a'">
                                        @if ($attachment->description)
                                            <div class="project-gallery__caption">{{ $attachment->description }}</div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Услуги и продукция проекта -->
                    @if ($project->services->isNotEmpty())
                        <div class="project-services">
                            <div class="project-tags">
                                @foreach ($project->services as $service)
                                    <span class="project-tag">{{ $service->title }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if ($project->products->isNotEmpty())
                        <div class="project-products">
                            <div class="project-tags">
                                @foreach ($project->products as $product)
                                    <span class="project-tag">{{ $product->title }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </article>
                <!-- Sidebar с деталями проекта -->
                <aside class="project-sidebar">
                    <div class="project-sidebar__card">
                        <div class="project-sidebar__title">Детали проекта</div>

                        @if ($project->client)
                            <div class="project-spec">
                                <span class="project-spec__key">Клиент</span>
                                <span class="project-spec__val">{{ $project->client->title }}</span>
                            </div>
                        @endif

                        @if ($project->city)
                            <div class="project-spec">
                                <span class="project-spec__key">Город</span>
                                <span class="project-spec__val">{{ $project->city }}</span>
                            </div>
                        @endif

                        @if ($project->completed_at)
                            <div class="project-spec">
                                <span class="project-spec__key">Год</span>
                                <span
                                    class="project-spec__val">{{ \Carbon\Carbon::parse($project->completed_at)->format('Y') }}</span>
                            </div>
                        @endif

                        @if ($project->address)
                            <div class="project-spec">
                                <span class="project-spec__key">Адрес</span>
                                <span class="project-spec__val">{{ $project->address }}</span>
                            </div>
                        @endif

                        @if ($project->budget)
                            <div class="project-spec">
                                <span class="project-spec__key">Бюджет</span>
                                <span class="project-spec__val">{{ number_format($project->budget, 0, ',', ' ') }} ₽</span>
                            </div>
                        @endif

                        <!-- Вывод характеристик из JSON поля properties -->
                        @if ($project->properties)
                            @php
                                $properties = is_string($project->properties)
                                    ? json_decode($project->properties, true)
                                    : $project->properties;
                            @endphp

                            @if (is_array($properties))
                                @foreach ($properties as $key => $value)
                                    @if (!empty($value))
                                        <div class="project-spec">
                                            <span class="project-spec__key">{{ $key }}</span>
                                            <span class="project-spec__val">{{ $value }}</span>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        @endif
                    </div>

                    <!-- Похожие проекты -->
                    @if (isset($relatedProjects) && $relatedProjects->count() > 0)
                        <div class="project-sidebar__card">
                            <div class="project-sidebar__title">Похожие проекты</div>

                            @foreach ($relatedProjects as $related)
                                <a href="{{ route('portfolio.show', $related->slug) }}" class="related-project">
                                    <img src="{{ $related->preview->url ?? asset('images/placeholder.jpg') }}"
                                        alt="{{ $related->title }}"
                                        loading="lazy"
                                        onerror="this.parentElement.style.background='#111'">
                                    <div class="related-project__overlay">
                                        @if ($related->services->isNotEmpty())
                                            <div class="related-project__cat">{{ $related->services->first()->title }}
                                            </div>
                                        @endif
                                        <div class="related-project__title">{{ $related->title }}</div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </aside>
            </div>
        </div>
    </section>

    <!-- Modal для увеличения изображений -->
    <div class="zoom-modal" id="zoomModal" onclick="closeZoom()">
        <button class="zoom-modal__close" onclick="closeZoom(event)">×</button>
        <img id="zoomImg" src="" alt="">
        <button class="zoom-modal__prev" onclick="prevImage(event)">‹</button>
        <button class="zoom-modal__next" onclick="nextImage(event)">›</button>
        <div class="zoom-modal__counter" id="zoomCounter"></div>
    </div>

    @push('scripts')
        <script>
            // Данные для галереи
            let galleryImages = [];
            let currentImageIndex = 0;

            @if ($project->attachments && $project->attachments->count() > 0)
                galleryImages = [
                    @foreach ($project->attachments as $attachment)
                        {
                            url: '{{ $attachment->url }}',
                            description: '{{ $attachment->description ?? '' }}'
                        },
                    @endforeach
                ];
            @endif

            function zoomImg(element) {
                const img = element.querySelector('img');
                if (!img) return;

                // Находим индекс изображения в галерее
                const imgSrc = img.src;
                currentImageIndex = galleryImages.findIndex(item => item.url === imgSrc);

                if (currentImageIndex === -1) {
                    // Если изображение не в массиве галереи, добавляем его
                    galleryImages = [{
                        url: imgSrc,
                        description: img.alt || ''
                    }];
                    currentImageIndex = 0;
                }

                updateZoomImage();
                document.getElementById('zoomModal').classList.add('open');
                document.body.style.overflow = 'hidden';
            }

            function updateZoomImage() {
                const img = document.getElementById('zoomImg');
                const counter = document.getElementById('zoomCounter');

                if (galleryImages.length > 0) {
                    img.src = galleryImages[currentImageIndex].url;
                    if (counter) {
                        counter.textContent = (currentImageIndex + 1) + ' / ' + galleryImages.length;
                    }
                }
            }

            function prevImage(event) {
                if (event) event.stopPropagation();
                if (galleryImages.length > 1) {
                    currentImageIndex = (currentImageIndex - 1 + galleryImages.length) % galleryImages.length;
                    updateZoomImage();
                }
            }

            function nextImage(event) {
                if (event) event.stopPropagation();
                if (galleryImages.length > 1) {
                    currentImageIndex = (currentImageIndex + 1) % galleryImages.length;
                    updateZoomImage();
                }
            }

            function closeZoom(event) {
                if (event) event.stopPropagation();
                document.getElementById('zoomModal').classList.remove('open');
                document.body.style.overflow = '';
            }

            // Клавиатурная навигация
            document.addEventListener('keydown', function(e) {
                if (!document.getElementById('zoomModal').classList.contains('open')) return;

                if (e.key === 'Escape') {
                    closeZoom();
                } else if (e.key === 'ArrowLeft') {
                    prevImage();
                } else if (e.key === 'ArrowRight') {
                    nextImage();
                }
            });
        </script>
    @endpush
@endsection
