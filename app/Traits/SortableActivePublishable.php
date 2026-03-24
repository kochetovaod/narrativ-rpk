<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

/**
 * Trait SortableActivePublishable
 *
 * Предоставляет функциональность для:
 * - сортировки (sort поле)
 * - активности (active поле)
 * - публикации (published_at поле)
 */
trait SortableActivePublishable
{
    /**
     * Boot the trait
     */
    public static function bootSortableActivePublishable(): void
    {
        // При создании модели устанавливаем значение sort по умолчанию
        static::creating(function ($model) {
            if (is_null($model->sort)) {
                $model->sort = $model->getNextSortValue();
            }
        });
    }

    /**
     * Get the next sort value
     */
    public function getNextSortValue(): int
    {
        return $this->query()->max('sort') + 1;
    }

    /**
     * Scope: сортировка по полю sort
     */
    public function scopeOrderBySort(Builder $query, string $direction = 'asc'): Builder
    {
        return $query->orderBy('sort', $direction);
    }

    /**
     * Scope: только активные записи
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('active', true);
    }

    /**
     * Scope: только неактивные записи
     */
    public function scopeInactive(Builder $query): Builder
    {
        return $query->where('active', false);
    }

    /**
     * Scope: только опубликованные записи (published_at <= now)
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('published_at', '<=', Carbon::now());
    }

    /**
     * Scope: только запланированные записи (published_at > now)
     */
    public function scopeScheduled(Builder $query): Builder
    {
        return $query->where('published_at', '>', Carbon::now());
    }

    /**
     * Scope: черновики (еще не опубликованы или неактивны)
     */
    public function scopeDrafts(Builder $query): Builder
    {
        return $query->where(function (Builder $q) {
            $q->where('active', false)
                ->orWhere('published_at', '>', Carbon::now())
                ->orWhereNull('published_at');
        });
    }

    /**
     * Scope: опубликованные И активные (для показа на сайте)
     */
    public function scopeVisible(Builder $query): Builder
    {
        return $query->active()->published();
    }

    /**
     * Scope: переместить запись вверх по сортировке
     */
    public function scopeMoveUp(Builder $query, int $id): bool
    {
        $current = $this->find($id);
        if (! $current) {
            return false;
        }

        $previous = $this->where('sort', '<', $current->sort)
            ->orderBy('sort', 'desc')
            ->first();

        if ($previous) {
            return $this->swapSort($current, $previous);
        }

        return false;
    }

    /**
     * Scope: переместить запись вниз по сортировке
     */
    public function scopeMoveDown(Builder $query, int $id): bool
    {
        $current = $this->find($id);
        if (! $current) {
            return false;
        }

        $next = $this->where('sort', '>', $current->sort)
            ->orderBy('sort', 'asc')
            ->first();

        if ($next) {
            return $this->swapSort($current, $next);
        }

        return false;
    }

    /**
     * Поменять местами значения sort у двух моделей
     */
    protected function swapSort($model1, $model2): bool
    {
        $tempSort = $model1->sort;
        $model1->sort = $model2->sort;
        $model2->sort = $tempSort;

        return $model1->save() && $model2->save();
    }

    /**
     * Scope: переместить на первую позицию
     */
    public function scopeMoveToFirst(Builder $query, int $id): bool
    {
        $current = $this->find($id);
        if (! $current) {
            return false;
        }

        $first = $this->orderBy('sort', 'asc')->first();

        if ($first && $first->id !== $current->id) {
            $current->sort = 0;
            $current->save();

            // Перенумеровать все записи
            $this->reorder();

            return true;
        }

        return false;
    }

    /**
     * Scope: переместить на последнюю позицию
     */
    public function scopeMoveToLast(Builder $query, int $id): bool
    {
        $current = $this->find($id);
        if (! $current) {
            return false;
        }

        $lastSort = $this->max('sort');
        $current->sort = $lastSort + 1;

        return $current->save();
    }

    /**
     * Перенумеровать все записи (для случаев, когда сортировка сбилась)
     */
    public function scopeReorder(Builder $query): void
    {
        $items = $query->orderBy('sort')->get();

        foreach ($items as $index => $item) {
            $item->sort = $index + 1;
            $item->saveQuietly(); // Без событий, чтобы избежать циклов
        }
    }

    /**
     * Scope: опубликовать сейчас (установить published_at = now)
     */
    public function scopePublishNow(Builder $query, int $id): bool
    {
        $item = $this->find($id);
        if (! $item) {
            return false;
        }

        $item->published_at = Carbon::now();
        $item->active = true;

        return $item->save();
    }

    /**
     * Scope: снять с публикации
     */
    public function scopeUnpublish(Builder $query, int $id): bool
    {
        $item = $this->find($id);
        if (! $item) {
            return false;
        }

        $item->published_at = null;
        $item->active = false;

        return $item->save();
    }

    /**
     * Проверка: опубликована ли запись
     */
    public function isPublished(): bool
    {
        return $this->published_at && $this->published_at <= Carbon::now();
    }

    /**
     * Проверка: активна ли запись
     */
    public function isActive(): bool
    {
        return $this->active === true;
    }

    /**
     * Проверка: видима ли запись на сайте
     */
    public function isVisible(): bool
    {
        return $this->isActive() && $this->isPublished();
    }

    /**
     * Проверка: запланирована ли запись
     */
    public function isScheduled(): bool
    {
        return $this->published_at && $this->published_at > Carbon::now();
    }

    /**
     * Получить статус в человекочитаемом виде
     */
    public function getStatusAttribute(): string
    {
        if (! $this->active) {
            return 'Неактивна';
        }

        if (! $this->published_at) {
            return 'Черновик';
        }

        if ($this->published_at > Carbon::now()) {
            return 'Запланирована на '.$this->published_at->format('d.m.Y H:i');
        }

        return 'Опубликована';
    }

    /**
     * Получить цвет статуса для админки
     */
    public function getStatusColorAttribute(): string
    {
        if (! $this->active) {
            return 'gray';
        }

        if (! $this->published_at) {
            return 'yellow';
        }

        if ($this->published_at > Carbon::now()) {
            return 'blue';
        }

        return 'green';
    }

    public static function scopeOrdered(Builder $query, string $direction = 'asc'): Builder
    {
        return $query->active()->published()->orderBy('sort', $direction);
    }
}
