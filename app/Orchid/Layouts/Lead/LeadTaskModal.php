<?php

namespace App\Orchid\Layouts\Lead;

use App\Enums\TaskPriority;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class LeadTaskModal extends Rows
{
    public function fields(): array
    {
        return [
            Input::make('task.title')
                ->title('Название задачи')
                ->required(),

            TextArea::make('task.description')
                ->title('Описание')
                ->rows(3),

            Select::make('task.priority')
                ->title('Приоритет')
                ->options(TaskPriority::options())
                ->value('medium'),

            DateTimer::make('task.due_date')
                ->title('Срок выполнения')
                ->allowInput(),

            Relation::make('task.assigned_to')
                ->title('Исполнитель')
                ->fromModel(\App\Models\User::class, 'name'),
        ];
    }
}
