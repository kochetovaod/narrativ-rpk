<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use App\Models\ProductCategoryFilter;
use App\Models\ProductCategoryFilterValue;
use Illuminate\Database\Seeder;

class ProductCategoryFilterSeeder extends Seeder
{
    public function run(): void
    {
        $map = [
            'Объёмные буквы' => [
                'backlight' => ['Без подсветки', 'Фронтальная', 'Контражурная', 'Двойная', 'Цельносветовая'],
                'material' => ['Акрил', 'Композит', 'Металл'],
                'mounting' => ['Улица', 'Интерьер'],
            ],
            'Плоские буквы' => [
                'backlight' => ['Без подсветки', 'Контражурная'],
                'material' => ['ПВХ', 'Акрил', 'Металл'],
            ],
            'Световые короба' => [
                'light_type' => ['Фронтальная', 'Цельносветовая'],
                'body' => ['Акрил', 'Композит'],
                'shape' => ['Прямоугольный', 'Фигурный'],
            ],
            'Панель-кронштейны' => [
                'sides' => ['Односторонний', 'Двухсторонний'],
                'body' => ['Стандарт', 'Композит «на прорез»'],
            ],
            'Интерьерные световые панели' => [
                'format' => ['A4', 'A3', 'A2'],
                'mounting' => ['Настольный', 'Настенный', 'Подвесной'],
            ],
            'Современные вывески' => [
                'technology' => ['Текстиль', 'Акрил', 'Неон'],
                'place' => ['Интерьер', 'Фасад'],
            ],
            'Навигация' => [
                'type' => ['Стенд', 'Табличка'],
                'material' => ['Пластик', 'Металл', 'Композит'],
            ],
            'POSM и Полиграфия' => [
                'product_type' => ['POSM', 'Полиграфия'],
                'material' => ['Пластик', 'Бумага', 'Картон'],
            ],
        ];

        foreach ($map as $categoryTitle => $filters) {
            $category = ProductCategory::where('title', $categoryTitle)->first();

            foreach ($filters as $code => $values) {
                $filter = ProductCategoryFilter::create([
                    'category_id' => $category->id,
                    'code' => $code,
                    'title' => mb_ucfirst(str_replace('_', ' ', $code)),
                    'type' => 'checkbox',
                    'active' => true,
                ]);

                foreach ($values as $sort => $value) {
                    ProductCategoryFilterValue::create([
                        'filter_id' => $filter->id,
                        'value' => $value,
                        'sort' => $sort,
                        'active' => true,
                    ]);
                }
            }
        }
    }
}
