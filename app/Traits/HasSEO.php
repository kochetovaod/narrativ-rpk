<?php

namespace App\Traits;

use App\Models\SEO;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasSEO
{
    /**
     * Отношение SEO
     */
    public function seo(): MorphOne
    {
        return $this->morphOne(SEO::class, 'seoable');
    }

    /**
     * Получить или создать SEO запись
     */
    public function getSEOData(): SEO
    {
        return $this->seo ?? $this->seo()->create($this->getDefaultSEOData());
    }

    /**
     * Обновить SEO данные
     */
    public function updateSEO(array $data): SEO
    {
        if ($this->seo) {
            $this->seo()->update($data);

            return $this->seo->fresh();
        }

        return $this->seo()->create($data);
    }

    /**
     * Получить данные SEO по умолчанию
     * Можно переопределить в модели
     */
    protected function getDefaultSEOData(): array
    {
        return [
            'title' => $this->title ?? $this->name ?? null,
            'description' => $this->description ?? $this->excerpt ?? null,
            'robots' => 'index, follow',
        ];
    }

    /**
     * Установить SEO данные по умолчанию
     */
    public function setDefaultSEO(): void
    {
        if (! $this->seo) {
            $this->seo()->create($this->getDefaultSEOData());
        }
    }

    /**
     * Применить SEO к SEOTools (для вывода в шаблоне)
     */
    public function applySEO(?string $url = null): void
    {
        $seo = $this->getSEOData();

        // SEOMeta
        if ($seo->title) {
            SEOMeta::setTitle($seo->title);
        }

        if ($seo->description) {
            SEOMeta::setDescription($seo->description);
        }

        if ($seo->keywords) {
            SEOMeta::setKeywords($seo->keywords_array);
        }

        if ($seo->robots) {
            SEOMeta::setRobots($seo->robots);
        }

        if ($seo->canonical_url) {
            SEOMeta::setCanonical($seo->canonical_url);
        } elseif ($url) {
            SEOMeta::setCanonical($url);
        }

        // OpenGraph
        if ($seo->og_title) {
            OpenGraph::setTitle($seo->og_title);
        }

        if ($seo->og_description) {
            OpenGraph::setDescription($seo->og_description);
        }

        if ($url) {
            OpenGraph::setUrl($url);
        }

        if ($seo->og_image_url) {
            OpenGraph::addImage($seo->og_image_url);
        }

        OpenGraph::addProperty('type', $this->getOpenGraphType());

        // Twitter Card
        if ($seo->og_title) {
            TwitterCard::setTitle($seo->og_title);
        }

        if ($seo->og_description) {
            TwitterCard::setDescription($seo->og_description);
        }

        if ($seo->og_image_url) {
            TwitterCard::setImage($seo->og_image_url);
        }

        TwitterCard::setType($this->getTwitterCardType());

        // JsonLd
        if ($seo->title) {
            JsonLd::setTitle($seo->title);
        }

        if ($seo->description) {
            JsonLd::setDescription($seo->description);
        }

        if ($seo->og_image_url) {
            JsonLd::addImage($seo->og_image_url);
        }

        JsonLd::setType($this->getJsonLdType());
    }

    /**
     * Получить тип для Open Graph
     * Можно переопределить в модели
     */
    protected function getOpenGraphType(): string
    {
        return 'website';
    }

    /**
     * Получить тип для Twitter Card
     * Можно переопределить в модели
     */
    protected function getTwitterCardType(): string
    {
        return 'summary_large_image';
    }

    /**
     * Получить тип для JSON-LD
     * Можно переопределить в модели
     */
    protected function getJsonLdType(): string
    {
        return 'WebPage';
    }

    /**
     * Boot трейта
     */
    public static function bootHasSEO(): void
    {
        static::created(function ($model) {
            if (method_exists($model, 'shouldAutoCreateSEO') && ! $model->shouldAutoCreateSEO()) {
                return;
            }

            $model->setDefaultSEO();
        });
    }
}
