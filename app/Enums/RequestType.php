<?php

namespace App\Enums;

use App\Contracts\HasLabel;
use App\Traits\EnumHelpers;

enum RequestType: string implements HasLabel
{
    use EnumHelpers;

    case CALCULATE = 'calculate';
    case CALLBACK = 'callback';
    case QUESTION = 'question';
    case ORDER = 'order';
    case CONSULTATION = 'consultation';

    public function label(): string
    {
        return match ($this) {
            self::CALCULATE => 'Расчет стоимости',
            self::CALLBACK => 'Обратный звонок',
            self::QUESTION => 'Вопрос',
            self::ORDER => 'Заказ',
            self::CONSULTATION => 'Консультация',
        };
    }

    /**
     * Какие поля обязательны для этого типа заявки
     */
    public function requiredFields(): array
    {
        return match ($this) {
            self::CALCULATE => ['name', 'phone', 'message'],
            self::CALLBACK => ['phone'],
            self::QUESTION => ['name', 'email', 'message'],
            self::ORDER => ['name', 'phone', 'product_id'],
            self::CONSULTATION => ['name', 'phone'],
        };
    }
}
