<?php

namespace App\Orchid\Layouts\Lead;

use App\Enums\TaskStatus;
use App\Models\LeadTask;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class LeadTasksLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'tasks';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('title', 'Задача'),

            TD::make('status', 'Статус')
                ->render(function (LeadTask $task) {
                    $colors = [
                        'pending' => 'badge-secondary',
                        'in_progress' => 'badge-warning',
                        'completed' => 'badge-success',
                        'cancelled' => 'badge-danger',
                    ];
                    $color = $colors[$task->status->value] ?? 'badge-default';

                    return '<span class="badge '.$color.'">'.$task->status->label().'</span>';
                }),

            TD::make('priority', 'Приоритет')
                ->render(function (LeadTask $task) {
                    $colors = [
                        'low' => 'badge-secondary',
                        'medium' => 'badge-info',
                        'high' => 'badge-warning',
                    ];
                    $color = $colors[$task->priority->value] ?? 'badge-default';

                    return '<span class="badge '.$color.'">'.$task->priority->label().'</span>';
                }),

            TD::make('due_date', 'Срок')
                ->render(function (LeadTask $task) {
                    if (! $task->due_date) {
                        return '-';
                    }

                    $class = $task->isOverdue() ? 'text-danger' : '';

                    return '<span class="'.$class.'">'.$task->due_date->format('d.m.Y').'</span>';
                }),

            TD::make('assignedTo.name', 'Исполнитель'),

            TD::make('completed_at', 'Выполнена')
                ->render(function (LeadTask $task) {
                    return $task->completed_at?->format('d.m.Y H:i') ?? '-';
                }),

            TD::make('actions', 'Действия')
                ->render(function (LeadTask $task) {
                    if ($task->status !== TaskStatus::COMPLETED) {
                        return Button::make('Выполнить')
                            ->icon('bs.check')
                            ->method('completeTask')
                            ->parameters(['task' => $task->id])
                            ->class('btn btn-sm btn-success');
                    }

                    return '';
                }),
        ];
    }
}
