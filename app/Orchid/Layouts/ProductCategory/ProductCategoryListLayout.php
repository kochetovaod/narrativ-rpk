<?php

namespace App\Orchid\Layouts\ProductCategory;

use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;
use Orchid\Platform\Models\User;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ProductCategoryListLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    protected $target = 'productCategories';

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

            TD::make('preview', 'Превью')
                ->width('80px')
                ->render(function (ProductCategory $category) {
                    if ($category->preview && $category->preview->url()) {
                        return "<img src='{$category->preview->url()}' alt='Превью' class='img-fluid' style='max-width: 60px; height: auto; border-radius: 4px;'>";
                    }

                    return '<span class="text-muted">—</span>';
                }),

            TD::make('title', 'Название')
                ->sort()
                ->render(function (ProductCategory $category) {
                    return Link::make($category->title)
                        ->route('platform.product-categories.edit', $category);
                }),

            TD::make('products_count', 'Товаров')
                ->width('100px')
                ->render(function (ProductCategory $category) {
                    $count = $category->products()->count();

                    return $count > 0
                        ? "<span class='badge bg-info'>{$count}</span>"
                        : '<span class="text-muted">0</span>';
                }),

            TD::make('active', 'Активность')
                ->width('80px')
                ->sort(),

            TD::make('sort', 'Порядок')
                ->width('100px')
                ->sort(),

            TD::make('created_at', 'Дата создания')
                ->width('120px')
                ->sort()
                ->render(function (ProductCategory $category) {
                    return $category->created_at->format('d.m.Y');
                }),

            TD::make('actions', 'Действия')
                ->width('100px')
                ->alignRight()
                ->render(function (ProductCategory $category) {
                    /** @var User|null $user */
                    $user = Auth::user();

                    $canDelete = $user?->hasAccess('platform.product-categories.delete') ?? false;

                    $actions = [
                        Link::make('Редактировать')
                            ->route('platform.product-categories.edit', $category)
                            ->icon('bs.pencil'),
                    ];

                    if ($canDelete) {
                        $actions[] = Button::make('Удалить')
                            ->icon('bs.trash')
                            ->method('remove', ['id' => $category->id])
                            ->confirm('Удалить категорию "'.$category->title.'"?');
                    }

                    return DropDown::make()
                        ->icon('bs.three-dots-vertical')
                        ->list($actions);
                }),
        ];
    }

    /**
     * Get the text for the list's empty state.
     */
    protected function empty(): string
    {
        return 'Нет категорий продукции. Добавьте первую категорию.';
    }

    /**
     * Get the text for the table heading.
     */
    protected function heading(): string
    {
        return 'Категории продукции';
    }
}
