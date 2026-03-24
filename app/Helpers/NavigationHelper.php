<?php

namespace App\Helpers;

use App\Models\ProductCategory;
use App\Models\Service;
use Illuminate\Support\Facades\Cache;

class NavigationHelper
{
    /**
     * Получить список услуг с кэшированием
     */
    public static function getServices()
    {
        return Cache::remember('navigation.services', 3600, function () {
            return Service::query()
                ->orderBy('sort', 'asc')
                ->orderBy('title', 'asc')
                ->get(['id', 'title', 'slug']);
        });
    }

    /**
     * Получить список категорий продукции с кэшированием
     */
    public static function getProductCategories()
    {
        return Cache::remember('navigation.categories', 3600, function () {
            return ProductCategory::query()
                ->orderBy('title', 'asc')
                ->get(['id', 'title', 'slug']);
        });
    }

    /**
     * Очистить кэш навигации
     */
    public static function clearCache()
    {
        Cache::forget('navigation.services');
        Cache::forget('navigation.categories');
    }
}
