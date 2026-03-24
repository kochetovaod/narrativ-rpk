<?php

namespace App\Orchid\Layouts\Common;

use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;

/**
 * Переиспользуемый слой для вкладки "Галерея"
 */
class GalleryTabLayout extends Rows
{
    /**
     * @var string Префикс для имён полей
     */
    protected string $prefix;

    public function __construct(string $prefix = 'entity')
    {
        $this->prefix = $prefix;
    }

    /**
     * Используемые виды полей.
     */
    protected function fields(): array
    {
        return [
            Upload::make("{$this->prefix}.attachments")
                ->title('Галерея изображений')
                ->acceptedFiles('image/*')
                ->maxFiles(20)
                ->help('Вы можете загрузить до 20 изображений. Поддерживаемые форматы: JPG, PNG, GIF, WebP.')
                ->placeholder('Перетащите файлы сюда или нажмите для выбора'),
        ];
    }
}
