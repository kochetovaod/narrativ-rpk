<?php

namespace App\Orchid\Screens\Blog;

use App\Models\Blog;
use App\Orchid\Layouts\Blog\BlogListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class BlogListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'blogs' => Blog::filters()
                ->defaultSort('published_at', 'desc')
                ->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Новости';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Управление новостями компании';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Добавить новость')
                ->icon('bs.plus-circle')
                ->route('platform.blogs.create'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            BlogListLayout::class,
        ];
    }

    /**
     * Удаление новости
     */
    public function remove(Request $request): void
    {
        Blog::findOrFail($request->input('id'))->delete();

        Toast::info('Новость успешно удалена');
    }

    /**
     * Обновление сортировки через AJAX
     */
    public function updateSort(Blog $blog, Request $request)
    {
        $request->validate([
            'sort' => 'required|integer',
        ]);

        $blog->sort = $request->input('sort');
        $blog->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Порядок обновлен',
            ]);
        }

        Toast::info('Порядок обновлен');

        return back();
    }

    /**
     * Права доступа
     */
    public function permission(): ?array
    {
        return [
            'platform.blogs.view',
        ];
    }
}
