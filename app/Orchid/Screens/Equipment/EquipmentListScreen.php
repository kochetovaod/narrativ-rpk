<?php

namespace App\Orchid\Screens\Equipment;

use App\Models\Equipment;
use App\Orchid\Layouts\Equipment\EquipmentListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class EquipmentListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'equipment' => Equipment::filters()
                ->defaultSort('sort', 'asc')
                ->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Оборудование';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Управление оборудованием компании';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Добавить оборудование')
                ->icon('bs.plus-circle')
                ->route('platform.equipment.create'),
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
            EquipmentListLayout::class,
        ];
    }

    /**
     * Удаление оборудования
     */
    public function remove(Request $request): void
    {
        Equipment::findOrFail($request->get('id'))->delete();

        Toast::info('Оборудование успешно удалено');
    }

    /**
     * Обновление сортировки через AJAX
     */
    public function updateSort(Equipment $item, Request $request)
    {
        $request->validate([
            'sort' => 'required|integer',
        ]);

        $item->sort = $request->input('sort');
        $item->save();

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
            'platform.equipment.view',
        ];
    }
}
