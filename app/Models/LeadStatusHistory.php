<?php

namespace App\Models;

use App\Enums\LeadStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadStatusHistory extends Model
{
    protected $table = 'lead_status_history';

    protected $fillable = [
        'lead_id',
        'old_status',
        'new_status',
        'comment',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'old_status' => LeadStatus::class,
        'new_status' => LeadStatus::class,
        'created_by' => 'integer',
        'updated_by' => 'integer',
    ];

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getChangeDescriptionAttribute(): string
    {
        $old = $this->old_status?->label() ?? 'Нет статуса';
        $new = $this->new_status->label();

        return "Статус изменен с '{$old}' на '{$new}'";
    }
}
