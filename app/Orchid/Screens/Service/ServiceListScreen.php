<?php

namespace App\Orchid\Screens\Service;

use App\Models\Service;
use App\Orchid\Layouts\Service\ServiceListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class ServiceListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'services' => Service::filters()
                ->defaultSort('sort', 'asc')
                ->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Услуги';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Управление списком услуг компании';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Добавить услугу')
                ->icon('bs.plus-circle')
                ->route('platform.services.create'),
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
            ServiceListLayout::class,
        ];
    }

    /**
     * Удаление услуги
     */
    public function remove(Request $request): void
    {
        Service::findOrFail($request->get('id'))->delete();

        Toast::info('Услуга успешно удалена');
    }

    /**
     * Обновление сортировки через AJAX
     */
    public function updateSort(Service $service, Request $request)
    {
        $request->validate([
            'sort' => 'required|integer',
        ]);

        $service->sort = $request->input('sort');
        $service->save();

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
            'platform.services.view',
        ];
    }
}
