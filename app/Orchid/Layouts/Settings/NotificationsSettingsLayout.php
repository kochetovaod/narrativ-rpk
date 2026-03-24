<?php

namespace App\Orchid\Layouts\Settings;

class NotificationsSettingsLayout extends AbstractSettingsLayout
{
    protected function settingFields(): array
    {
        return [
            'notification_position' => 'select',
            'notification_duration' => 'integer',
        ];
    }

    protected function label(string $key): string
    {
        $labels = [
            'notification_position' => 'Позиция всплывающих уведомлений',
            'notification_duration' => 'Длительность показа уведомлений (мс)',
        ];

        return $labels[$key] ?? parent::label($key);
    }

    protected function options(string $key): array
    {
        return match ($key) {
            'notification_position' => [
                'top-left' => 'Сверху слева',
                'top-right' => 'Сверху справа',
                'top-center' => 'Сверху по центру',
                'bottom-left' => 'Снизу слева',
                'bottom-right' => 'Снизу справа',
                'bottom-center' => 'Снизу по центру',
            ],
            'notification_duration' => [
                '2000' => '2 секунды',
                '3000' => '3 секунды',
                '5000' => '5 секунд',
                '7000' => '7 секунд',
                '10000' => '10 секунд',
                '0' => 'Бесконечно (не скрывать)',
            ],
            default => [],
        };
    }
}
