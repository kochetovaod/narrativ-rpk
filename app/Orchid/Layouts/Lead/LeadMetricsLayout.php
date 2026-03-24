<?php

namespace App\Orchid\Layouts\Lead;

use App\Models\Lead;
use Orchid\Screen\Layouts\Legend;
use Orchid\Screen\Sight;

class LeadMetricsLayout extends Legend
{
    /**
     * @var string
     */
    protected $target = 'metrics';

    protected function columns(): iterable
    {
        return [
            Sight::make('total', 'Всего заявок')
                ->render(function () {
                    return number_format(Lead::count(), 0, '.', ' ');
                }),

            Sight::make('new', 'Новые')
                ->render(function () {
                    return Lead::where('status', 'new')->count();
                }),

            Sight::make('in_progress', 'В работе')
                ->render(function () {
                    return Lead::whereIn('status', ['assigned', 'in_progress', 'waiting'])->count();
                }),

            Sight::make('overdue', 'Просроченные')
                ->render(function () {
                    return Lead::requiringAttention()->count();
                }),

            Sight::make('conversion', 'Конверсия')
                ->render(function () {
                    return Lead::getConversionRate().'%';
                }),
        ];
    }
}
