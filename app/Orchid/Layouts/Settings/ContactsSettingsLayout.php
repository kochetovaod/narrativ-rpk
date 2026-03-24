<?php

namespace App\Orchid\Layouts\Settings;

class ContactsSettingsLayout extends AbstractSettingsLayout
{
    protected function settingFields(): array
    {
        return [
            'contact_phone' => 'string',
            'contact_phone_2' => 'string',
            'contact_email' => 'string',
            'contact_address' => 'text',
            'map_latitude' => 'string',
            'map_longitude' => 'string',
            'map_zoom' => 'integer',
            'map_placemark_title' => 'string',
            'map_placemark_body' => 'text',
            'map_api_key_yandex' => 'string',
            'map_api_key_google' => 'string',
            'working_hours' => 'string',
        ];
    }

    protected function label(string $key): string
    {
        $labels = [
            'contact_phone' => 'Основной телефон',
            'contact_phone_2' => 'Дополнительный телефон',
            'contact_email' => 'Email для связи',
            'contact_address' => 'Адрес офиса/производства',
            'map_latitude' => 'Широта для карты',
            'map_longitude' => 'Долгота для карты',
            'map_zoom' => 'Уровень приближения карты',
            'map_placemark_title' => 'Название метки на карте',
            'map_placemark_body' => 'Описание в метке карты',
            'map_api_key_yandex' => 'API ключ для Яндекс.Карт',
            'map_api_key_google' => 'API ключ для Google Maps',
            'working_hours' => 'Режим работы (текстом)',
        ];

        return $labels[$key] ?? parent::label($key);
    }

    protected function options(string $key): array
    {
        return match ($key) {
            'map_zoom' => array_combine(range(1, 20), range(1, 20)),
            default => [],
        };
    }
}
