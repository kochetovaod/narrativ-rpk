<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Platform\Concerns\Sortable;
use Orchid\Screen\AsSource;

class ProductCategoryFilterValue extends Model
{
    use AsSource,
        Filterable,
        HasFactory,
        Sortable;

    protected $table = 'product_category_filter_values';

    protected $fillable = [
        'filter_id',
        'value',
        'sort',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Разрешённые фильтры для Orchid
     */
    protected $allowedFilters = [
        'id' => Where::class,
        'value' => Like::class,
        'active' => Where::class,
    ];

    protected $allowedSorts = [
        'id',
        'sort',
        'value',
        'created_at',
    ];

    /**
     * Фильтр, к которому относится значение
     */
    public function filter(): BelongsTo
    {
        return $this->belongsTo(
            ProductCategoryFilter::class,
            'filter_id'
        );
    }

    /**
     * Продукты, к которым привязано значение фильтра
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'product_filter_value_product',
            'filter_value_id',
            'product_id'
        );
    }

    /**
     * Scope: только активные
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
