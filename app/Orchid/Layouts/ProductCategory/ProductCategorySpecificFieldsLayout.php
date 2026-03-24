<?php

namespace App\Orchid\Layouts\ProductCategory;

use Orchid\Screen\Layouts\Rows;

/**
 * Специфичные поля для категорий продукции
 *
 * Категории продукции используют только стандартные поля:
 * - Основные поля (MainFieldsLayout)
 * - Анонс (PreviewTabLayout)
 * - Подробно (DetailTabLayout)
 * - SEO (SeoTabLayout)
 * - Галерея (GalleryTabLayout)
 *
 * Специфичных полей нет.
 */
class ProductCategorySpecificFieldsLayout extends Rows
{
    /**
     * Используемые виды полей.
     */
    protected function fields(): array
    {
        return [
            // Специфичных полей нет - категории используют только стандартные layouts
        ];
    }
}
