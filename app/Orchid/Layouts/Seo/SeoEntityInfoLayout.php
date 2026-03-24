<?php

namespace App\Orchid\Layouts\Seo;

use App\Models\SEO as Seo;
use Orchid\Screen\Layouts\Legend;
use Orchid\Screen\Sight;

class SeoEntityInfoLayout extends Legend
{
    /**
     * Целевой объект для отображения
     *
     * @var string
     */
    protected $target = 'seo';

    /**
     * @var array
     */
    protected $typeLabels = [
        'App\Models\Service' => 'Услуга',
        'App\Models\Product' => 'Продукция',
        'App\Models\Blog' => 'Новость',
        'App\Models\Portfolio' => 'Портфолио',
        'App\Models\ProductCategory' => 'Категория продукции',
        'App\Models\Page' => 'Страница',
        'App\Models\Client' => 'Клиент',
    ];

    protected function columns(): array
    {
        return [
            Sight::make('seoable', 'Связанная сущность')
                ->render(function (Seo $seo) {
                    $entity = $seo->seoable;

                    if (! $entity) {
                        return 'Связанная сущность не найдена';
                    }

                    return $entity->title ?? $entity->name ?? 'Без названия';
                }),

            Sight::make('seoable_id', 'ID связанной сущности')
                ->render(fn (Seo $seo) => $seo->seoable_id ?? '—'),

            Sight::make('seoable_type', 'Тип связанной сущности')
                ->render(function (Seo $seo) {
                    return $this->typeLabels[$seo->seoable_type] ?? $seo->seoable_type;
                }),
        ];
    }
}
