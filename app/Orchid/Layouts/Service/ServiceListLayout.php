<?php

namespace App\Orchid\Layouts\Service;

use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Orchid\Platform\Models\User;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ServiceListLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    protected $target = 'services';

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
                ->render(function (Service $service) {
                    if ($service->preview && $service->preview->url()) {
                        return "<img src='{$service->preview->url()}' alt='Превью' class='img-fluid' style='max-width: 60px; height: auto; border-radius: 4px;'>";
                    }

                    return '<span class="text-muted">—</span>';
                }),

            TD::make('title', 'Название')
                ->sort()
                ->render(function (Service $service) {
                    return Link::make($service->title)
                        ->route('platform.services.edit', $service);
                }),

            TD::make('slug', 'Slug')
                ->width('200px')
                ->render(function (Service $service) {
                    return "<span class='text-muted'>{$service->slug}</span>";
                }),

            TD::make('price_from', 'Цена от')
                ->width('120px')
                ->sort()
                ->render(function (Service $service) {
                    return $service->price_from
                        ? 'от '.number_format($service->price_from, 0, '', ' ').' ₽'
                        : '<span class="text-muted">—</span>';
                }),

            TD::make('active', 'Активна')
                ->width('80px')
                ->sort(),

            TD::make('sort', 'Порядок')
                ->width('120px')
                ->sort(),

            TD::make('created_at', 'Дата создания')
                ->width('120px')
                ->sort()
                ->render(function (Service $service) {
                    return $service->created_at->format('d.m.Y');
                }),

            TD::make('actions', 'Действия')
                ->width('100px')
                ->alignRight()
                ->render(function (Service $service) {
                    /** @var User|null $user */
                    $user = Auth::user();

                    $canDelete = $user?->hasAccess('platform.services.delete') ?? false;

                    $actions = [
                        Link::make('Редактировать')
                            ->route('platform.services.edit', $service)
                            ->icon('bs.pencil'),
                    ];

                    if ($canDelete) {
                        $actions[] = Button::make('Удалить')
                            ->icon('bs.trash')
                            ->method('remove', ['id' => $service->id])
                            ->confirm('Удалить услугу "'.$service->title.'"?');
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
        return 'Нет услуг. Добавьте первую услугу.';
    }

    /**
     * Get the text for the table heading.
     */
    protected function heading(): string
    {
        return 'Список услуг';
    }
}
