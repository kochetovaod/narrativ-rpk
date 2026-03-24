<?php

namespace App\Orchid\Layouts\Settings;

class SeoSettingsLayout extends AbstractSettingsLayout
{
    protected function settingFields(): array
    {
        return [
            'seo_default_title' => 'string',
            'seo_default_description' => 'text',
            'seo_default_keywords' => 'text',
            'seo_og_image' => 'image',
            'seo_robots_txt' => 'text',
            'seo_yandex_verification' => 'string',
            'seo_google_verification' => 'string',
            'seo_metrika_counter' => 'text',
            'seo_analytics_counter' => 'text',
            'seo_meta_tags' => 'text',
            'seo_scripts_body_start' => 'text',
            'seo_scripts_body_end' => 'text',
        ];
    }

    protected function label(string $key): string
    {
        $labels = [
            'seo_default_title' => 'SEO заголовок по умолчанию',
            'seo_default_description' => 'SEO описание по умолчанию',
            'seo_default_keywords' => 'SEO ключевые слова',
            'seo_og_image' => 'Изображение для Open Graph',
            'seo_robots_txt' => 'Содержимое robots.txt',
            'seo_yandex_verification' => 'Код верификации Яндекс',
            'seo_google_verification' => 'Код верификации Google',
            'seo_metrika_counter' => 'Код счетчика Яндекс.Метрики',
            'seo_analytics_counter' => 'Код счетчика Google Analytics',
            'seo_meta_tags' => 'Дополнительные meta-теги',
            'seo_scripts_body_start' => 'Скрипты после открытия body',
            'seo_scripts_body_end' => 'Скрипты перед закрытием body',
        ];

        return $labels[$key] ?? parent::label($key);
    }
}
