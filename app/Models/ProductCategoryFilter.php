<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Platform\Concerns\Sortable;
use Orchid\Screen\AsSource;

class ProductCategoryFilter extends Model
{
    use AsSource,
        Filterable,
        HasFactory,
        Sortable;

    protected $table = 'product_category_filters';

    protected $fillable = [
        'category_id',
        'code',
        'title',
        'type',
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
        'code' => Like::class,
        'title' => Like::class,
        'active' => Where::class,
    ];

    protected $allowedSorts = [
        'id',
        'sort',
        'title',
        'created_at',
    ];

    /**
     * Категория, к которой относится фильтр
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    /**
     * Возможные значения фильтра
     */
    public function values(): HasMany
    {
        return $this->hasMany(
            ProductCategoryFilterValue::class,
            'filter_id'
        )->orderBy('sort');
    }

    /**
     * Scope: только активные
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
