<?php

namespace App\Models;

use App\Enums\StatisticsEventType;
use App\Traits\HasProperties;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;

/**
 * @property int $id
 * @property StatisticsEventType $event_type
 * @property string|null $page_url
 * @property string|null $referrer
 * @property string|null $utm_source
 * @property string|null $utm_medium
 * @property string|null $utm_campaign
 * @property string|null $session_id
 * @property string|null $ip_hash
 * @property string|null $user_agent
 * @property string|null $device_type
 * @property string|null $browser
 * @property string|null $os
 * @property string|null $country
 * @property string|null $city
 * @property array|null $metadata
 * @property Carbon $recorded_at
 * @property int|null $time_on_page
 * @property int|null $scroll_depth
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|static byEventType(StatisticsEventType|string $eventType)
 * @method static Builder|static byDateRange(Carbon $startDate, Carbon $endDate)
 * @method static Builder|static byPage(string $pageUrl)
 * @method static Builder|static bySession(string $sessionId)
 * @method static Builder|static byUtm(string $source = null, string $medium = null, string $campaign = null)
 * @method static Builder|static today()
 * @method static Builder|static yesterday()
 * @method static Builder|static thisWeek()
 * @method static Builder|static thisMonth()
 */
class SiteStatistic extends Model
{
    use HasFactory;
    use HasProperties;

    /**
     * Таблица БД
     *
     * @var string
     */
    protected $table = 'site_statistics';

    /**
     * Атрибуты, которые можно массово заполнять
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'event_type',
        'page_url',
        'referrer',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'session_id',
        'ip_hash',
        'user_agent',
        'device_type',
        'browser',
        'os',
        'country',
        'city',
        'metadata',
        'recorded_at',
        'time_on_page',
        'scroll_depth',
    ];

    /**
     * Атрибуты, которые должны быть приведены к определенным типам
     *
     * @var array<string, string>
     */
    protected $casts = [
        'event_type' => StatisticsEventType::class,
        'metadata' => 'array',
        'recorded_at' => 'datetime',
        'time_on_page' => 'integer',
        'scroll_depth' => 'integer',
    ];

    /**
     * Атрибуты, которые должны быть установлены по умолчанию
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'recorded_at' => null, // Будет установлено через boot()
    ];

    /**
     * Boot the model
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            // Устанавливаем recorded_at, если не указано
            if (empty($model->recorded_at)) {
                $model->recorded_at = now();
            }

            // Определяем устройство, браузер и ОС из user_agent
            if ($model->user_agent && empty($model->device_type)) {
                $agent = new Agent;
                $agent->setUserAgent($model->user_agent);

                $model->device_type = $model->getDeviceType($agent);
                $model->browser = $agent->browser();
                $model->os = $agent->platform();
            }
        });
    }

    /**
     * Получить тип устройства
     */
    protected function getDeviceType(Agent $agent): string
    {
        if ($agent->isMobile()) {
            return 'mobile';
        }

        if ($agent->isTablet()) {
            return 'tablet';
        }

        if ($agent->isDesktop()) {
            return 'desktop';
        }

        return 'unknown';
    }

    /**
     * Scope: по типу события
     */
    public function scopeByEventType(Builder $query, StatisticsEventType|string $eventType): Builder
    {
        return $query->where('event_type', $eventType);
    }

    /**
     * Scope: по диапазону дат
     */
    public function scopeByDateRange(Builder $query, Carbon $startDate, Carbon $endDate): Builder
    {
        return $query->whereBetween('recorded_at', [$startDate, $endDate]);
    }

    /**
     * Scope: по URL страницы
     */
    public function scopeByPage(Builder $query, string $pageUrl): Builder
    {
        return $query->where('page_url', 'LIKE', "%{$pageUrl}%");
    }

    /**
     * Scope: по сессии
     */
    public function scopeBySession(Builder $query, string $sessionId): Builder
    {
        return $query->where('session_id', $sessionId);
    }

    /**
     * Scope: по UTM-меткам
     */
    public function scopeByUtm(Builder $query, ?string $source = null, ?string $medium = null, ?string $campaign = null): Builder
    {
        return $query
            ->when($source, fn ($q) => $q->where('utm_source', $source))
            ->when($medium, fn ($q) => $q->where('utm_medium', $medium))
            ->when($campaign, fn ($q) => $q->where('utm_campaign', $campaign));
    }

