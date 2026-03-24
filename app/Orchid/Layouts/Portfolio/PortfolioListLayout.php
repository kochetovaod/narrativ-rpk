<?php

namespace App\Orchid\Layouts\Portfolio;

use App\Models\Portfolio;
use Illuminate\Support\Facades\Auth;
use Orchid\Platform\Models\User;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class PortfolioListLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    protected $target = 'portfolio';

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
                ->render(function (Portfolio $work) {
                    if ($work->preview && $work->preview->url()) {
                        return "<img src='{$work->preview->url()}' alt='Превью' class='img-fluid' style='max-width: 60px; height: auto; border-radius: 4px;'>";
                    }

                    return '<span class="text-muted">—</span>';
                }),

            TD::make('title', 'Название')
                ->sort()
                ->render(function (Portfolio $work) {
                    return Link::make($work->title)
                        ->route('platform.portfolio.edit', $work);
                }),

            TD::make('client', 'Клиент')
                ->width('180px')
                ->render(function (Portfolio $work) {
                    return $work->client
                        ? e($work->client->title)
                        : '<span class="text-muted">—</span>';
                }),

            TD::make('completed_at', 'Дата выполнения')
                ->width('140px')
                ->sort()
                ->render(function (Portfolio $work) {
                    return $work->completed_at
                        ? $work->completed_at->format('d.m.Y')
                        : '<span class="text-muted">—</span>';
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
                ->render(function (Portfolio $work) {
                    return $work->created_at->format('d.m.Y');
                }),

            TD::make('actions', 'Действия')
                ->width('100px')
                ->alignRight()
                ->render(function (Portfolio $work) {
                    /** @var User|null $user */
                    $user = Auth::user();

                    $canDelete = $user?->hasAccess('platform.portfolio.delete') ?? false;

                    $actions = [
                        Link::make('Редактировать')
                            ->route('platform.portfolio.edit', $work)
                            ->icon('bs.pencil'),
                    ];

                    if ($canDelete) {
                        $actions[] = Button::make('Удалить')
                            ->icon('bs.trash')
                            ->method('remove', ['id' => $work->id])
                            ->confirm('Удалить работу "'.$work->title.'"?');
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
        return 'Нет работ в портфолио. Добавьте первую работу.';
    }

    /**
     * Get the text for the table heading.
     */
    protected function heading(): string
    {
        return 'Портфолио';
    }
}
