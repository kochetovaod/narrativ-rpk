<?php

namespace App\Orchid\Layouts\Client;

use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Layouts\Rows;

/**
 * Специфичные поля для клиентов
 *
 * Клиенты используют:
 * - Основные поля (MainFieldsLayout)
 * - Специфичные поля: логотип
 *
 * Нет вкладки "Галерея".
 * Нет SEO.
 */
class ClientSpecificFieldsLayout extends Rows
{
    /**
     * Используемые виды полей.
     */
    protected function fields(): array
    {
        return [
            Cropper::make('client.logo_id')
                ->title('Логотип клиента')
                ->width(200)
                ->height(100)
                ->targetId()
                ->help('Рекомендуемый размер: 200x100px. Логотип будет автоматически конвертирован в WebP.'),
        ];
    }
}
