<?php

namespace App\Enums;

use App\Contracts\HasColor;
use App\Contracts\HasLabel;
use App\Traits\EnumHelpers;

enum LeadStatus: string implements HasColor, HasLabel
{
    use EnumHelpers;

    case NEW = 'new';
    case ASSIGNED = 'assigned';
    case IN_PROGRESS = 'in_progress';
    case WAITING = 'waiting';
    case QUALIFIED = 'qualified';
    case UNQUALIFIED = 'unqualified';
    case CONVERTED = 'converted';
    case CLOSED = 'closed';
    case LOST = 'lost';
    case SPAM = 'spam';

    public function label(): string
    {
        return match ($this) {
            self::NEW => 'Новая',
            self::ASSIGNED => 'Назначена',
            self::IN_PROGRESS => 'В работе',
            self::WAITING => 'Ожидание ответа',
            self::QUALIFIED => 'Квалифицирован',
            self::UNQUALIFIED => 'Неквалифицирован',
            self::CONVERTED => 'Конвертирован',
            self::CLOSED => 'Закрыта (успешно)',
            self::LOST => 'Проиграна',
            self::SPAM => 'Спам',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::NEW => 'blue',
            self::ASSIGNED => 'cyan',
            self::IN_PROGRESS => 'orange',
            self::WAITING => 'yellow',
            self::QUALIFIED => 'green',
            self::UNQUALIFIED => 'gray',
            self::CONVERTED => 'emerald',
            self::CLOSED => 'green',
            self::LOST => 'red',
            self::SPAM => 'purple',
        };
    }

    /**
     * Получить CSS класс для отображения бейджа
     */
    public function badgeClass(): string
    {
        return match ($this) {
            self::NEW => 'badge-info',
            self::ASSIGNED => 'badge-primary',
            self::IN_PROGRESS => 'badge-warning',
            self::WAITING => 'badge-warning-light',
            self::QUALIFIED => 'badge-success',
            self::UNQUALIFIED => 'badge-secondary',
            self::CONVERTED => 'badge-success',
            self::CLOSED => 'badge-success-light',
            self::LOST => 'badge-danger',
            self::SPAM => 'badge-dark',
        };
    }

    /**
     * Статусы, требующие внимания менеджера
     */
    public function requiresAttention(): bool
    {
        return in_array($this, [
            self::NEW,
            self::WAITING,
            self::ASSIGNED,
        ]);
    }

    /**
     * Финальные статусы (не требуют действий)
     */
    public function isFinal(): bool
    {
        return in_array($this, [
            self::CONVERTED,
            self::CLOSED,
            self::LOST,
            self::SPAM,
        ]);
    }
}
