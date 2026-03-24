<?php

namespace App\Orchid\Layouts\Client;

use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Orchid\Platform\Models\User;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ClientListLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    protected $target = 'clients';

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

            TD::make('logo', 'Логотип')
                ->width('80px')
                ->render(function (Client $client) {
                    if ($client->logo && $client->logo->url()) {
                        return "<img src='{$client->logo->url()}' alt='Логотип' class='img-fluid' style='max-width: 60px; height: auto; border-radius: 4px;'>";
                    }

                    return '<span class="text-muted">—</span>';
                }),

            TD::make('title', 'Название')
                ->sort()
                ->render(function (Client $client) {
                    return Link::make($client->title)
                        ->route('platform.clients.edit', $client);
                }),

            TD::make('slug', 'Slug')
                ->width('200px')
                ->render(function (Client $client) {
                    return "<span class='text-muted'>{$client->slug}</span>";
                }),

            TD::make('works_count', 'Работ в портфолио')
                ->width('140px')
                ->render(function (Client $client) {
                    $count = $client->portfolioWorks()->count();

                    return $count > 0
                        ? "<a href='".route('platform.portfolio.list', ['client' => $client->id])."' class='badge bg-info'>{$count}</a>"
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
                ->render(function (Client $client) {
                    return $client->created_at->format('d.m.Y');
                }),

            TD::make('actions', 'Действия')
                ->width('100px')
                ->alignRight()
                ->render(function (Client $client) {
                    /** @var User|null $user */
                    $user = Auth::user();

                    $canDelete = $user?->hasAccess('platform.clients.delete') ?? false;

                    $actions = [
                        Link::make('Редактировать')
                            ->route('platform.clients.edit', $client)
                            ->icon('bs.pencil'),
                    ];

                    if ($canDelete) {
                        $actions[] = Button::make('Удалить')
                            ->icon('bs.trash')
                            ->method('remove', ['id' => $client->id])
                            ->confirm('Удалить клиента "'.$client->title.'"?');
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
        return 'Нет клиентов. Добавьте первого клиента.';
    }

    /**
     * Get the text for the table heading.
     */
    protected function heading(): string
    {
        return 'Клиенты';
    }
}
