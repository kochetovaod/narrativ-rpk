{{-- resources/views/components/map/iframe.blade.php --}}

@props([
    'latitude' => null,
    'longitude' => null,
    'address' => null,
    'width' => '100%',
    'height' => '400px',
    'zoom' => 17,
    'placemarkTitle' => null,
    'class' => null,
])

@php
    // Берем координаты из пропсов или из настроек
    $lat = $latitude ?? setting('map_latitude', 55.7558);
    $lng = $longitude ?? setting('map_longitude', 37.6176);
    $zoomLevel = $zoom ?? setting('map_zoom', 17);
    $addressText = $address ?? setting('contact_address', 'Москва');

    // Формируем URL для iframe Яндекс.Карт без результатов поиска
    // Используем параметр mode=search? нет, лучше mode=map
    $mapSrc = 'https://yandex.ru/map-widget/v1/?';
    $mapSrc .= "ll={$lng},{$lat}";
    $mapSrc .= "&pt={$lng},{$lat},pm2rdm"; // pm2rdm - красная метка
    $mapSrc .= "&z={$zoomLevel}";
    $mapSrc .= '&mode=map'; // Режим карты без поиска
    $mapSrc .= '&saturation=-100'; // Ч/Б (от -100 до 100, -100 = полная десатурация)
    $mapSrc .= '&contrast=50'; // Контраст для лучшей читаемости в ч/б

    // Убираем текст из метки, чтобы не искало
    // $mapSrc .= "&text=" . urlencode($placemarkTitle);

    // Альтернативная ссылка для открытия в полной версии
    $fullMapLink = "https://yandex.ru/maps/?ll={$lng},{$lat}&z={$zoomLevel}&pt={$lng},{$lat},pm2rdm&mode=map&saturation=-100&contrast=50";
@endphp


<div class="yandex-map-container {{ $class }}" {{ $attributes }}>
    <iframe
        src="{{ $mapSrc }}"
        width="100%"
        height="100%"
        frameborder="0"
        allowfullscreen
        style="border: 0; display: block; position: absolute; top: 0; left: 0; filter: grayscale(1);"
        {{-- Дополнительный CSS-фильтр для ч/б --}}
        title="Карта {{ $addressText }}"
        loading="lazy"></iframe>
</div>



<script>
    // Отслеживаем загрузку iframe для плавного появления
    document.addEventListener('DOMContentLoaded', function() {
        const iframes = document.querySelectorAll('.yandex-map-iframe iframe[loading="lazy"]');
        iframes.forEach(iframe => {
            if (iframe.complete) {
                iframe.classList.add('loaded');
            } else {
                iframe.addEventListener('load', function() {
                    this.classList.add('loaded');
                });
            }
        });
    });
</script>
