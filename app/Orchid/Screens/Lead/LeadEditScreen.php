<?php

namespace App\Orchid\Screens\Lead;

use App\Enums\LeadStatus;
use App\Models\Lead;
use App\Models\LeadTask;
use App\Orchid\Layouts\Lead\LeadEditLayout;
use App\Orchid\Layouts\Lead\LeadInfoLayout;
use App\Orchid\Layouts\Lead\LeadStatusHistoryLayout;
use App\Orchid\Layouts\Lead\LeadTaskModal;
use App\Orchid\Layouts\Lead\LeadTasksLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class LeadEditScreen extends Screen
{
    public $lead;

    public function query(Lead $lead): array
    {
        $lead->load(['statusHistory.creator', 'tasks.assignedTo', 'assignedTo', 'processedBy']);

        return [
            'lead' => $lead,
            'status_history' => $lead->statusHistory()->orderBy('created_at', 'desc')->get(),
            'tasks' => $lead->tasks()->orderBy('due_date')->get(),
        ];
    }

    public function name(): ?string
    {
        return $this->lead->exists
            ? 'Редактирование заявки #'.$this->lead->lead_number
            : 'Создание новой заявки';
    }

    public function description(): ?string
    {
        return $this->lead->exists
            ? 'Просмотр и редактирование заявки'
            : 'Создание новой заявки в CRM';
    }

    public function permission(): ?iterable
    {
        return ['platform.leads.edit'];
    }

    public function commandBar(): array
    {
        $commands = [
            Button::make('Сохранить')
                ->icon('bs.check-circle')
                ->method('save'),
        ];

        if ($this->lead->exists) {
            $commands[] = Button::make('Удалить')
                ->icon('bs.trash')
                ->method('delete')
                ->confirm('Вы уверены, что хотите удалить эту заявку?');

            if (! in_array($this->lead->status->value, ['converted', 'lost'])) {
                $commands[] = Button::make('Конвертировать в клиента')
                    ->icon('bs.person-up')
                    ->method('convertToClient')
                    ->confirm('Создать клиента на основе этой заявки?');
            }

            if ($this->lead->status->value === 'lost') {
                $commands[] = Button::make('Восстановить')
                    ->icon('bs.arrow-repeat')
                    ->method('restore');
            }
        }

        return $commands;
    }

    public function layout(): array
    {
        if ($this->lead->exists) {
            return [
                Layout::tabs([
                    'Основная информация' => [
                        LeadInfoLayout::class,
                    ],
                    'Редактирование' => [
                        LeadEditLayout::class,
                    ],
                    'История статусов' => [
                        LeadStatusHistoryLayout::class,
                    ],
                    'Задачи' => [
                        LeadTasksLayout::class,
                        Layout::rows([
                            // Исправлено: открываем модалку через ->modal(), не ->method()
                            Button::make('Добавить задачу')
                                ->icon('bs.plus')
                                ->modal('taskModal')
                                ->class('btn btn-primary mt-3'),
                        ]),
                    ],
                ]),

                // Исправлено: модалка объявляется в layout(), не открывается из метода
                Layout::modal('taskModal', LeadTaskModal::class)
                    ->title('Новая задача')
                    ->applyButton('Создать задачу'),
            ];
        }

        return [
            LeadEditLayout::class,
        ];
    }

    public function save(Request $request, Lead $lead): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validate([
            'lead.name' => 'required|string|max:255',
            'lead.phone' => 'required|string|max:20',
            'lead.email' => 'nullable|email|max:255',
            'lead.request_type' => 'required',
            'lead.status' => 'required',
            'lead.priority' => 'required',
            'lead.message' => 'nullable|string',
        ]);

        $isNew = ! $lead->exists;

        $lead->fill($data['lead'])->save();

        Toast::info($isNew ? 'Заявка успешно создана' : 'Заявка успешно обновлена');

        // Исправлено: return redirect() — без return редирект не работает в Orchid
        return $isNew
            ? redirect()->route('platform.leads.edit', $lead)
            : back();
    }

    public function delete(Lead $lead): \Illuminate\Http\RedirectResponse
    {
        $lead->delete();
        Toast::info('Заявка удалена');

        // Исправлено: return redirect()
        return redirect()->route('platform.leads.list');
    }

    public function convertToClient(Lead $lead): void
    {
        try {
            $lead->convertToClient();
            Toast::success('Заявка успешно конвертирована в клиента');
            // return redirect()->route('platform.clients.edit', $client); // раскомментить когда будет готов экран
        } catch (\Exception $e) {
            Toast::error('Ошибка при конвертации: '.$e->getMessage());
        }
    }

    public function restore(Lead $lead): void
    {
        $lead->status = LeadStatus::IN_PROGRESS;
        $lead->loss_reason = null;
        $lead->save();
        Toast::info('Заявка восстановлена');
    }

    public function completeTask(Request $request): void
    {
        // Исправлено: LeadTask передаётся через parameters(), получаем через request
        $task = LeadTask::findOrFail($request->input('task'));
        $task->complete();
        Toast::success('Задача выполнена');
    }

    public function createTask(Request $request, Lead $lead): void
    {
        $data = $request->validate([
            'task.title' => 'required|string|max:255',
            'task.description' => 'nullable|string',
            'task.priority' => 'required',
            'task.due_date' => 'nullable|date',
            'task.assigned_to' => 'nullable|integer|exists:users,id',
        ]);

        $lead->tasks()->create($data['task']);

        Toast::success('Задача добавлена');
    }
}
