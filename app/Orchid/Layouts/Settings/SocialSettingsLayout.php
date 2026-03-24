<?php

namespace App\Orchid\Layouts\Settings;

class SocialSettingsLayout extends AbstractSettingsLayout
{
    protected function settingFields(): array
    {
        return [
            'social_vk' => 'string',
            'social_telegram' => 'string',
            'social_whatsapp' => 'string',
            'social_instagram' => 'string',
            'social_youtube' => 'string',
            'social_viber' => 'string',
        ];
    }

    protected function label(string $key): string
    {
        $labels = [
            'social_vk' => 'ВКонтакте',
            'social_telegram' => 'Telegram канал',
            'social_whatsapp' => 'WhatsApp',
            'social_instagram' => 'Instagram',
            'social_youtube' => 'YouTube канал',
            'social_viber' => 'Viber',
        ];

        return $labels[$key] ?? parent::label($key);
    }
}
