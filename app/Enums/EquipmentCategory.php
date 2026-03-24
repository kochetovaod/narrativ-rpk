<?php

// app/Enums/EquipmentCategory.php

namespace App\Enums;

use App\Contracts\HasLabel;
use App\Traits\EnumHelpers;

enum EquipmentCategory: string implements HasLabel
{
    use EnumHelpers;

    case MILLING = 'milling';
    case LASER = 'laser';
    case UV_PRINT = 'uv_print';
    case WIDE_FORMAT = 'wide_format';
    case LAMINATION = 'lamination';

    public function label(): string
    {
        return match ($this) {
            self::MILLING => 'ФРЕЗЕРОВАНИЕ',
            self::LASER => 'ЛАЗЕРНАЯ РЕЗКА',
            self::UV_PRINT => 'УФ-ПЕЧАТЬ',
            self::WIDE_FORMAT => 'ШИРОКОФОРМАТ',
            self::LAMINATION => 'ЛАМИНАЦИЯ',
        };
    }

    /**
     * Получить бейдж для категории
     */
    public function badge(): ?string
    {
        return match ($this) {
            self::MILLING => 'Флагман',
            self::LASER => 'Лазер',
            self::UV_PRINT => 'Печать',
            self::WIDE_FORMAT => 'Постеры',
            self::LAMINATION => 'Защита',
        };
    }

    /**
     * Получить иконку для категории
     */
    public function icon(): string
    {
        return match ($this) {
            self::MILLING => 'cog', // Шестеренка
            self::LASER => 'bolt', // Молния
            self::UV_PRINT => 'printer', // Принтер
            self::WIDE_FORMAT => 'arrows-alt-h', // Широкие стрелки
            self::LAMINATION => 'layer-group', // Слои
        };
    }

    /**
     * Получить цвет для категории
     */
    public function color(): string
    {
        return match ($this) {
            self::MILLING => '#4CAF50', // Зеленый
            self::LASER => '#FF5722', // Оранжевый
            self::UV_PRINT => '#9C27B0', // Фиолетовый
            self::WIDE_FORMAT => '#2196F3', // Синий
            self::LAMINATION => '#FFC107', // Желтый
        };
    }

    /**
     * Получить описание категории
     */
    public function description(): string
    {
        return match ($this) {
            self::MILLING => 'Фрезерная обработка материалов',
            self::LASER => 'Лазерная резка и гравировка',
            self::UV_PRINT => 'УФ-печать на различных поверхностях',
            self::WIDE_FORMAT => 'Широкоформатная печать',
            self::LAMINATION => 'Ламинация и постпечатная обработка',
        };
    }

    /**
     * Получить порядок сортировки
     */
    public function sortOrder(): int
    {
        return match ($this) {
            self::MILLING => 1,
            self::LASER => 2,
            self::UV_PRINT => 3,
            self::WIDE_FORMAT => 4,
            self::LAMINATION => 5,
        };
    }

    /**
     * Проверить, показывать ли бейдж для этой категории
     */
    public function hasBadge(): bool
    {
        return ! is_null($this->badge());
    }

    /**
     * Получить CSS класс для категории
     */
    public function cssClass(): string
    {
        return match ($this) {
            self::MILLING => 'equipment-category-milling',
            self::LASER => 'equipment-category-laser',
            self::UV_PRINT => 'equipment-category-uv',
            self::WIDE_FORMAT => 'equipment-category-wide',
            self::LAMINATION => 'equipment-category-lamination',
        };
    }
}
