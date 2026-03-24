<?php

namespace App\Orchid\Layouts\Seo;

use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

/**
 * Layout для редактирования SEO данных
 *
 * Особенности:
 * - Только одна вкладка с SEO полями
 * - Отображает информацию о связанной сущности
 */
class SeoEditLayout extends Rows
{
    /**
     * @var \App\Models\Seo
     */
    protected $seo;

    public function __construct(?\App\Models\Seo $seo = null)
    {
        $this->seo = $seo;
    }

    /**
     * Используемые виды полей.
     */
    protected function fields(): array
    {
        return [
            Input::make('seo.title')
                ->title('SEO заголовок')
                ->placeholder('Оставьте пустым для автозаполнения')
                ->maxlength(60)
                ->help('Заголовок для поисковых систем (рекомендуется до 60 символов)'),

            TextArea::make('seo.description')
                ->title('SEO описание')
                ->rows(3)
                ->maxlength(160)
                ->placeholder('Оставьте пустым для автозаполнения')
                ->help('Описание для поисковых систем (рекомендуется до 160 символов)'),

            Input::make('seo.keywords')
                ->title('Ключевые слова')
                ->placeholder('ключ1, ключ2, ключ3')
                ->help('Ключевые слова через запятую'),

            Input::make('seo.canonical_url')
                ->title('Канонический URL')
                ->placeholder('https://example.com/page')
                ->help('Указывает на основную версию страницы для избежания дублирования'),

            Select::make('seo.robots')
                ->title('Индексация')
                ->options([
                    'index, follow' => 'Индексировать и следовать по ссылкам',
                    'noindex, follow' => 'Не индексировать, но следовать по ссылкам',
                    'index, nofollow' => 'Индексировать, но не следовать по ссылкам',
                    'noindex, nofollow' => 'Не индексировать и не следовать по ссылкам',
                ])
                ->value('index, follow')
                ->help('Правила индексации для поисковых роботов'),

            Input::make('seo.og_title')
                ->title('Open Graph заголовок')
                ->placeholder('Оставьте пустым для использования SEO заголовка')
                ->maxlength(95)
                ->help('Заголовок для социальных сетей'),

            TextArea::make('seo.og_description')
                ->title('Open Graph описание')
                ->rows(3)
                ->maxlength(200)
                ->placeholder('Оставьте пустым для использования SEO описания')
                ->help('Описание для социальных сетей'),

            Cropper::make('seo.og_image_id')
                ->title('Open Graph изображение')
                ->width(1200)
                ->height(630)
                ->targetId()
                ->help('Рекомендуемый размер: 1200x630px. Используется при публикации в соцсетях.'),
        ];
    }
}
