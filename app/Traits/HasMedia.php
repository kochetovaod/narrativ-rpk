<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Attachment\Models\Attachment;

/**
 * Trait HasMedia
 *
 * Предоставляет функциональность для работы с изображениями:
 * - preview_id - основное/превью изображение (one-to-one)
 * - detail_id - детальное изображение (one-to-one)
 * - attachments() - галерея изображений (many-to-many)
 */
trait HasMedia
{
    /**
     * Boot the trait
     */
    public static function bootHasMedia(): void
    {
        // При жестком удалении модели очищаем связи и файлы
        static::deleting(function ($model) {
            if (method_exists($model, 'isForceDeleting') && ! $model->isForceDeleting()) {
                return;
            }

            // Удаляем файлы галереи (проверка ссылок происходит внутри delete)
            $model->attachments->each->delete();

            // Удаляем preview и detail, если они есть
            if ($model->preview) {
                $model->preview->delete();
            }

            if ($model->detail) {
                $model->detail->delete();
            }
        });
    }

    /**
     * Превью изображение
     */
    public function preview(): BelongsTo
    {
        return $this->belongsTo(Attachment::class, 'preview_id')->withDefault();
    }

    /**
     * Детальное изображение
     */
    public function detail(): BelongsTo
    {
        return $this->belongsTo(Attachment::class, 'detail_id')->withDefault();
    }

    /**
     * URL превью
     */
    public function getPreviewUrlAttribute(): ?string
    {
        return $this->preview?->url();
    }

    /**
     * URL детального изображения
     */
    public function getDetailUrlAttribute(): ?string
    {
        return $this->detail?->url();
    }

    /**
     * Массив URL галереи
     */
    public function getGalleryUrlsAttribute(): array
    {
        return $this->attachments->map(fn ($attachment) => $attachment->url())->toArray();
    }

    /**
     * Проверить наличие изображений
     */
    public function hasImages(): bool
    {
        return $this->preview_id || $this->detail_id || $this->attachments()->exists();
    }

    /**
     * Синхронизировать галерею с массивом ID
     */
    public function syncGallery(array $attachmentIds, ?string $group = null): self
    {
        $syncData = [];
        foreach ($attachmentIds as $id) {
            $syncData[$id] = ['group' => $group ?? 'gallery'];
        }

        $this->attachments()->sync($syncData);

        return $this;
    }

    /**
     * Загрузить все изображения
     */
    public function scopeWithImages($query)
    {
        return $query->with(['preview', 'detail', 'attachments']);
    }

    /**
     * Только модели с превью
     */
    public function scopeHasPreview($query)
    {
        return $query->whereNotNull('preview_id');
    }

    /**
     * Только модели с детальным изображением
     */
    public function scopeHasDetail($query)
    {
        return $query->whereNotNull('detail_id');
    }

    /**
     * Только модели с галереей
     */
    public function scopeHasGallery($query)
    {
        return $query->whereHas('attachments');
    }
}
