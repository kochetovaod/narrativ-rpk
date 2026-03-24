<?php

namespace App\Orchid\Layouts\Settings;

class DesignSettingsLayout extends AbstractSettingsLayout
{
    protected function settingFields(): array
    {
        return [
            'theme_primary_color' => 'color',
            'theme_secondary_color' => 'color',
            'theme_font_family' => 'select',
            'custom_css' => 'text',
        ];
    }

    protected function label(string $key): string
    {
        $labels = [
            'theme_primary_color' => 'Основной цвет',
            'theme_secondary_color' => 'Вторичный цвет',
            'theme_font_family' => 'Основной шрифт',
            'custom_css' => 'Пользовательский CSS',
        ];

        return $labels[$key] ?? parent::label($key);
    }

    protected function options(string $key): array
    {
        return match ($key) {
            'theme_font_family' => [
                'Inter, sans-serif' => 'Inter',
                'Roboto, sans-serif' => 'Roboto',
                'Open Sans, sans-serif' => 'Open Sans',
                'Montserrat, sans-serif' => 'Montserrat',
                'Arial, sans-serif' => 'Arial',
                'Helvetica, sans-serif' => 'Helvetica',
                'Times New Roman, serif' => 'Times New Roman',
            ],
            default => [],
        };
    }
}
