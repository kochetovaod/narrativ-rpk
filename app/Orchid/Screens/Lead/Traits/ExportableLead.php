<?php

namespace App\Orchid\Screens\Lead\Traits;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

trait ExportableLead
{
    /**
     * Export leads to CSV.
     */
    public function export(Request $request)
    {
        $query = Lead::query();

        // Фильтры
        if ($request->filled('date_range')) {
            [$start, $end] = explode(' - ', $request->date_range);
            $query->whereBetween('created_at', [$start, $end]);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $leads = $query->get();

        $filename = 'leads_export_'.date('Y-m-d_His').'.csv';
        $handle = fopen('php://temp', 'w+');

        // Заголовки
        fputcsv($handle, [
            'ID',
            'Номер заявки',
            'Дата',
            'Имя',
            'Телефон',
            'Email',
            'Тип',
            'Статус',
            'Приоритет',
            'Источник',
            'Бюджет',
        ]);

        // Данные
        foreach ($leads as $lead) {
            fputcsv($handle, [
                $lead->id,
                $lead->lead_number,
                $lead->created_at->format('d.m.Y H:i'),
                $lead->name,
                $lead->phone,
                $lead->email,
                $lead->request_type->label(),
                $lead->status->label(),
                $lead->priority->label(),
                $lead->source,
                $lead->budget_range,
            ]);
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return Response::make($content, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }
}
