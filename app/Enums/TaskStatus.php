<?php

// app/Enums/TaskStatus.php

namespace App\Enums;

use App\Contracts\HasColor;
use App\Contracts\HasLabel;
use App\Traits\EnumHelpers;

enum TaskStatus: string implements HasColor, HasLabel
{
    use EnumHelpers;

    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Ожидает',
            self::IN_PROGRESS => 'В работе',
            self::COMPLETED => 'Выполнена',
            self::CANCELLED => 'Отменена',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PENDING => 'gray',
            self::IN_PROGRESS => 'blue',
            self::COMPLETED => 'green',
            self::CANCELLED => 'red',
        };
    }

    public function isActive(): bool
    {
        return in_array($this, [self::PENDING, self::IN_PROGRESS]);
    }

    /**
     * Завершающие статусы
     */
    public function isFinal(): bool
    {
        return in_array($this, [self::COMPLETED, self::CANCELLED]);
    }
}
