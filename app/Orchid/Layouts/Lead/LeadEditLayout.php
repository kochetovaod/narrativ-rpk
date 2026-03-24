<?php

namespace App\Orchid\Layouts\Lead;

use App\Enums\LeadPriority;
use App\Enums\LeadStatus;
use App\Enums\PreferredContact;
use App\Enums\RequestType;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class LeadEditLayout extends Rows
{
    public function fields(): array
    {
        return [
            Group::make([
                Input::make('lead.lead_number')
                    ->title('Номер заявки')
                    ->placeholder('LEAD-2024-0001')
                    ->help('Уникальный номер заявки')
                    ->readonly(),

                // Исправлено: убран [option] — Orchid сам маппит enum/array
                Select::make('lead.status[]')
                    ->title('Статус')
                    ->options(LeadStatus::options())
                    ->required(),
            ]),

            Group::make([
                Select::make('lead.priority[]')
                    ->title('Приоритет')
                    ->options(LeadPriority::options())
                    ->required(),

                Select::make('lead.request_type[]')
                    ->title('Тип заявки')
                    ->options(RequestType::options())
                    ->required(),
            ]),

            Group::make([
                Input::make('lead.name')
                    ->title('Имя')
                    ->placeholder('Иванов Иван')
                    ->required(),

                Input::make('lead.phone')
                    ->title('Телефон')
                    ->placeholder('+7 (999) 123-45-67')
                    ->mask('+7 (999) 999-99-99')
                    ->required(),
            ]),

            Group::make([
                Input::make('lead.email')
                    ->title('Email')
                    ->placeholder('client@example.com')
                    ->type('email'),

                Select::make('lead.preferred_contact[]')
                    ->title('Предпочтительный способ связи')
                    ->options(PreferredContact::options()),
            ]),

            Group::make([
                Input::make('lead.company_name')
                    ->title('Компания')
                    ->placeholder('ООО "Нарратив"'),

                Input::make('lead.position')
                    ->title('Должность')
                    ->placeholder('Менеджер по рекламе'),
            ]),

            Group::make([
                Input::make('lead.telegram')
                    ->title('Telegram')
                    ->placeholder('@username'),

                Input::make('lead.whatsapp')
                    ->title('WhatsApp')
                    ->placeholder('+7 (999) 999-99-99'),
            ]),

            Group::make([
                Input::make('lead.service_type')
                    ->title('Услуга/продукт')
                    ->placeholder('Наружная реклама'),

                Input::make('lead.source')
                    ->title('Источник')
                    ->placeholder('website'),
            ]),

            Group::make([
                Input::make('lead.campaign')
                    ->title('Кампания')
                    ->placeholder('brand'),

                Input::make('lead.call_attempts')
                    ->title('Попытки звонков')
                    ->type('number'),
            ]),

            TextArea::make('lead.message')
                ->title('Сообщение')
                ->rows(3)
                ->placeholder('Описание задачи или вопрос'),

            Group::make([
                Input::make('lead.budget_from')
                    ->title('Бюджет от')
                    ->type('number')
                    ->mask(['alias' => 'numeric', 'groupSeparator' => ' ', 'autoGroup' => true]),

                Input::make('lead.budget_to')
                    ->title('Бюджет до')
                    ->type('number')
                    ->mask(['alias' => 'numeric', 'groupSeparator' => ' ', 'autoGroup' => true]),
            ]),

            Group::make([
                DateTimer::make('lead.desired_date')
                    ->title('Желаемая дата')
                    ->allowInput(),

                DateTimer::make('lead.desired_time')
                    ->title('Желаемое время')
                    ->enableTime()
                    ->noCalendar()
                    ->format('H:i'),
            ]),

            Group::make([
                Relation::make('lead.assigned_to')
                    ->title('Ответственный менеджер')
                    ->fromModel(\App\Models\User::class, 'name'),

                Relation::make('lead.processed_by')
                    ->title('Обработал')
                    ->fromModel(\App\Models\User::class, 'name'),
            ]),

            Group::make([
                DateTimer::make('lead.assigned_at')
                    ->title('Дата назначения')
                    ->enableTime()
                    ->format('Y-m-d H:i:s'),

                DateTimer::make('lead.processed_at')
                    ->title('Дата обработки')
                    ->enableTime()
                    ->format('Y-m-d H:i:s'),
            ]),

            Group::make([
                DateTimer::make('lead.called_at')
                    ->title('Последний звонок')
                    ->enableTime()
                    ->format('Y-m-d H:i:s'),

                DateTimer::make('lead.next_call_at')
                    ->title('Следующий звонок')
                    ->enableTime()
                    ->format('Y-m-d H:i:s'),
            ]),

            TextArea::make('lead.manager_notes')
                ->title('Заметки менеджера')
                ->rows(5),

            // Исправлено: сравниваем ->value строки, не enum-объект
            TextArea::make('lead.loss_reason')
                ->title('Причина проигрыша')
                ->rows(2)
                ->canSee($this->query->get('lead')?->status?->value === 'lost'),
        ];
    }
}
