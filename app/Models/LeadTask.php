<?php

namespace App\Models;

use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadTask extends Model
{
    protected $table = 'lead_tasks';

    protected $fillable = [
        'lead_id',
        'title',
        'description',
        'status',
        'priority',
        'due_date',
        'assigned_to',
        'completed_at',
    ];

    protected $casts = [
        'status' => TaskStatus::class,
        'priority' => TaskPriority::class,
        'due_date' => 'date',
        'completed_at' => 'datetime',
    ];

    protected $attributes = [
        'status' => 'pending',
        'priority' => 'medium',
    ];

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function complete(): self
    {
        $this->status = TaskStatus::COMPLETED;
        $this->completed_at = now();
        $this->save();

        return $this;
    }

    public function isOverdue(): bool
    {
        return $this->due_date
            && $this->due_date->isPast()
            && $this->status !== TaskStatus::COMPLETED;
    }
}
