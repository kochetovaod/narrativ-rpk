<?php

namespace App\Orchid\Layouts\Settings;

class TelegramSettingsLayout extends AbstractSettingsLayout
{
    protected function settingFields(): array
    {
        return [
            'telegram_bot_token' => 'string',
            'telegram_chat_id' => 'string',
            'telegram_notifications_enabled' => 'boolean',
            'telegram_notify_new_order' => 'boolean',
            'telegram_notify_new_feedback' => 'boolean',
            'telegram_notify_new_user' => 'boolean',
        ];
    }

    protected function label(string $key): string
    {
        $labels = [
            'telegram_bot_token' => 'Токен Telegram бота',
            'telegram_chat_id' => 'ID чата для уведомлений',
            'telegram_notifications_enabled' => 'Включить уведомления в Telegram',
            'telegram_notify_new_order' => 'Уведомлять о новых заказах',
            'telegram_notify_new_feedback' => 'Уведомлять о новых сообщениях из форм',
            'telegram_notify_new_user' => 'Уведомлять о регистрации новых пользователей',
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
