<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Orchid\Attachment\Models\Attachment;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class SEO extends Model
{
    use AsSource,
        Filterable,
        HasFactory;

    protected $table = 'seo';

    protected $fillable = [
        'title',
        'description',
        'keywords',
        'og_title',
        'og_description',
        'og_image_id',
        'canonical_url',
        'robots',
        'seoable_type',
        'seoable_id',
    ];

    protected $casts = [
        'og_image_id' => 'integer',
    ];

    protected $append = [
        'og_image_url',
    ];

    /**
     * Получить связанную модель
     */
    public function seoable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Получить OG изображение
     */
    public function ogImage(): HasOne
    {
        return $this->hasOne(Attachment::class, 'id', 'og_image_id')->withDefault();
    }

    /**
     * Получить URL OG изображения
     */
    public function getOgImageUrlAttribute(): ?string
    {
        return $this->ogImage ? $this->ogImage->url : null;
    }

    /**
     * Получить keywords как массив
     */
    public function getKeywordsArrayAttribute(): array
    {
        if (empty($this->keywords)) {
            return [];
        }

        return array_map('trim', explode(',', $this->keywords));
    }

    /**
     * Получить title с fallback
     */
    public function getTitleAttribute($value): ?string
    {
        return $value ?? $this->seoable?->title ?? $this->seoable?->name;
    }

    /**
     * Получить description с fallback
     */
    public function getDescriptionAttribute($value): ?string
    {
        return $value ?? $this->seoable?->description ?? $this->seoable?->excerpt;
    }

    /**
     * Получить OG title с fallback
     */
    public function getOgTitleAttribute($value): ?string
    {
        return $value ?? $this->title;
    }

    /**
     * Получить OG description с fallback
     */
    public function getOgDescriptionAttribute($value): ?string
    {
        return $value ?? $this->description;
    }
}
