<?php

namespace App\Orchid\Layouts\Common;

use Orchid\Screen\Layouts\Legend;
use Orchid\Screen\Sight;

class TechnicalInfoLayout extends Legend
{
    protected string $prefix;

    public function __construct(string $prefix = 'entity')
    {
        $this->prefix = $prefix;
        $this->target = $prefix;
    }

    protected function columns(): array
    {
        return [
            Sight::make('id', 'ID')
                ->render(fn ($entity) => $entity->id ?? '—'),

            Sight::make('created_at', 'Создано')
                ->render(function ($entity) {
                    if (! $entity) {
                        return '—';
                    }

                    $creatorName = $entity->creator->name ?? 'Система';
                    $createdAt = $entity->created_at
                        ? $entity->created_at->format('d.m.Y H:i')
                        : '—';

                    return sprintf('%s <small class="text-muted">%s</small>',
                        e($creatorName),
                        e($createdAt)
                    );
                }),

            Sight::make('updated_at', 'Изменено')
                ->render(function ($entity) {
                    if (! $entity) {
                        return '—';
                    }

                    // Если запись не изменялась
                    if (! $entity->editor && $entity->created_at && $entity->creator) {
                        $editorName = $entity->creator->name ?? 'Система';
                        $updatedAt = $entity->created_at->format('d.m.Y H:i');
                    } else {
                        $editorName = $entity->editor->name ?? 'Система';
                        $updatedAt = $entity->updated_at
                            ? $entity->updated_at->format('d.m.Y H:i')
                            : '—';
                    }

                    return sprintf('%s <small class="text-muted">%s</small>',
                        e($editorName),
                        e($updatedAt)
                    );
                }),
        ];
    }
}
