<?php

namespace App\Enums;

use App\Contracts\HasColor;
use App\Contracts\HasLabel;
use App\Traits\EnumHelpers;

enum LeadPriority: string implements HasColor, HasLabel
{
    use EnumHelpers;

    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
    case URGENT = 'urgent';

    public function label(): string
    {
        return match ($this) {
            self::LOW => 'Низкий',
            self::MEDIUM => 'Средний',
            self::HIGH => 'Высокий',
            self::URGENT => 'Срочно',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::LOW => 'gray',
            self::MEDIUM => 'blue',
            self::HIGH => 'orange',
            self::URGENT => 'red',
        };
    }

    /**
     * Получить вес приоритета для сортировки
     */
    public function weight(): int
    {
        return match ($this) {
            self::LOW => 1,
            self::MEDIUM => 2,
            self::HIGH => 3,
            self::URGENT => 4,
        };
    }

    /**
     * Максимальное время реакции в часах
     */
    public function maxResponseHours(): int
    {
        return match ($this) {
            self::LOW => 48,
            self::MEDIUM => 24,
            self::HIGH => 4,
            self::URGENT => 1,
        };
    }
}
