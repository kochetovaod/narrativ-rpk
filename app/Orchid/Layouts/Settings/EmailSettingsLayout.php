<?php

namespace App\Orchid\Layouts\Settings;

class EmailSettingsLayout extends AbstractSettingsLayout
{
    protected function settingFields(): array
    {
        return [
            'email_notifications_enabled' => 'boolean',
            'email_admin' => 'string',
            'email_sales' => 'string',
            'email_support' => 'string',
            'email_from_name' => 'string',
            'email_signature' => 'text',
        ];
    }

    protected function label(string $key): string
    {
        $labels = [
            'email_notifications_enabled' => 'Включить email-уведомления',
            'email_admin' => 'Email для получения уведомлений',
            'email_sales' => 'Email для заказов',
            'email_support' => 'Email техподдержки',
            'email_from_name' => 'Имя отправителя писем',
            'email_signature' => 'Подпись в письмах',
        ];

        return $labels[$key] ?? parent::label($key);
    }
}
