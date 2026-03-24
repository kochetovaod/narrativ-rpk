<?php

namespace App\Enums;

use App\Contracts\HasColor;
use App\Contracts\HasLabel;
use App\Traits\EnumHelpers;

enum TaskPriority: string implements HasColor, HasLabel
{
    use EnumHelpers;

    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';

    public function label(): string
    {
        return match ($this) {
            self::LOW => 'Низкий',
            self::MEDIUM => 'Средний',
            self::HIGH => 'Высокий',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::LOW => 'gray',
            self::MEDIUM => 'blue',
            self::HIGH => 'orange',
        };
    }

    /**
     * Получить вес для сортировки
     */
    public function weight(): int
    {
        return match ($this) {
            self::LOW => 1,
            self::MEDIUM => 2,
            self::HIGH => 3,
        };
    }

    /**
     * Получить CSS класс для бейджа
     */
    public function badgeClass(): string
    {
        return match ($this) {
            self::LOW => 'badge-secondary',
            self::MEDIUM => 'badge-info',
            self::HIGH => 'badge-warning',
        };
    }
}
