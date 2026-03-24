<?php

namespace App\Models;

use App\Enums\LeadPriority;
use App\Enums\LeadStatus;
use App\Enums\PreferredContact;
use App\Enums\RequestType;
use App\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereDateStartEnd;
use Orchid\Filters\Types\WhereIn;
use Orchid\Screen\AsSource;

class Lead extends Model
{
    use AsSource,
        Filterable,
        HasFactory,
        SoftDeletes;
    use HasAuthor;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'leads';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'lead_number',
        'name',
        'phone',
        'email',
        'company_name',
        'position',
        'telegram',
        'whatsapp',
        'preferred_contact',
        'request_type',
        'service_type',
        'product_id',
        'service_id',
        'portfolio_id',
        'client_id',
        'message',
        'form_data',
        'budget_from',
        'budget_to',
        'desired_date',
        'desired_time',
        'status',
        'priority',
        'source',
        'campaign',
        'assigned_to',
        'processed_by',
        'processed_at',
        'assigned_at',
        'called_at',
        'next_call_at',
        'call_attempts',
        'manager_notes',
        'communication_history',
        'loss_reason',
        'converted_at',
        'converted_to_client_id',
        'converted_to_deal_id',
        'ip_address',
        'user_agent',
        'referrer',
        'landing_page',
        'utm_params',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // Enum casts
        'status' => LeadStatus::class,
        'priority' => LeadPriority::class,
        'request_type' => RequestType::class,
        'preferred_contact' => PreferredContact::class,

        // JSON casts
        'form_data' => 'array',
        'communication_history' => 'array',
        'utm_params' => 'array',

        // Decimal casts
        'budget_from' => 'decimal:2',
        'budget_to' => 'decimal:2',

        // Date/time casts
        'desired_date' => 'date:Y-m-d',
        'desired_time' => 'datetime:H:i',
        'processed_at' => 'datetime',
        'assigned_at' => 'datetime',
        'called_at' => 'datetime',
        'next_call_at' => 'datetime',
        'converted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',

        // Integer casts
        'call_attempts' => 'integer',
        'product_id' => 'integer',
        'service_id' => 'integer',
        'portfolio_id' => 'integer',
        'client_id' => 'integer',
        'assigned_to' => 'integer',
        'processed_by' => 'integer',
        'converted_to_client_id' => 'integer',
        'converted_to_deal_id' => 'integer',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array<int, string>
     */
    protected $dates = [
        'desired_date',
        'desired_time',
        'processed_at',
        'assigned_at',
        'called_at',
        'next_call_at',
        'converted_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status' => 'new',
        'priority' => 'medium',
        'preferred_contact' => 'phone',
        'call_attempts' => 0,
    ];

    /**
     * Allowed filters for Orchit admin.
     *
     * @var array
     */
    protected $allowedFilters = [
        'id' => Where::class,
        'lead_number' => Like::class,
        'name' => Like::class,
        'phone' => Like::class,
        'email' => Like::class,
        'company_name' => Like::class,
        'status' => WhereIn::class,
        'priority' => WhereIn::class,
        'request_type' => WhereIn::class,
        'preferred_contact' => WhereIn::class,
        'source' => Like::class,
        'campaign' => Like::class,
        'assigned_to' => Where::class,
        'processed_by' => Where::class,
        'call_attempts' => Where::class,
        'created_at' => WhereDateStartEnd::class,
        'processed_at' => WhereDateStartEnd::class,
        'assigned_at' => WhereDateStartEnd::class,
        'next_call_at' => WhereDateStartEnd::class,
        'desired_date' => WhereDateStartEnd::class,
        'budget_from' => Where::class,
        'budget_to' => Where::class,
    ];

    /**
     * Allowed sorts for Orchit admin.
     *
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'lead_number',
        'name',
        'phone',
        'email',
        'company_name',
        'status',
        'priority',
        'request_type',
        'source',
        'call_attempts',
        'created_at',
        'processed_at',
        'assigned_at',
        'next_call_at',
        'desired_date',
        'budget_from',
        'budget_to',
    ];

    /*
    |--------------------------------------------------------------------------
    | Boot method
    |--------------------------------------------------------------------------
    */

