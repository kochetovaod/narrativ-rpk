<?php

namespace App\Orchid\Layouts\Blog;

use Orchid\Screen\Layouts\Rows;

/**
 * Специфичные поля для новостей
 *
 * Новости используют только стандартные поля:
 * - Основные поля (MainFieldsLayout)
 * - Анонс (PreviewTabLayout)
 * - Подробно (DetailTabLayout)
 * - SEO (SeoTabLayout)
 *
 * Специфичных полей нет.
 * Нет вкладки "Галерея".
 */
class BlogSpecificFieldsLayout extends Rows
{
    /**
     * Используемые виды полей.
     */
    protected function fields(): array
    {
        return [
            // Специфичных полей нет - новости используют только стандартные layouts
        ];
    }
}
