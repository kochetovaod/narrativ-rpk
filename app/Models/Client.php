<?php

namespace App\Models;

use App\Contracts\HasCropperConfig;
use App\Traits\HasAuthor;
use App\Traits\HasContent;
use App\Traits\HasMedia;
use App\Traits\HasProperties;
use App\Traits\HasSEO;
use App\Traits\Sluggable;
use App\Traits\SortableActivePublishable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereDateStartEnd;
use Orchid\Platform\Concerns\Sortable;
use Orchid\Screen\AsSource;

class Client extends Model implements HasCropperConfig
{
    use AsSource,
        Attachable,
        Filterable,
        HasAuthor,
        HasContent,
        HasFactory,
        HasMedia,
        HasProperties,
        HasSEO,
        Sluggable,
        SoftDeletes,
        Sortable,
        SortableActivePublishable;

    protected $table = 'clients';

    protected $fillable = [
        'title',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $allowedFilters = [
        // ID и базовые поля
        'id' => Where::class,
        'title' => Like::class,
        // Дата и время
        '' => WhereDateStartEnd::class,
        'updated_at' => WhereDateStartEnd::class,
        'deleted_at' => WhereDateStartEnd::class, // для soft deletes
    ];

    protected $allowedSorts = [
        'id',
        'title',
        'created_at',
        'updated_at',
    ];

    public static function getPreviewConfig(): array
    {
        return [
            'width' => 600,
            'height' => 400,
            'minWidth' => 300,
            'maxWidth' => 1200,
        ];
    }

    public static function getDetailConfig(): array
    {
        return [
            'width' => 1200,
            'height' => 800,
            'minWidth' => 800,
            'maxWidth' => 2000,
        ];
    }
}
