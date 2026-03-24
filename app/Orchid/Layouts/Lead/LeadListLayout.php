<?php

namespace App\Orchid\Layouts\Lead;

use App\Enums\LeadPriority;
use App\Enums\LeadStatus;
use App\Enums\RequestType;
use App\Models\Lead;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\DateRange;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class LeadListLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    public $target = 'leads';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('lead_number', '№ заявки')
                ->sort()
                ->filter()
                ->render(function (Lead $lead) {
                    return Link::make($lead->lead_number)
                        ->route('platform.leads.edit', $lead);
                }),

            TD::make('created_at', 'Дата')
                ->sort()
                ->filter(DateRange::make())
                ->render(function (Lead $lead) {
                    return $lead->created_at?->format('d.m.Y H:i');
                }),

            TD::make('name', 'Клиент')
                ->sort()
                ->filter()
                ->render(function (Lead $lead) {
                    $html = '<div><strong>'.e($lead->name).'</strong></div>';
                    if ($lead->company_name) {
                        $html .= '<div><small>'.e($lead->company_name).'</small></div>';
                    }

                    return $html;
                }),

            TD::make('phone', 'Телефон')
                ->filter()
                ->render(function (Lead $lead) {
                    return $lead->phone;
                }),

            TD::make('email', 'Email')
                ->filter()
                ->render(function (Lead $lead) {
                    return $lead->email ?? '-';
                }),

            TD::make('request_type', 'Тип')
                ->filter(Select::make()->options(RequestType::options()))
                ->render(function (Lead $lead) {
                    return '<span class="badge badge-info">'.$lead->request_type->label().'</span>';
                }),

            TD::make('status', 'Статус')
                ->sort()
                ->filter(Select::make()->options(LeadStatus::options()))
                ->render(function (Lead $lead) {
                    return $lead->status_badge;
                }),

            TD::make('priority', 'Приоритет')
                ->sort()
                ->filter(Select::make()->options(LeadPriority::options()))
                ->render(function (Lead $lead) {
                    return $lead->priority_badge;
                }),

            TD::make('assigned_to', 'Менеджер')
                ->sort()
                ->filter()
                ->render(function (Lead $lead) {
                    return $lead->assignedTo?->name ?? '<span class="text-muted">Не назначен</span>';
                }),

            TD::make('source', 'Источник')
                ->filter()
                ->render(function (Lead $lead) {
                    return $lead->source ?? '-';
                }),

            TD::make('is_overdue', 'Просрочено')
                ->render(function (Lead $lead) {
                    if ($lead->is_overdue) {
                        return '<span class="badge badge-danger">Да</span>';
                    }

                    return '-';
                }),
        ];
    }

    protected function iconNotFound(): string
    {
        return 'bs.ticket';
    }

    protected function textNotFound(): string
    {
        return 'Заявки не найдены';
    }

    protected function subNotFound(): string
    {
        return 'В ближайшее время здесь появятся новые заявки';
    }
}
