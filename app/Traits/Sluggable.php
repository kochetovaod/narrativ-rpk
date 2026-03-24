<?php

namespace App\Traits;

use Cviebrock\EloquentSluggable\Sluggable as BaseSluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

/**
 * Trait ExtendedSluggable
 *
 * Расширенная версия с поддержкой:
 * - Мягкого удаления (soft deletes)
 * - Учета локализации
 * - Кастомных правил для разных моделей
 */
trait Sluggable
{
    use BaseSluggable, SluggableScopeHelpers;

    /**
     * Boot the trait
     */
    public static function bootSluggable(): void
    {
        // При восстановлении модели после soft delete
        static::restoring(function ($model) {
            if (method_exists($model, 'needsSlugUpdate') && $model->needsSlugUpdate()) {
                $model->regenerateSlug();
            }
        });
    }

    /**
     * Конфигурация sluggable с учетом типа модели
     */
    public function sluggable(): array
    {
        $config = [
            'slug' => [
                'source' => $this->getSlugSource(),
                'onUpdate' => $this->getSlugOnUpdate(),
                'unique' => $this->getSlugUnique(),
                'maxLength' => $this->getSlugMaxLength(),
                'maxLengthKeepWords' => true,
                'method' => $this->getSlugCustomMethod(),
                'separator' => $this->getSlugSeparator(),
                'includeTrashed' => $this->getSlugIncludeTrashed(),
            ],
        ];

        // Если используется мультиязычность
        if ($this->isTranslatable()) {
            $config['slug']['source'] = $this->getTranslatableSlugSource();
        }

        return $config;
    }

    /**
     * Источник для slug (можно переопределить в модели)
     */
    protected function getSlugSource(): string|array
    {
        // По умолчанию используем title
        // Можно вернуть ['title', 'subtitle'] для комбинирования
        return 'title';
    }

    /**
     * Обновлять ли slug автоматически
     */
    protected function getSlugOnUpdate(): bool
    {
        // Для большинства моделей не обновляем автоматически
        // Но можно включить для определенных моделей
        return $this->slugOnUpdate ?? false;
    }

    /**
     * Требовать уникальности
     */
    protected function getSlugUnique(): bool
    {
        return true;
    }

    /**
     * Максимальная длина slug
     */
    protected function getSlugMaxLength(): int
    {
        return 255;
    }

    /**
     * Кастомный метод генерации
     */
    protected function getSlugCustomMethod(): ?callable
    {
        return null; // Используем встроенный метод
    }

    /**
     * Разделитель слов
     */
    protected function getSlugSeparator(): string
    {
        return '-';
    }

    /**
     * Учитывать мягко удаленные записи при проверке уникальности
     */
    protected function getSlugIncludeTrashed(): bool
    {
        // Если модель использует SoftDeletes
        if (in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($this))) {
            return true;
        }

        return false;
    }

    /**
     * Проверка на мультиязычность
     */
    protected function isTranslatable(): bool
    {
        return in_array('Spatie\Translatable\HasTranslations', class_uses($this));
    }

    /**
     * Получить URL для модели
     */
    public function getUrlAttribute(): string
    {
        // Формируем URL в зависимости от типа модели
        $route = $this->getRouteName();

        if ($route) {
            return route($route, $this->slug);
        }

        return '#';
    }

    /**
     * Имя роута для модели (можно переопределить)
     */
    protected function getRouteName(): ?string
    {
        $modelName = class_basename($this);

        return match ($modelName) {
            'Service' => 'services.show',
            'Product' => 'products.show',
            'PortfolioItem' => 'portfolio.show',
            'News' => 'news.show',
            'Page' => 'pages.show',
            default => null,
        };
    }

    /**
     * Поиск по slug с учетом типа
     */
    public function scopeFindBySlug($query, string $slug)
    {
        return $query->where('slug', $slug)
            ->where('active', true)
            ->where(function ($q) {
                $q->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            });
    }

    /**
     * Поиск по slug или fail
     */
    public function scopeFindBySlugOrFail($query, string $slug)
    {
        $model = $query->findBySlug($slug)->first();

        if (! $model) {
            abort(404, class_basename($this).' not found');
        }

        return $model;
    }
}
