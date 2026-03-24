<?php

namespace App\Orchid\Layouts\Settings;

class GeneralSettingsLayout extends AbstractSettingsLayout
{
    protected function settingFields(): array
    {
        return [
            'site_name' => 'string',
            'site_description' => 'text',
            'site_logo' => 'image',
            'site_logo_dark' => 'image',
            'site_logo_mobile' => 'image',
            'site_favicon' => 'image',
            'site_favicon_apple' => 'image',
            'maintenance_mode' => 'boolean',
            'maintenance_message' => 'text',
        ];
    }

    protected function label(string $key): string
    {
        $labels = [
            'site_name' => 'Название сайта',
            'site_description' => 'Описание сайта',
            'site_logo' => 'Логотип (основной)',
            'site_logo_dark' => 'Логотип для темного фона',
            'site_logo_mobile' => 'Логотип для мобильной версии',
            'site_favicon' => 'Favicon',
            'site_favicon_apple' => 'Apple Touch Icon',
            'maintenance_mode' => 'Режим обслуживания',
            'maintenance_message' => 'Сообщение в режиме обслуживания',
        ];

        return $labels[$key] ?? parent::label($key);
    }

    protected function options(string $key): array
    {
        return match ($key) {
            default => [],
        };
    }
}