    /**
     * Scope: события за сегодня
     */
    public function scopeToday(Builder $query): Builder
    {
        return $query->whereDate('recorded_at', today());
    }

    /**
     * Scope: события за вчера
     */
    public function scopeYesterday(Builder $query): Builder
    {
        return $query->whereDate('recorded_at', today()->subDay());
    }

    /**
     * Scope: события за текущую неделю
     */
    public function scopeThisWeek(Builder $query): Builder
    {
        return $query->whereBetween('recorded_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    /**
     * Scope: события за текущий месяц
     */
    public function scopeThisMonth(Builder $query): Builder
    {
        return $query->whereMonth('recorded_at', now()->month)
            ->whereYear('recorded_at', now()->year);
    }

    /**
     * Получить цвет для типа события (из enum)
     */
    public function getColorAttribute(): string
    {
        return $this->event_type->color();
    }

    /**
     * Получить метку для типа события (из enum)
     */
    public function getEventLabelAttribute(): string
    {
        return $this->event_type->label();
    }

    /**
     * Получить тип формы из метаданных
     */
    public function getFormTypeAttribute(): ?string
    {
        return $this->metadata['form_type'] ?? null;
    }

    /**
     * Получить ID формы из метаданных
     */
    public function getFormIdAttribute(): ?string
    {
        return $this->metadata['form_id'] ?? null;
    }

    /**
     * Проверить, является ли событие уникальным визитом
     */
    public function isUniqueVisit(): bool
    {
        return $this->event_type === StatisticsEventType::UNIQUE_VISIT;
    }

    /**
     * Проверить, является ли событие просмотром страницы
     */
    public function isPageView(): bool
    {
        return $this->event_type === StatisticsEventType::PAGE_VIEW;
    }

    /**
     * Проверить, является ли событие отправкой формы
     */
    public function isFormSubmit(): bool
    {
        return $this->event_type === StatisticsEventType::FORM_SUBMIT;
    }

    /**
     * Проверить, является ли событие кликом по телефону
     */
    public function isPhoneClick(): bool
    {
        return $this->event_type === StatisticsEventType::PHONE_CLICK;
    }

    /**
     * Получить статистику просмотров по дням
     */
    public static function getViewsByDays(int $days = 30): Collection
    {
        return self::query()
            ->where('event_type', StatisticsEventType::PAGE_VIEW)
            ->where('recorded_at', '>=', now()->subDays($days))
            ->select(
                DB::raw('DATE(recorded_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date');
    }

    /**
     * Получить статистику уникальных посетителей по дням
     */
    public static function getUniqueVisitorsByDays(int $days = 30): Collection
    {
        return self::query()
            ->where('event_type', StatisticsEventType::UNIQUE_VISIT)
            ->where('recorded_at', '>=', now()->subDays($days))
            ->select(
                DB::raw('DATE(recorded_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date');
    }

    /**
     * Получить статистику по источникам трафика
     */
    public static function getTrafficSources(Carbon $startDate, Carbon $endDate): Collection
    {
        return self::query()
            ->where('event_type', StatisticsEventType::UNIQUE_VISIT)
            ->whereBetween('recorded_at', [$startDate, $endDate])
            ->select(
                DB::raw('COALESCE(utm_source, "direct") as source'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('source')
            ->orderByDesc('count')
            ->get();
    }

    /**
     * Получить статистику по устройствам
     */
    public static function getDeviceStats(Carbon $startDate, Carbon $endDate): Collection
    {
        return self::query()
            ->where('event_type', StatisticsEventType::UNIQUE_VISIT)
            ->whereBetween('recorded_at', [$startDate, $endDate])
            ->select(
                'device_type',
                DB::raw('COUNT(*) as count')
            )
            ->whereNotNull('device_type')
            ->groupBy('device_type')
            ->orderByDesc('count')
            ->get();
    }

    /**
     * Получить статистику по страницам (топ посещаемых)
     */
    public static function getTopPages(int $limit = 10, ?Carbon $startDate = null, ?Carbon $endDate = null): Collection
    {
        $query = self::query()
            ->where('event_type', StatisticsEventType::PAGE_VIEW)
            ->select(
                'page_url',
                DB::raw('COUNT(*) as views')
            )
            ->whereNotNull('page_url')
            ->groupBy('page_url')
            ->orderByDesc('views')
            ->limit($limit);

        if ($startDate && $endDate) {
            $query->whereBetween('recorded_at', [$startDate, $endDate]);
        }

        return $query->get();
    }

    /**
     * Получить статистику конверсий (отправок форм)
     */
    public static function getFormConversions(Carbon $startDate, Carbon $endDate): Collection
    {
        return self::query()
            ->where('event_type', StatisticsEventType::FORM_SUBMIT)
            ->whereBetween('recorded_at', [$startDate, $endDate])
            ->select(
                DB::raw('metadata->>"$.form_type" as form_type'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('form_type')
            ->orderByDesc('count')
            ->get();
    }

    /**
     * Записать событие
     */
    public static function record(
        StatisticsEventType $eventType,
        array $data = []
    ): self {
        $agent = new Agent;
        $agent->setUserAgent(request()->userAgent() ?? '');

        return self::create(array_merge([
            'event_type' => $eventType,
            'page_url' => request()->url(),
            'referrer' => request()->header('referer'),
            'session_id' => session()->getId(),
            'ip_hash' => request()->ip() ? hash('sha256', request()->ip()) : null,
            'user_agent' => request()->userAgent(),
            'device_type' => (new self)->getDeviceType($agent),
            'browser' => $agent->browser(),
            'os' => $agent->platform(),
            'utm_source' => request()->input('utm_source'),
            'utm_medium' => request()->input('utm_medium'),
            'utm_campaign' => request()->input('utm_campaign'),
            'recorded_at' => now(),
        ], $data));
    }

    /**
     * Записать просмотр страницы
     */
    public static function recordPageView(array $data = []): self
    {
        return self::record(StatisticsEventType::PAGE_VIEW, $data);
    }

    /**
     * Записать уникальный визит
     */
    public static function recordUniqueVisit(array $data = []): self
    {
        return self::record(StatisticsEventType::UNIQUE_VISIT, $data);
    }

    /**
     * Записать отправку формы
     */
    public static function recordFormSubmit(string $formType, ?string $formId = null, array $extraData = []): self
    {
        return self::record(StatisticsEventType::FORM_SUBMIT, array_merge([
            'metadata' => array_merge([
                'form_type' => $formType,
                'form_id' => $formId,
            ], $extraData),
        ], $extraData));
    }

    /**
     * Записать клик по телефону
     */
    public static function recordPhoneClick(?string $phoneNumber = null, array $extraData = []): self
    {
        return self::record(StatisticsEventType::PHONE_CLICK, array_merge([
            'metadata' => array_merge([
                'phone_number' => $phoneNumber,
            ], $extraData),
        ], $extraData));
    }

    /**
     * Получитать сводку по статистике за период
     */
    public static function getSummary(Carbon $startDate, Carbon $endDate): array
    {
        $stats = self::query()
            ->whereBetween('recorded_at', [$startDate, $endDate])
            ->select(
                DB::raw("SUM(CASE WHEN event_type = 'page_view' THEN 1 ELSE 0 END) as total_views"),
                DB::raw("SUM(CASE WHEN event_type = 'unique_visit' THEN 1 ELSE 0 END) as unique_visits"),
                DB::raw("SUM(CASE WHEN event_type = 'form_submit' THEN 1 ELSE 0 END) as form_submits"),
                DB::raw("SUM(CASE WHEN event_type = 'phone_click' THEN 1 ELSE 0 END) as phone_clicks"),
                DB::raw('COUNT(DISTINCT session_id) as total_sessions')
            )
            ->first();

        return [
            'total_views' => (int) ($stats->total_views ?? 0),
            'unique_visits' => (int) ($stats->unique_visits ?? 0),
            'form_submits' => (int) ($stats->form_submits ?? 0),
            'phone_clicks' => (int) ($stats->phone_clicks ?? 0),
            'total_sessions' => (int) ($stats->total_sessions ?? 0),
            'start_date' => $startDate->toDateString(),
            'end_date' => $endDate->toDateString(),
        ];
    }
}
