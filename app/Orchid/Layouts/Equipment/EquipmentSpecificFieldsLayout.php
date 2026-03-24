<?php

namespace App\Orchid\Layouts\Equipment;

use Orchid\Screen\Layouts\Rows;

/**
 * Специфичные поля для оборудования
 *
 * Оборудование использует только стандартные поля:
 * - Основные поля (MainFieldsLayout)
 * - Анонс (PreviewTabLayout)
 * - Подробно (DetailTabLayout)
 *
 * Нет вкладки "Галерея".
 * Нет SEO.
 */
class EquipmentSpecificFieldsLayout extends Rows
{
    /**
     * Используемые виды полей.
     */
    protected function fields(): array
    {
        return [
            // Специфичных полей нет
        ];
    }
}
