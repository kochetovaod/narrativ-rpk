<?php

namespace App\Orchid\Screens\Equipment;

use App\Models\Equipment;
use App\Orchid\Layouts\Common\DetailTabLayout;
use App\Orchid\Layouts\Common\MainFieldsLayout;
use App\Orchid\Layouts\Common\PreviewTabLayout;
use App\Orchid\Layouts\Common\TechnicalInfoLayout;
use App\Orchid\Layouts\Equipment\EquipmentSpecificFieldsLayout;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class EquipmentEditScreen extends Screen
{
    /**
     * @var Equipment
     */
    public $equipment;

    /**
     * Query data.
     */
    public function query(Equipment $equipment): array
    {
        // Загружаем связи
        $equipment->load(['preview', 'detail']);

        return [
            'equipment' => $equipment,
        ];
    }

    /**
     * Display header name.
     */
    public function name(): ?string
    {
        return $this->equipment->exists
            ? 'Редактирование оборудования: '.$this->equipment->title
            : 'Создание оборудования';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Управление оборудованием компании';
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
                ->canSee($this->equipment->exists)
                ->class('btn btn-success me-2'),

            Button::make('Сохранить')
                ->icon('check')
                ->method('save')
                ->parameters(['redirect' => 'list'])
                ->canSee(! $this->equipment->exists)
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
                ->confirm('Вы уверены, что хотите удалить это оборудование?')
                ->canSee($this->equipment->exists)
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
                    new TechnicalInfoLayout('equipment')
                        ->canSee($this->equipment->exists),

                    // Основные поля
                    new MainFieldsLayout('equipment', 'Название оборудования'),

                    // Специфичные поля
                    new EquipmentSpecificFieldsLayout,
                ],

                'Анонс' => [
                    new PreviewTabLayout('equipment', 800, 600),
                ],

                'Подробно' => [
                    new DetailTabLayout('equipment', 1200, 800),
                ],

                // Нет вкладки "Галерея"
                // Нет вкладки "SEO"
            ]),
        ];
    }

    /**
     * Сохранение или обновление оборудования
     */
    public function save(Equipment $equipment, Request $request): RedirectResponse
    {
        $redirect = $request->get('redirect', 'list');

        // Валидация
        $validatedData = $request->validate([
            'equipment.title' => 'required|string|max:255',
            'equipment.content' => 'nullable|string',
            'equipment.preview_id' => 'nullable|integer|exists:attachments,id',
            'equipment.detail_id' => 'nullable|integer|exists:attachments,id',
            'equipment.sort' => 'nullable|integer',
            'equipment.active' => 'boolean',
        ]);

        // Сохраняем основные данные
        $equipment->fill($request->get('equipment'))->save();

        Alert::success('Оборудование успешно сохранено.');

        // Редирект в зависимости от кнопки
        if ($redirect === 'edit') {
            return redirect()->route('platform.equipment.edit', $equipment);
        }

        return redirect()->route('platform.equipment.list');
    }

    /**
     * Отмена редактирования
     */
    public function cancel(): RedirectResponse
    {
        return redirect()->route('platform.equipment.list');
    }

    /**
     * Удаление оборудования
     *
     * @throws \Exception
     */
    public function remove(Equipment $equipment): RedirectResponse
    {
        // Удаляем связанные вложения
        $equipment->preview()->delete();
        $equipment->detail()->delete();

        // Удаляем оборудование
        $equipment->delete();

        Alert::success('Оборудование успешно удалено.');

        return redirect()->route('platform.equipment.list');
    }
}
