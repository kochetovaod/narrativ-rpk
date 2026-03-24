<?php

namespace App\Orchid\Layouts\Service;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Layouts\Rows;

/**
 * Специфичные поля для услуг
 */
class ServiceSpecificFieldsLayout extends Rows
{
    /**
     * Используемые виды полей.
     */
    protected function fields(): array
    {
        return [
            Input::make('service.price_from')
                ->title('Цена от (₽)')
                ->type('number')
                ->step(0.01)
                ->placeholder('Оставьте пустым, если цена по запросу')
                ->help('Минимальная стоимость услуги в рублях'),

            Matrix::make('service.specs')
                ->title('Характеристики услуги')
                ->columns([
                    'Название' => 'name',
                    'Значение' => 'value',
                ])
                ->fields([
                    'name' => Input::make()->placeholder('Название характеристики'),
                    'value' => Input::make()->placeholder('Значение'),
                ])
                ->help('Дополнительные характеристики и параметры услуги'),
        ];
    }
}
