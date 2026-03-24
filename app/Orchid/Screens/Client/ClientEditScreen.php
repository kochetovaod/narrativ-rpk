<?php

namespace App\Orchid\Screens\Client;

use App\Models\Client;
use App\Orchid\Layouts\Client\ClientSpecificFieldsLayout;
use App\Orchid\Layouts\Common\MainFieldsLayout;
use App\Orchid\Layouts\Common\TechnicalInfoLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class ClientEditScreen extends Screen
{
    /**
     * @var Client
     */
    public $client;

    /**
     * Query data.
     */
    public function query(Client $client): array
    {
        // Загружаем связи
        $client->load(['logo']);

        return [
            'client' => $client,
        ];
    }

    /**
     * Display header name.
     */
    public function name(): ?string
    {
        return $this->client->exists
            ? 'Редактирование клиента: '.$this->client->title
            : 'Создание клиента';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Управление клиентами компании';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Сохранить')
                ->icon('check')
                ->method('save')
                ->parameters(['redirect' => 'list'])
                ->canSee($this->client->exists)
                ->class('btn btn-success me-2'),

            Button::make('Сохранить')
                ->icon('check')
                ->method('save')
                ->parameters(['redirect' => 'list'])
                ->canSee(! $this->client->exists)
                ->class('btn btn-success'),

            Button::make('Применить')
                ->icon('reload')
                ->method('save')
                ->parameters(['redirect' => 'edit'])
                ->class('btn btn-primary me-2'),

            Button::make('Отмена')
                ->icon('close')
                ->method('cancel')
                ->confirm('Вы уверены? Несохранённые данные будут потеряны.')
                ->class('btn btn-secondary me-2'),

            Button::make('Удалить')
                ->icon('trash')
                ->method('remove')
                ->confirm('Вы уверены, что хотите удалить этого клиента?')
                ->canSee($this->client->exists)
                ->class('btn btn-danger'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            Layout::tabs([
                'Основная информация' => [
                    // Техническая информация (только для существующих записей)
                    new TechnicalInfoLayout('client')
                        ->canSee($this->client->exists),

                    // Основные поля
                    new MainFieldsLayout('client', 'Название клиента'),

                    // Специфичные поля (логотип)
                    new ClientSpecificFieldsLayout,
                ],

                // Нет вкладки "Галерея"
                // Нет вкладки "SEO"
            ]),
        ];
    }

    /**
     * Сохранение или обновление клиента
     */
    public function save(Client $client, Request $request): RedirectResponse
    {
        $redirect = $request->get('redirect', 'list');

        // Валидация
        $validatedData = $request->validate([
            'client.title' => 'required|string|max:255',
            'client.slug' => 'nullable|string|max:255|unique:clients,slug,'.$client->id,
            'client.logo_id' => 'nullable|integer|exists:attachments,id',
            'client.sort' => 'nullable|integer',
            'client.active' => 'boolean',
        ]);

        // Сохраняем основные данные
        $client->fill($request->get('client'))->save();

        Alert::success('Клиент успешно сохранён.');

        // Редирект в зависимости от кнопки
        if ($redirect === 'edit') {
            return redirect()->route('platform.clients.edit', $client);
        }

        return redirect()->route('platform.clients.list');
    }

    /**
     * Отмена редактирования
     */
    public function cancel(): RedirectResponse
    {
        return redirect()->route('platform.clients.list');
    }

    /**
     * Удаление клиента
     *
     * @throws \Exception
     */
    public function remove(Client $client): RedirectResponse
    {
        // Удаляем связанные вложения
        $client->logo()->delete();

        // Удаляем клиента
        $client->delete();

        Alert::success('Клиент успешно удалён.');

        return redirect()->route('platform.clients.list');
    }
}