    protected static function boot()
    {
        parent::boot();

        // Генерация уникального номера заявки при создании
        static::creating(function ($lead) {
            if (empty($lead->lead_number)) {
                $lead->lead_number = $lead->generateLeadNumber();
            }
        });

        // Логирование изменений статуса
        static::updated(function ($lead) {
            if ($lead->isDirty('status')) {
                $lead->logStatusChange(
                    $lead->getOriginal('status'),
                    $lead->status
                );
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Связанный продукт
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Связанная услуга
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Связанный проект из портфолио
     */
    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class);
    }

    /**
     * Связанный клиент
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Клиент, в которого конвертирована заявка
     */
    public function convertedToClient(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'converted_to_client_id');
    }

    /**
     * Ответственный менеджер
     */
    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Менеджер, обработавший заявку
     */
    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    /**
     * История изменений статуса
     */
    public function statusHistory(): HasMany
    {
        return $this->hasMany(LeadStatusHistory::class);
    }

    /**
     * Задачи по лиду
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(LeadTask::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors & Mutators
    |--------------------------------------------------------------------------
    */

    /**
     * Получить полное имя контакта с компанией
     */
    public function getFullNameAttribute(): string
    {
        if ($this->company_name) {
            return "{$this->name} ({$this->company_name})";
        }

        return $this->name;
    }

    /**
     * Получить бюджет в читаемом виде
     */
    public function getBudgetRangeAttribute(): ?string
    {
        if (! $this->budget_from && ! $this->budget_to) {
            return null;
        }

        if ($this->budget_from && $this->budget_to) {
            return number_format($this->budget_from, 0, '.', ' ').' - '.
                   number_format($this->budget_to, 0, '.', ' ').' ₽';
        }

        if ($this->budget_from) {
            return 'от '.number_format($this->budget_from, 0, '.', ' ').' ₽';
        }

        return 'до '.number_format($this->budget_to, 0, '.', ' ').' ₽';
    }

    /**
     * Получить цвет для отображения в админке
     */
    public function getRowColorAttribute(): ?string
    {
        if ($this->priority === LeadPriority::URGENT && $this->status->requiresAttention()) {
            return '#fff2f0'; // Светло-красный для срочных
        }

        if ($this->priority === LeadPriority::HIGH && $this->status->requiresAttention()) {
            return '#fff7e6'; // Светло-оранжевый для высоких
        }

        return null;
    }

    /**
     * Проверить, просрочен ли лид (дедлайн реакции)
     */
    public function getIsOverdueAttribute(): bool
    {
        if (! $this->created_at || ! $this->priority || $this->status->isFinal()) {
            return false;
        }

        $deadline = $this->created_at->addHours(
            $this->priority->maxResponseHours()
        );

        return now()->greaterThan($deadline) && ! $this->processed_at;
    }

    /**
     * Получить дедлайн реакции
     */
    public function getResponseDeadlineAttribute(): ?\Carbon\Carbon
    {
        if (! $this->created_at || ! $this->priority) {
            return null;
        }

        return $this->created_at->addHours(
            $this->priority->maxResponseHours()
        );
    }

    /**
     * Получить статус в виде бейджа для админки
     */
    public function getStatusBadgeAttribute(): string
    {
        $colors = [
            'new' => 'badge-info',
            'assigned' => 'badge-primary',
            'in_progress' => 'badge-warning',
            'waiting' => 'badge-warning-light',
            'qualified' => 'badge-success',
            'unqualified' => 'badge-secondary',
            'converted' => 'badge-success',
            'closed' => 'badge-success-light',
            'lost' => 'badge-danger',
            'spam' => 'badge-dark',
        ];

        $color = $colors[$this->status->value] ?? 'badge-default';

        return "<span class='badge {$color}'>{$this->status->label()}</span>";
    }

    /**
     * Получить приоритет в виде бейджа для админки
     */
    public function getPriorityBadgeAttribute(): string
    {
        $colors = [
            'low' => 'badge-secondary',
            'medium' => 'badge-info',
            'high' => 'badge-warning',
            'urgent' => 'badge-danger',
        ];

        $color = $colors[$this->priority->value] ?? 'badge-default';

        return "<span class='badge {$color}'>{$this->priority->label()}</span>";
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Scope: только новые заявки
     */
    public function scopeNew($query)
    {
        return $query->where('status', LeadStatus::NEW);
    }

    /**
     * Scope: заявки, требующие внимания
     */
    public function scopeRequiringAttention($query)
    {
        return $query->whereIn('status', [
            LeadStatus::NEW,
            LeadStatus::WAITING,
            LeadStatus::ASSIGNED,
        ])->whereNull('processed_at');
    }

    /**
     * Scope: просроченные заявки
     */
    public function scopeOverdue($query)
    {
        return $query->whereIn('status', [
            LeadStatus::NEW,
            LeadStatus::ASSIGNED,
            LeadStatus::IN_PROGRESS,
            LeadStatus::WAITING,
        ])->whereNull('processed_at');
    }

    /**
     * Scope: назначенные на конкретного менеджера
     */
    public function scopeAssignedTo($query, int $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    /**
     * Scope: заявки за период
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Scope: конвертированные в клиентов
     */
    public function scopeConverted($query)
    {
        return $query->where('status', LeadStatus::CONVERTED);
    }

    /**
     * Scope: потерянные заявки
     */
    public function scopeLost($query)
    {
        return $query->where('status', LeadStatus::LOST);
    }

    /**
     * Scope: по источнику
     */
    public function scopeFromSource($query, string $source)
    {
        return $query->where('source', $source);
    }

    /**
     * Scope: по типу запроса
     */
    public function scopeOfRequestType($query, RequestType $type)
    {
        return $query->where('request_type', $type);
    }

    /**
     * Scope: по приоритету
     */
    public function scopeOfPriority($query, LeadPriority $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Scope: с бюджетом выше указанного
     */
    public function scopeBudgetMin($query, float $min)
    {
        return $query->where(function ($q) use ($min) {
            $q->where('budget_from', '>=', $min)
                ->orWhere('budget_to', '>=', $min);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Business Logic Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Генерация уникального номера заявки
     */
    public function generateLeadNumber(): string
    {
        $year = now()->format('Y');
        $month = now()->format('m');

        // Получаем последний номер заявки за текущий месяц
        $lastLead = self::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();

        if ($lastLead && preg_match('/LEAD-'.$year.$month.'-(\d+)/', $lastLead->lead_number, $matches)) {
            $number = intval($matches[1]) + 1;
        } else {
            $number = 1;
        }

        return 'LEAD-'.$year.$month.'-'.str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Логирование изменения статуса
     */
    protected function logStatusChange($oldStatus, $newStatus): void
    {
        $this->statusHistory()->create([
            'old_status' => $oldStatus instanceof LeadStatus ? $oldStatus->value : $oldStatus,
            'new_status' => $newStatus instanceof LeadStatus ? $newStatus->value : $newStatus,
            'updated_by' => Auth::id(),
        ]);
    }

    /**
     * Назначить ответственного менеджера
     */
    public function assignTo(int $userId): self
    {
        $this->assigned_to = $userId;
        $this->assigned_at = now();

        if ($this->status === LeadStatus::NEW) {
            $this->status = LeadStatus::ASSIGNED;
        }

        $this->save();

        return $this;
    }

    /**
     * Отметить как обработанную
     */
    public function markAsProcessed(int $userId): self
    {
        $this->processed_by = $userId;
        $this->processed_at = now();

        if ($this->status === LeadStatus::ASSIGNED) {
            $this->status = LeadStatus::IN_PROGRESS;
        }

        $this->save();

        return $this;
    }

    /**
     * Добавить заметку менеджера
     */
    public function addManagerNote(string $note): self
    {
        $this->manager_notes = $this->manager_notes
            ? $this->manager_notes."\n\n[".now()->format('d.m.Y H:i')."]\n".$note
            : '['.now()->format('d.m.Y H:i')."]\n".$note;

        $this->save();

        return $this;
    }

    /**
     * Зафиксировать звонок
     */
    public function recordCall(?string $note = null): self
    {
        $this->called_at = now();
        $this->call_attempts = $this->call_attempts + 1;

        if ($note) {
            $this->addManagerNote('Звонок: '.$note);
        }

        $this->save();

        return $this;
    }

    /**
     * Запланировать следующий звонок
     */
    public function scheduleNextCall(\DateTimeInterface $dateTime): self
    {
        $this->next_call_at = $dateTime;
        $this->save();

        return $this;
    }

    /**
     * Конвертировать в клиента
     */
    public function convertToClient(array $clientData = []): Client
    {
        // Создаем или обновляем клиента
        $client = Client::updateOrCreate(
            ['email' => $this->email ?? null],
            [
                'name' => $this->name,
                'phone' => $this->phone,
                'company_name' => $this->company_name,
                ...$clientData,
            ]
        );

        // Обновляем лид
        $this->converted_to_client_id = $client->id;
        $this->converted_at = now();
        $this->status = LeadStatus::CONVERTED;
        $this->save();

        return $client;
    }

    /**
     * Отметить как потерянную
     */
    public function markAsLost(?string $reason = null): self
    {
        $this->status = LeadStatus::LOST;
        $this->loss_reason = $reason;
        $this->save();

        return $this;
    }

    /**
     * Отметить как спам
     */
    public function markAsSpam(): self
    {
        $this->status = LeadStatus::SPAM;
        $this->save();

        return $this;
    }

    /**
     * Проверить, можно ли редактировать лид
     */
    public function isEditable(): bool
    {
        return ! in_array($this->status, [
            LeadStatus::CONVERTED,
            LeadStatus::CLOSED,
            LeadStatus::LOST,
            LeadStatus::SPAM,
        ]);
    }

    /**
     * Получить следующий рекомендуемый шаг
     */
    public function getNextSuggestedAction(): ?string
    {
        if ($this->status === LeadStatus::NEW && ! $this->assigned_to) {
            return 'Назначьте ответственного менеджера';
        }

        if ($this->status === LeadStatus::ASSIGNED && ! $this->processed_at) {
            return 'Обработайте заявку';
        }

        if ($this->status === LeadStatus::WAITING && $this->next_call_at && $this->next_call_at->isPast()) {
            return 'Пора звонить клиенту';
        }

        if ($this->status === LeadStatus::IN_PROGRESS && ! $this->next_call_at) {
            return 'Запланируйте следующий контакт';
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | Statistics Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Получить статистику по статусам
     */
    public static function getStatusStats(): array
    {
        $stats = [];

        foreach (LeadStatus::cases() as $status) {
            $stats[$status->value] = [
                'label' => $status->label(),
                'count' => self::where('status', $status)->count(),
                'color' => $status->color(),
            ];
        }

        return $stats;
    }

    /**
     * Получить статистику по источникам
     */
    public static function getSourceStats(): array
    {
        return self::selectRaw('source, count(*) as count')
            ->whereNotNull('source')
            ->groupBy('source')
            ->orderBy('count', 'desc')
            ->get()
            ->pluck('count', 'source')
            ->toArray();
    }

    /**
     * Получить среднее время обработки заявок (в часах)
     */
    public static function getAverageProcessingTime(): float
    {
        return self::whereNotNull('processed_at')
            ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, processed_at)) as avg_hours')
            ->value('avg_hours') ?? 0;
    }

    /**
     * Получить конверсию в клиентов
     */
    public static function getConversionRate(): float
    {
        $total = self::count();
        if ($total === 0) {
            return 0;
        }

        $converted = self::where('status', LeadStatus::CONVERTED)->count();

        return round(($converted / $total) * 100, 2);
    }
}
