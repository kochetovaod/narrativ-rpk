<?php

namespace App\Orchid\Layouts\Common;

use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

/**
 * Переиспользуемый слой для вкладки "Анонс"
 */
class PreviewTabLayout extends Rows
{
    /**
     * @var string Префикс для имён полей
     */
    protected string $prefix;

    /**
     * @var int Ширина изображения превью
     */
    protected int $imageWidth;

    /**
     * @var int Высота изображения превью
     */
    protected int $imageHeight;

    public function __construct(
        string $prefix = 'entity',
        int $imageWidth = 800,
        int $imageHeight = 600
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
            Cropper::make("{$this->prefix}.preview_id")
                ->title('Изображение для анонса')
                ->width($this->imageWidth)
                ->height($this->imageHeight)
                ->targetId()
                ->help("Рекомендуемый размер: {$this->imageWidth}x{$this->imageHeight}px. Изображение будет автоматически конвертировано в WebP."),

            TextArea::make("{$this->prefix}.excerpt")
                ->title('Краткое описание (анонс)')
                ->rows(5)
                ->maxlength(500)
                ->placeholder('Введите краткое описание для превью и списков')
                ->help('Максимум 500 символов. Используется в списках и карточках.'),
        ];
    }
}
