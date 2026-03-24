<?php

namespace App\Orchid\Layouts\Blog;

use App\Models\Blog;
use Illuminate\Support\Facades\Auth;
use Orchid\Platform\Models\User;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class BlogListLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    protected $target = 'blogs';

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
                ->render(function (Blog $blog) {
                    if ($blog->preview && $blog->preview->url()) {
                        return "<img src='{$blog->preview->url()}' alt='Превью' class='img-fluid' style='max-width: 60px; height: auto; border-radius: 4px;'>";
                    }

                    return '<span class="text-muted">—</span>';
                }),

            TD::make('title', 'Название')
                ->sort()
                ->render(function (Blog $blog) {
                    return Link::make($blog->title)
                        ->route('platform.blogs.edit', $blog);
                }),

            TD::make('published_at', 'Дата публикации')
                ->width('140px')
                ->sort()
                ->render(function (Blog $blog) {
                    if (! $blog->published_at) {
                        return '<span class="text-muted">Не опубликовано</span>';
                    }

                    $formatted = $blog->published_at->format('d.m.Y H:i');
                    $badge = $blog->is_published
                        ? '<span class="badge bg-success">Опубликовано</span>'
                        : '<span class="badge bg-warning">Запланировано</span>';

                    return "{$formatted}<br>{$badge}";
                }),

            TD::make('active', 'Статус')
                ->width('100px')
                ->sort()
                ->render(function (Blog $blog) {
                    if ($blog->active) {
                        return '<span class="text-success">Активна</span>';
                    }

                    return '<span class="text-danger">Черновик</span>';
                }),

            TD::make('sort', 'Порядок')
                ->width('100px')
                ->sort(),

            TD::make('created_at', 'Дата создания')
                ->width('120px')
                ->sort()
                ->render(function (Blog $blog) {
                    return $blog->created_at->format('d.m.Y');
                }),

            TD::make('actions', 'Действия')
                ->width('100px')
                ->alignRight()
                ->render(function (Blog $blog) {
                    /** @var User|null $user */
                    $user = Auth::user();

                    $canDelete = $user?->hasAccess('platform.blogs.delete') ?? false;

                    $actions = [
                        Link::make('Редактировать')
                            ->route('platform.blogs.edit', $blog)
                            ->icon('bs.pencil'),
                    ];

                    if ($canDelete) {
                        $actions[] = Button::make('Удалить')
                            ->icon('bs.trash')
                            ->method('remove', ['id' => $blog->id])
                            ->confirm('Удалить новость "'.$blog->title.'"?');
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
        return 'Нет новостей. Добавьте первую новость.';
    }

    /**
     * Get the text for the table heading.
     */
    protected function heading(): string
    {
        return 'Новости';
    }
}
