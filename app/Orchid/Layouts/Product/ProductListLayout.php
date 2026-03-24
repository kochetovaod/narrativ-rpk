<?php

namespace App\Orchid\Layouts\Product;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Orchid\Platform\Models\User;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ProductListLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    protected $target = 'products';

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
                ->render(function (Product $product) {
                    if ($product->preview && $product->preview->url()) {
                        return "<img src='{$product->preview->url()}' alt='Превью' class='img-fluid' style='max-width: 60px; height: auto; border-radius: 4px;'>";
                    }

                    return '<span class="text-muted">—</span>';
                }),

            TD::make('title', 'Название')
                ->sort()
                ->render(function (Product $product) {
                    return Link::make($product->title)
                        ->route('platform.products.edit', $product);
                }),

            TD::make('slug', 'Slug')
                ->width('200px')
                ->render(function (Product $product) {
                    return "<span class='text-muted'>{$product->slug}</span>";
                }),

            TD::make('price_from', 'Цена от')
                ->width('120px')
                ->sort()
                ->render(function (Product $product) {
                    return $product->price_from
                        ? 'от '.number_format($product->price_from, 0, '', ' ').' ₽'
                        : '<span class="text-muted">—</span>';
                }),

            TD::make('active', 'Активность')
                ->width('80px')
                ->sort(),

            TD::make('sort', 'Порядок')
                ->width('120px')
                ->sort(),

            TD::make('created_at', 'Дата создания')
                ->width('120px')
                ->sort()
                ->render(function (Product $product) {
                    return $product->created_at->format('d.m.Y');
                }),

            TD::make('actions', 'Действия')
                ->width('100px')
                ->alignRight()
                ->render(function (Product $product) {
                    /** @var User|null $user */
                    $user = Auth::user();

                    $canDelete = $user?->hasAccess('platform.products.delete') ?? false;

                    $actions = [
                        Link::make('Редактировать')
                            ->route('platform.products.edit', $product)
                            ->icon('bs.pencil'),
                    ];

                    if ($canDelete) {
                        $actions[] = Button::make('Удалить')
                            ->icon('bs.trash')
                            ->method('remove', ['id' => $product->id])
                            ->confirm('Удалить продукцию "'.$product->title.'"?');
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
        return 'Нет продукции. Добавьте новую продукцию, чтобы она появилась в этом списке.';
    }

    /**
     * Get the text for the table heading.
     */
    protected function heading(): string
    {
        return 'Список прдукции';
    }
}
