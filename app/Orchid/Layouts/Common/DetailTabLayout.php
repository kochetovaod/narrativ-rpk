<?php

namespace App\Orchid\Layouts\Common;

use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Layouts\Rows;

/**
 * Переиспользуемый слой для вкладки "Подробно"
 */
class DetailTabLayout extends Rows
{
    /**
     * @var string Префикс для имён полей
     */
    protected string $prefix;

    /**
     * @var int Ширина детального изображения
     */
    protected int $imageWidth;

    /**
     * @var int Высота детального изображения
     */
    protected int $imageHeight;

    public function __construct(
        string $prefix = 'entity',
        int $imageWidth = 1200,
        int $imageHeight = 800
    ) {
        $this->prefix = $prefix;
        $this->imageWidth = $imageWidth;
        $this->imageHeight = $imageHeight;
    }

    /**
     * Используемые виды полей.
     */
    protected function fields(): array
    {
        return [
            Cropper::make("{$this->prefix}.detail_id")
                ->title('Детальное изображение')
                ->width($this->imageWidth)
                ->height($this->imageHeight)
                ->targetId()
                ->help("Рекомендуемый размер: {$this->imageWidth}x{$this->imageHeight}px. Изображение будет автоматически конвертировано в WebP."),

            Quill::make("{$this->prefix}.content")
                ->title('Подробное описание')
                ->placeholder('Введите подробное описание...')
                ->help('Полный текст с форматированием'),
        ];
    }
}
