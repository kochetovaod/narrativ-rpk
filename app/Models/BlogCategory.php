<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    /** @use HasFactory<\Database\Factories\BlogCategoryFactory> */
    use HasFactory;

    protected $fillable = ['title', 'slug'];

    public function articles()
    {
        return $this->hasMany(Blog::class, 'category_id');
    }
}
