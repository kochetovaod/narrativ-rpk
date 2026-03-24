<?php

namespace App\Orchid\Screens\Client;

use App\Models\Client;
use App\Orchid\Layouts\Client\ClientListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class ClientListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'clients' => Client::filters()
                ->defaultSort('sort', 'asc')
                ->paginate(20),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Клиенты';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Управление клиентами компании';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Добавить клиента')
                ->icon('bs.plus-circle')
                ->route('platform.clients.create'),
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
            ClientListLayout::class,
        ];
    }

    /**
     * Удаление клиента
     */
    public function remove(Request $request): void
    {
        Client::findOrFail($request->get('id'))->delete();

        Toast::info('Клиент успешно удалён');
    }

    /**
     * Обновление сортировки через AJAX
     */
    public function updateSort(Client $client, Request $request)
    {
        $request->validate([
            'sort' => 'required|integer',
        ]);

        $client->sort = $request->input('sort');
        $client->save();

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
            'platform.clients.view',
        ];
    }
}
