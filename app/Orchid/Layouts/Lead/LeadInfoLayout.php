<?php

namespace App\Orchid\Layouts\Lead;

use App\Models\Lead;
use Orchid\Screen\Layouts\Legend;
use Orchid\Screen\Sight;

class LeadInfoLayout extends Legend
{
    protected $target = 'lead';

    protected function columns(): iterable
    {
        return [
            Sight::make('lead_number', 'Номер заявки'),

            Sight::make('created_at', 'Создана')
                ->render(fn (Lead $lead) => $lead->created_at?->format('d.m.Y H:i:s') ?? '—'),

            Sight::make('name', 'Клиент'),

            Sight::make('phone', 'Телефон'),

            Sight::make('email', 'Email'),

            Sight::make('company_name', 'Компания'),

            Sight::make('position', 'Должность'),

            Sight::make('request_type', 'Тип заявки')
                ->render(fn (Lead $lead) => $lead->request_type?->label() ?? '—'),

            Sight::make('service_type', 'Услуга/продукт'),

            // Исправлено: render возвращает HTML-строку из атрибута модели
            Sight::make('status', 'Статус')
                ->render(fn (Lead $lead) => $lead->status_badge),

            Sight::make('priority', 'Приоритет')
                ->render(fn (Lead $lead) => $lead->priority_badge),

            // Исправлено: используем accessor напрямую
            Sight::make('budget_range', 'Бюджет')
                ->render(fn (Lead $lead) => $lead->budget_range ?? '—'),

            Sight::make('source', 'Источник'),

            Sight::make('campaign', 'Кампания'),

            // Исправлено: relation-поля через render, не dot-notation в Legend
            Sight::make('assigned_to', 'Ответственный')
                ->render(fn (Lead $lead) => $lead->assignedTo?->name ?? '—'),

            Sight::make('processed_by', 'Обработал')
                ->render(fn (Lead $lead) => $lead->processedBy?->name ?? '—'),

            Sight::make('response_deadline', 'Дедлайн реакции')
                ->render(fn (Lead $lead) => $lead->response_deadline?->format('d.m.Y H:i') ?? '—'),

            Sight::make('is_overdue', 'Просрочено')
                ->render(function (Lead $lead) {
                    if ($lead->is_overdue) {
                        return '<span class="badge badge-danger">Да</span>';
                    }

                    return '<span class="badge badge-success">Нет</span>';
                }),
        ];
    }
}
