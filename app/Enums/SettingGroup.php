<?php

// app/Enums/SettingGroup.php

namespace App\Enums;

use App\Contracts\HasLabel;
use App\Traits\EnumHelpers;

enum SettingGroup: string implements HasLabel
{
    use EnumHelpers;

    case GENERAL = 'general';
    case CONTACTS = 'contacts';
    case SOCIAL = 'social';
    case SEO = 'seo';
    case TELEGRAM = 'telegram';
    case EMAIL = 'email';
    case DESIGN = 'design';
    case INTEGRATIONS = 'integrations';
    case NOTIFICATIONS = 'notifications';
    case CONTENT = 'content';

    public function label(): string
    {
        return match ($this) {
            self::GENERAL => 'Основные',
            self::CONTACTS => 'Контакты',
            self::SOCIAL => 'Социальные сети',
            self::SEO => 'SEO',
            self::TELEGRAM => 'Telegram',
            self::EMAIL => 'Email',
            self::DESIGN => 'Дизайн',
            self::INTEGRATIONS => 'Интеграции',
            self::NOTIFICATIONS => 'Уведомления',
            self::CONTENT => 'Контент страниц',
        };
    }

    /**
     * Получить иконку для группы
     */
    public function icon(): string
    {
        return match ($this) {
            self::GENERAL => 'settings',
            self::CONTACTS => 'phone',
            self::SOCIAL => 'social',
            self::SEO => 'globe',
            self::TELEGRAM => 'paper-plane',
            self::EMAIL => 'envelope',
            self::DESIGN => 'brush',
            self::INTEGRATIONS => 'puzzle',
            self::NOTIFICATIONS => 'bell',
            self::CONTENT => 'doc',
        };
    }

    /**
     * Получить порядок сортировки групп
     */
    public function sortOrder(): int
    {
        return match ($this) {
            self::GENERAL => 1,
            self::CONTACTS => 2,
            self::SOCIAL => 3,
            self::SEO => 4,
            self::TELEGRAM => 5,
            self::EMAIL => 6,
            self::DESIGN => 7,
            self::INTEGRATIONS => 8,
            self::NOTIFICATIONS => 9,
            self::CONTENT => 10,
        };
    }

    /**
     * Получить описание группы
     */
    public function description(): string
    {
        return match ($this) {
            self::GENERAL => 'Основные настройки сайта',
            self::CONTACTS => 'Контактная информация компании',
            self::SOCIAL => 'Ссылки на социальные сети',
            self::SEO => 'Настройки для поисковой оптимизации',
            self::TELEGRAM => 'Настройки Telegram бота и уведомлений',
            self::EMAIL => 'Настройки email-рассылок',
            self::DESIGN => 'Настройки внешнего вида',
            self::INTEGRATIONS => 'Настройки интеграций с внешними сервисами',
            self::NOTIFICATIONS => 'Настройки уведомлений',
            self::CONTENT => 'Текстовые блоки страниц и секций',
        };
    }
}
