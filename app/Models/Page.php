<?php

namespace App\Models;

use App\Traits\HasAuthor;
use App\Traits\HasContent;
use App\Traits\HasMedia;
use App\Traits\HasSEO;
use App\Traits\Sluggable;
use App\Traits\SortableActivePublishable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Platform\Concerns\Sortable;
use Orchid\Screen\AsSource;

class Page extends Model
{
    use AsSource,
        Attachable,
        Filterable,
        HasAuthor,
        HasContent,
        HasFactory,
        HasMedia,
        HasSEO,
        Sluggable,
        SoftDeletes,
        Sortable,
        SortableActivePublishable;

    protected $fillable = [
        'id',
        'title',
        'slug',
        'detail_id',
        'preview_id',
        'excerpt',
        'properties',
    ];

    protected $casts = [
        'properties' => 'array',
        'published_at' => 'datetime',
        'sort' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
}
