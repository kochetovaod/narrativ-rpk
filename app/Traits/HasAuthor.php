<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

/**
 * Trait HasAuthor
 *
 * Добавляет функционал для отслеживания авторов создания и редактирования
 * Требует поля в таблице: created_by, updated_by (BIGINT UNSIGNED NULL)
 */
trait HasAuthor
{
    /**
     * Boot the trait
     */
    protected static function bootHasAuthor(): void
    {
        static::creating(function ($model) {
            if (Auth::check() && ! $model->isDirty('created_by')) {
                $model->created_by = Auth::id();
            }
        });

        static::updating(function ($model) {
            if (Auth::check() && ! $model->isDirty('updated_by')) {
                $model->updated_by = Auth::id();
            }
        });

        static::saving(function ($model) {
            if (Auth::check() && $model->isDirty() && ! $model->isDirty('updated_by')) {
                $model->updated_by = Auth::id();
            }
        });
    }

    /**
     * Связь с автором создания
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Связь с автором последнего редактирования
     */
    public function editor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Получить имя автора создания
     */
    public function getCreatorNameAttribute(): string
    {
        return $this->creator?->name ?? 'Система';
    }

    /**
     * Получить имя автора редактирования
     */
    public function getEditorNameAttribute(): string
    {
        return $this->editor?->name ?? 'Система';
    }

    /**
     * Проверить, является ли пользователь автором создания
     */
    public function isCreatedBy(User $user): bool
    {
        return $this->created_by === $user->id;
    }

    /**
     * Проверить, является ли пользователь автором редактирования
     */
    public function isUpdatedBy(User $user): bool
    {
        return $this->updated_by === $user->id;
    }

    /**
     * Получить список пользователей, связанных с записью
     */
    public function getRelatedUsersAttribute()
    {
        return User::whereIn('id', [
            $this->created_by,
            $this->updated_by,
        ])->whereNotNull('id')->get()->unique('id');
    }
}
