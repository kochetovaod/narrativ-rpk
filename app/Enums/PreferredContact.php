<?php

namespace App\Enums;

use App\Contracts\HasIcon;
use App\Contracts\HasLabel;
use App\Traits\EnumHelpers;

enum PreferredContact: string implements HasIcon, HasLabel
{
    use EnumHelpers;

    case PHONE = 'phone';
    case EMAIL = 'email';
    case TELEGRAM = 'telegram';
    case WHATSAPP = 'whatsapp';

    public function label(): string
    {
        return match ($this) {
            self::PHONE => 'Телефон',
            self::EMAIL => 'Email',
            self::TELEGRAM => 'Telegram',
            self::WHATSAPP => 'WhatsApp',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::PHONE => 'call',
            self::EMAIL => 'mail',
            self::TELEGRAM => 'telegram',
            self::WHATSAPP => 'whatsapp',
        };
    }

    /**
     * Получить маску/валидацию для контакта
     */
    public function validationRule(): string
    {
        return match ($this) {
            self::PHONE => 'phone',
            self::EMAIL => 'email',
            self::TELEGRAM => 'regex:/^@?[a-zA-Z0-9_]{5,}$/',
            self::WHATSAPP => 'phone',
        };
    }
}
