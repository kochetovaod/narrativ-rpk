<?php

namespace App\Models;

use App\Traits\HasMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Employee extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeFactory> */
    use AsSource,
        HasFactory,
        HasMedia;

    protected $table = 'employees';

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'preview_id',
        'detail_id',
        'properties',
        'sort',
        'active',
        'published_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'active' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'author_id');
    }
}
