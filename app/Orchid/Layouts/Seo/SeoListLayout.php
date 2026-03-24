<?php

namespace App\Orchid\Layouts\Seo;

use App\Models\SEO as Seo;
use Illuminate\Support\Facades\Auth;
use Orchid\Platform\Models\User;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SeoListLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    protected $target = 'seoRecords';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('id', 'ID')
                ->width('60px')
                ->sort(),

            TD::make('entity_type', 'Тип сущности')
                ->width('150px')
                ->render(function (Seo $seo) {
                    return $this->getEntityTypeLabel($seo->seoable_type);
                }),

            TD::make('entity_title', 'Сущность')
                ->sort()
                ->render(function (Seo $seo) {
                    $entity = $seo->seoable;

                    if (! $entity) {
                        return '<span class="text-muted">—</span>';
                    }

                    $title = $entity->title ?? $entity->name ?? 'Без названия';
                    $url = $this->getEntityEditUrl($seo->seoable_type, $entity);

                    if ($url) {
                        return Link::make(e($title))
                            ->href($url)
                            ->target('_blank');
                    }

                    return e($title);
                }),

            TD::make('title', 'SEO заголовок')
                ->width('250px')
                ->render(function (Seo $seo) {
                    $title = $seo->title;

                    if (! $title) {
                        return '<span class="text-muted">Не заполнен</span>';
                    }

                    return e($title);
                }),

            TD::make('has_og_image', 'OG Image')
                ->width('100px')
                ->render(function (Seo $seo) {
                    if ($seo->ogImage && $seo->ogImage->url()) {
                        return '<span class="badge bg-success">Есть</span>';
                    }

                    return '<span class="badge bg-secondary">Нет</span>';
                }),

            TD::make('robots', 'Robots')
                ->width('150px')
                ->render(function (Seo $seo) {
                    return $seo->robots
                        ? "<span class='badge bg-info'>{$seo->robots}</span>"
                        : '<span class="text-muted">По умолчанию</span>';
                }),

            TD::make('created_at', 'Дата создания')
                ->width('140px')
                ->sort()
                ->render(function (Seo $seo) {
                    return $seo->created_at->format('d.m.Y H:i');
                }),

            TD::make('actions', 'Действия')
                ->width('100px')
                ->alignRight()
                ->render(function (Seo $seo) {
                    /** @var User|null $user */
                    $user = Auth::user();

                    $canEdit = $user?->hasAccess('platform.settings.manage') ?? false;

                    $actions = [];

                    if ($canEdit) {
                        $actions[] = Link::make('Редактировать')
                            ->route('platform.seo.edit', $seo)
                            ->icon('bs.pencil');
                    }

                    return DropDown::make()
                        ->icon('bs.three-dots-vertical')
                        ->list($actions);
                }),
        ];
    }

    /**
     * Получить читаемый тип сущности
     */
    protected function getEntityTypeLabel(?string $type): string
    {
        if (! $type) {
            return '<span class="text-muted">—</span>';
        }

        $labels = [
            'App\Models\Service' => 'Услуга',
            'App\Models\Product' => 'Продукция',
            'App\Models\Blog' => 'Новость',
            'App\Models\Portfolio' => 'Портфолио',
            'App\Models\ProductCategory' => 'Категория',
            'App\Models\Page' => 'Страница',
            'App\Models\Client' => 'Клиент',
        ];

        return $labels[$type] ?? class_basename($type);
    }

    /**
     * Получить URL редактирования сущности
     */
    protected function getEntityEditUrl(?string $type, $entity): ?string
    {
        if (! $type || ! $entity) {
            return null;
        }

        $routes = [
            'App\Models\Service' => 'platform.services.edit',
            'App\Models\Product' => 'platform.products.edit',
            'App\Models\Blog' => 'platform.blogs.edit',
            'App\Models\Portfolio' => 'platform.portfolio-works.edit',
            'App\Models\ProductCategory' => 'platform.product-categories.edit',
            'App\Models\Page' => 'platform.pages.edit',
            'App\Models\Client' => 'platform.clients.edit',
        ];

        $route = $routes[$type] ?? null;

        if ($route && method_exists($entity, 'exists') && $entity->exists) {
            return route($route, $entity);
        }

        return null;
    }

    /**
     * Get the text for the list's empty state.
     */
    protected function empty(): string
    {
        return 'Нет SEO записей.';
    }

    /**
     * Get the text for the table heading.
     */
    protected function heading(): string
    {
        return 'SEO данные';
    }
}
