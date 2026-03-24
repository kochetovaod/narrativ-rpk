<?php

namespace App\Orchid\Screens\Lead;

use App\Models\Lead;
use App\Orchid\Layouts\Lead\LeadListLayout;
use App\Orchid\Layouts\Lead\LeadMetricsLayout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;

class LeadListScreen extends Screen
{
    /**
     * @var string
     */
    public $name = 'Управление заявками';

    /**
     * @var string
     */
    public $description = 'CRM - все входящие заявки и лиды';

    /**
     * @var array
     */
    public $permission = 'platform.leads.list';

    /**
     * Query data.
     */
    public function query(): array
    {
        return [
            'metrics' => [
                'total' => Lead::count(),
                'new' => Lead::where('status', 'new')->count(),
                'in_progress' => Lead::whereIn('status', ['assigned', 'in_progress', 'waiting'])->count(),
                'overdue' => Lead::requiringAttention()->count(),
                'conversion' => Lead::getConversionRate(),
            ],
            'leads' => Lead::with(['assignedTo', 'processedBy'])
                ->filters()
                ->defaultSort('created_at', 'desc')
                ->paginate(),
        ];
    }

    /**
     * Button commands.
     */
    public function commandBar(): array
    {
        return [
            Link::make('Создать заявку')
                ->icon('bs.plus')
                ->route('platform.leads.create'),

            Link::make('Экспорт')
                ->icon('bs.download')
                ->route('platform.leads.export'),
        ];
    }

    /**
     * Views.
     */
    public function layout(): array
    {
        return [
            LeadMetricsLayout::class,
            LeadListLayout::class,
        ];
    }

    /**
     * Export leads to CSV.
     */
    public function export(Request $request)
    {
        $query = Lead::query();

        // Применяем фильтры из запроса
        if ($request->filled('filter')) {
            foreach ($request->filter as $field => $value) {
                if ($value) {
                    $query->where($field, 'LIKE', "%{$value}%");
                }
            }
        }

        // Фильтр по дате
        if ($request->filled('created_at')) {
            [$start, $end] = explode(' - ', $request->created_at);
            $query->whereBetween('created_at', [$start, $end]);
        }

        $leads = $query->get();

        $filename = 'leads_export_'.date('Y-m-d_His').'.csv';
        $handle = fopen('php://temp', 'w+');

        // Заголовки CSV (BOM для UTF-8)
        fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

        fputcsv($handle, [
            'ID',
            'Номер заявки',
            'Дата создания',
            'Имя',
            'Телефон',
            'Email',
            'Компания',
            'Тип заявки',
            'Статус',
            'Приоритет',
            'Источник',
            'Бюджет',
            'Сообщение',
            'Ответственный',
        ], ';'); // Используем точку с запятой как разделитель для Excel

        // Данные
        foreach ($leads as $lead) {
            fputcsv($handle, [
                $lead->id,
                $lead->lead_number,
                $lead->created_at?->format('d.m.Y H:i'),
                $lead->name,
                $lead->phone,
                $lead->email ?? '',
                $lead->company_name ?? '',
                $lead->request_type?->label() ?? '',
                $lead->status?->label() ?? '',
                $lead->priority?->label() ?? '',
                $lead->source ?? '',
                $lead->budget_range ?? '',
                $lead->message ?? '',
                $lead->assignedTo?->name ?? '',
            ], ';');
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return Response::make($content, 200, [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }
}
