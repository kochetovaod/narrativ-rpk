<?php

namespace App\Orchid\Screens\Portfolio;

use App\Models\Portfolio;
use App\Orchid\Layouts\Portfolio\PortfolioListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class PortfolioListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'portfolio' => Portfolio::filters()
                ->defaultSort('sort', 'asc')
                ->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Портфолио';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Управление работами в портфолио компании';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Добавить работу')
                ->icon('bs.plus-circle')
                ->route('platform.portfolio.create'),
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
            PortfolioListLayout::class,
        ];
    }

    /**
     * Удаление работы из портфолио
     */
    public function remove(Request $request): void
    {
        Portfolio::findOrFail($request->input('id'))->delete();

        Toast::info('Работа успешно удалена из портфолио');
    }

    /**
     * Обновление сортировки через AJAX
     */
    public function updateSort(Portfolio $work, Request $request)
    {
        $request->validate([
            'sort' => 'required|integer',
        ]);

        $work->sort = $request->input('sort');
        $work->save();

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
            'platform.portfolio.view',
        ];
    }
}
