<?php

namespace App\Orchid\Layouts\Lead;

use App\Models\LeadStatusHistory;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class LeadStatusHistoryLayout extends Table
{
    public $target = 'status_history';

    public function columns(): array
    {
        return [
            TD::make('created_at', 'Дата')
                ->render(fn (LeadStatusHistory $history) => $history->created_at?->format('d.m.Y H:i:s') ?? '—'
                ),

            TD::make('old_status', 'Было')
                ->render(function (LeadStatusHistory $history) {
                    if ($history->old_status) {
                        $class = $history->old_status->badgeClass();

                        return '<span class="badge '.$class.'">'.$history->old_status->label().'</span>';
                    }

                    return '<span class="text-muted">—</span>';
                }),

            TD::make('new_status', 'Стало')
                ->render(function (LeadStatusHistory $history) {
                    $class = $history->new_status->badgeClass();

                    return '<span class="badge '.$class.'">'.$history->new_status->label().'</span>';
                }),

            // Исправлено: comment — обычное поле, работает напрямую
            TD::make('comment', 'Комментарий')
                ->render(fn (LeadStatusHistory $history) => $history->comment ?? '—'),

            // Исправлено: relation через render(), не dot-notation
            TD::make('created_by', 'Изменил')
                ->render(fn (LeadStatusHistory $history) => $history->creator?->name ?? 'Система'),
        ];
    }
}
