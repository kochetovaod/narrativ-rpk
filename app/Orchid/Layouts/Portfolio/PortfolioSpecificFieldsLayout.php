<?php

namespace App\Orchid\Layouts\Portfolio;

use App\Models\Client;
use App\Models\Product;
use App\Models\Service;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Layouts\Rows;

/**
 * Специфичные поля для работ портфолио
 */
class PortfolioSpecificFieldsLayout extends Rows
{
    /**
     * Используемые виды полей.
     */
    protected function fields(): array
    {
        return [
            Relation::make('portfolio.client_id')
                ->title('Клиент')
                ->fromModel(Client::class, 'title')
                ->empty('Не выбрано')
                ->help('Клиент, для которого выполнена работа'),

            Relation::make('portfolio.services')
                ->title('Услуги')
                ->fromModel(Service::class, 'title')
                ->multiple()
                ->max(10)
                ->help('Услуги, оказанные в рамках проекта'),

            Relation::make('portfolio.products')
                ->title('Продукция')
                ->fromModel(Product::class, 'title')
                ->multiple()
                ->max(20)
                ->help('Продукция, использованная в проекте'),

            DateTimer::make('portfolio.completed_at')
                ->title('Дата выполнения')
                ->allowInput()
                ->format('Y-m-d')
                ->help('Дата завершения проекта'),

            Relation::make('portfolio.services.*.pivot.sort')
                ->title('Порядок услуг')
                ->type('hidden'),

            Relation::make('portfolio.products.*.pivot.sort')
                ->title('Порядок продукции')
                ->type('hidden'),
        ];
    }
}
