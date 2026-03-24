<?php

namespace App\Traits;

use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

/**
 * Trait HasContent
 *
 * Предоставляет функциональность для работы с полями:
 * - excerpt - краткое описание (text)
 * - content - подробное описание (longText)
 *
 * @property string|null $excerpt
 * @property string|null $content
 */
trait HasContent
{
    /**
     * Boot the trait
     */
    public static function bootHasContent(): void
    {
        // При создании модели, если нет краткого описания, генерируем из контента
        static::creating(function ($model) {
            if (empty($model->excerpt) && ! empty($model->content)) {
                $model->excerpt = $model->generateExcerptFromContent();
            }
        });

        // При обновлении, если контент изменился, а excerpt не указан явно, обновляем
        static::updating(function ($model) {
            if ($model->isDirty('content') && ! $model->isDirty('excerpt')) {
                $model->excerpt = $model->generateExcerptFromContent();
            }
        });
    }

    /**
     * Получить краткое описание
     */
    public function getExcerptAttribute(): ?string
    {
        return $this->attributes['excerpt'] ?? null;
    }

    /**
     * Получить подробное описание
     */
    public function getContentAttribute(): ?string
    {
        return $this->attributes['content'] ?? null;
    }

    /**
     * Получить подробное описание с HTML (без экранирования)
     */
    public function getContentHtmlAttribute(): HtmlString
    {
        return new HtmlString($this->content ?? '');
    }

    /**
     * Получить краткое описание с HTML (без экранирования)
     */
    public function getExcerptHtmlAttribute(): HtmlString
    {
        return new HtmlString($this->excerpt ?? '');
    }

    /**
     * Проверить, есть ли контент
     */
    public function hasContent(): bool
    {
        return ! empty($this->content);
    }

    /**
     * Проверить, есть ли краткое описание
     */
    public function hasExcerpt(): bool
    {
        return ! empty($this->excerpt);
    }

    /**
     * Сгенерировать краткое описание из контента
     */
    public function generateExcerptFromContent(int $length = 200): string
    {
        if (empty($this->content)) {
            return '';
        }

        // Удаляем HTML-теги
        $text = strip_tags($this->content);

        // Удаляем лишние пробелы
        $text = preg_replace('/\s+/', ' ', $text);

        // Обрезаем до нужной длины
        return Str::limit($text, $length);
    }

    /**
     * Обновить краткое описание из контента
     */
    public function refreshExcerpt(int $length = 200): self
    {
        $this->excerpt = $this->generateExcerptFromContent($length);
        $this->saveQuietly();

        return $this;
    }

    /**
     * Получить краткое описание ограниченной длины
     */
    public function getExcerptPreview(int $length = 100): string
    {
        if (empty($this->excerpt)) {
            return '';
        }

        return Str::limit(strip_tags($this->excerpt), $length);
    }

    /**
     * Получить контент без HTML-тегов
     */
    public function getPlainContentAttribute(): string
    {
        if (empty($this->content)) {
            return '';
        }

        return strip_tags($this->content);
    }

    /**
     * Поиск по контенту (для полнотекстового поиска)
     */
    public function scopeSearchInContent($query, string $searchTerm)
    {
        return $query->where(function ($q) use ($searchTerm) {
            $q->where('content', 'LIKE', "%{$searchTerm}%")
                ->orWhere('excerpt', 'LIKE', "%{$searchTerm}%");
        });
    }

    /**
     * Получить модели с непустым контентом
     */
    public function scopeHasFullContent($query)
    {
        return $query->whereNotNull('content')->where('content', '!=', '');
    }

    /**
     * Получить модели с непустым кратким описанием
     */
    public function scopeHasExcerpt($query)
    {
        return $query->whereNotNull('excerpt')->where('excerpt', '!=', '');
    }

    /**
     * Получить первое изображение из контента (для превью)
     */
    public function getFirstImageFromContent(): ?string
    {
        if (empty($this->content)) {
            return null;
        }

        preg_match('/<img[^>]+src="([^">]+)"/', $this->content, $matches);

        return $matches[1] ?? null;
    }
}
