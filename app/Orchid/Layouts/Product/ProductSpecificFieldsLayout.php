<?php

namespace App\Orchid\Layouts\Product;

use App\Models\ProductCategory;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Layouts\Rows;

/**
 * Специфичные поля для продукции
 */
class ProductSpecificFieldsLayout extends Rows
{
    /**
     * Используемые виды полей.
     */
    protected function fields(): array
    {
        return [
            Relation::make('product.category_id')
                ->title('Категория продукции')
                ->fromModel(ProductCategory::class, 'title'),

            Input::make('product.price_from')
                ->title('Цена от (₽)')
                ->type('number')
                ->step(0.01)
                ->placeholder('Оставьте пустым, если цена по запросу')
                ->help('Минимальная стоимость продукции в рублях'),

            Matrix::make('product.specs')
                ->title('Характеристики продукции')
                ->columns([
                    'Название' => 'name',
                    'Значение' => 'value',
                ])
                ->fields([
                    'name' => Input::make()->placeholder('Название характеристики'),
                    'value' => Input::make()->placeholder('Значение'),
                ])
                ->help('Дополнительные характеристики и параметры продукции'),
        ];
    }
}
