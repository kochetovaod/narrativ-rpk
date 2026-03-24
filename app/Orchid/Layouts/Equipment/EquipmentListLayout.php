<?php

namespace App\Orchid\Layouts\Equipment;

use App\Models\Equipment;
use Illuminate\Support\Facades\Auth;
use Orchid\Platform\Models\User;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class EquipmentListLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    protected $target = 'equipment';

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
                ->render(function (Equipment $item) {
                    if ($item->preview && $item->preview->url()) {
                        return "<img src='{$item->preview->url()}' alt='Превью' class='img-fluid' style='max-width: 60px; height: auto; border-radius: 4px;'>";
                    }

                    return '<span class="text-muted">—</span>';
                }),

            TD::make('title', 'Название')
                ->sort()
                ->render(function (Equipment $item) {
                    return Link::make($item->title)
                        ->route('platform.equipment.edit', $item);
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
                ->render(function (Equipment $item) {
                    return $item->created_at->format('d.m.Y');
                }),

            TD::make('actions', 'Действия')
                ->width('100px')
                ->alignRight()
                ->render(function (Equipment $item) {
                    /** @var User|null $user */
                    $user = Auth::user();

                    $canDelete = $user?->hasAccess('platform.equipment.delete') ?? false;

                    $actions = [
                        Link::make('Редактировать')
                            ->route('platform.equipment.edit', $item)
                            ->icon('bs.pencil'),
                    ];

                    if ($canDelete) {
                        $actions[] = Button::make('Удалить')
                            ->icon('bs.trash')
                            ->method('remove', ['id' => $item->id])
                            ->confirm('Удалить оборудование "'.$item->title.'"?');
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
        return 'Нет оборудования. Добавьте первое оборудование.';
    }

    /**
     * Get the text for the table heading.
     */
    protected function heading(): string
    {
        return 'Оборудование';
    }
}
