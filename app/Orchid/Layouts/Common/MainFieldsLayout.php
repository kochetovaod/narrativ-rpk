<?php

namespace App\Orchid\Layouts\Common;

use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

/**
 * Переиспользуемый слой для основных полей сущности
 */
class MainFieldsLayout extends Rows
{
    /**
     * @var string Префикс для имён полей
     */
    protected string $prefix;

    /**
     * @var string Заголовок для поля title
     */
    protected string $titleLabel;

    public function __construct(string $prefix = 'entity', string $titleLabel = 'Название')
    {
        $this->prefix = $prefix;
        $this->titleLabel = $titleLabel;
    }

    /**
     * Используемые виды полей.
     */
    protected function fields(): array
    {
        return [
            Input::make("{$this->prefix}.title")
                ->title($this->titleLabel)
                ->placeholder('Введите название')
                ->required()
                ->help('Основное название, которое будет отображаться на сайте'),

            Input::make("{$this->prefix}.slug")
                ->title('URL (slug)')
                ->placeholder('Оставьте пустым для автогенерации')
                ->help('Оставьте поле пустым, и slug будет сгенерирован автоматически из названия'),

            CheckBox::make("{$this->prefix}.active")
                ->title('Активность')
                ->placeholder('Опубликовано')
                ->sendTrueOrFalse()
                ->help('Отображать ли запись на сайте'),

            Input::make("{$this->prefix}.sort")
                ->title('Порядок сортировки')
                ->type('number')
                ->value(500)
                ->help('Чем меньше значение, тем выше в списке'),

            DateTimer::make("{$this->prefix}.published_at")
                ->title('Дата публикации')
                ->allowInput()
                ->format('Y-m-d H:i:s')
                ->help('Дата и время, когда запись станет доступна на сайте'),
        ];
    }
}
