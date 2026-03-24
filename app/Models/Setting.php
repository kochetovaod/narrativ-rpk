<?php

namespace App\Models;

use App\Enums\SettingGroup;
use App\Enums\SettingType;
use App\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereIn;
use Orchid\Screen\AsSource;

class Setting extends Model
{
    use AsSource,
        Filterable,
        HasAuthor,
        HasFactory;

    /**
     * Ключ кэша для настроек
     */
    protected const CACHE_KEY = 'site_settings';

    /**
     * Время жизни кэша в секундах (24 часа)
     */
    protected const CACHE_TTL = 86400;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'type' => SettingType::class,
        'group' => SettingGroup::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The model's default values.
     *
     * @var array
     */
    protected $attributes = [
        'type' => 'string',
        'group' => 'general',
    ];

    /**
     * Allowed filters for Orchid admin.
     *
     * @var array
     */
    protected $allowedFilters = [
        'id' => Where::class,
        'key' => Like::class,
        'value' => Like::class,
        'type' => WhereIn::class,
        'group' => WhereIn::class,
        'description' => Like::class,
    ];

    /**
     * Allowed sorts for Orchid admin.
     *
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'key',
        'type',
        'group',
        'created_at',
        'updated_at',
    ];

    /*
    |--------------------------------------------------------------------------
    | Boot method
    |--------------------------------------------------------------------------
    */

    protected static function boot()
    {
        parent::boot();

        // Очищаем кэш при сохранении
        static::saved(function () {
            Cache::forget(self::CACHE_KEY);
        });

        // Очищаем кэш при удалении
        static::deleted(function () {
            Cache::forget(self::CACHE_KEY);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors & Mutators
    |--------------------------------------------------------------------------
    */

    /**
     * Получить значение с правильным типом
     */
    public function getTypedValueAttribute(): mixed
    {
        return $this->type->cast($this->value);
    }

    /**
     * Установить значение с учетом типа
     */
    public function setTypedValueAttribute(mixed $value): void
    {
        $this->attributes['value'] = $this->type->serialize($value);
    }

    /**
     * Получить значение в читаемом виде
     */
    public function getDisplayValueAttribute(): string
    {
        $value = $this->typed_value;

        return match ($this->type) {
            SettingType::BOOLEAN => $value ? 'Да' : 'Нет',
            SettingType::JSON => json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
            SettingType::INTEGER => number_format($value, 0, '.', ' '),
            default => (string) $value,
        };
    }

    /**
     * Получить бейдж типа
     */
    public function getTypeBadgeAttribute(): string
    {
        $colors = [
            'string' => 'badge-info',
            'text' => 'badge-warning',
            'integer' => 'badge-success',
            'boolean' => 'badge-primary',
            'json' => 'badge-dark',
        ];

        $color = $colors[$this->type->value] ?? 'badge-default';

        return "<span class='badge {$color}'>{$this->type->label()}</span>";
    }

    /**
     * Получить бейдж группы
     */
    public function getGroupBadgeAttribute(): string
    {
        $colors = [
            'general' => 'badge-secondary',
            'contacts' => 'badge-info',
            'social' => 'badge-primary',
            'seo' => 'badge-success',
            'telegram' => 'badge-info',
            'email' => 'badge-warning',
            'design' => 'badge-dark',
            'integrations' => 'badge-danger',
        ];

        $color = $colors[$this->group->value] ?? 'badge-default';

        return "<span class='badge {$color}'>{$this->group->label()}</span>";
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Scope: настройки из группы
     */
    public function scopeInGroup($query, SettingGroup|string $group)
    {
        $groupValue = $group instanceof SettingGroup ? $group->value : $group;

        return $query->where('group', $groupValue);
    }

    /**
     * Scope: настройки определенного типа
     */
    public function scopeOfType($query, SettingType|string $type)
    {
        $typeValue = $type instanceof SettingType ? $type->value : $type;

        return $query->where('type', $typeValue);
    }

    /**
     * Scope: только булевы настройки
     */
    public function scopeBooleans($query)
    {
        return $query->where('type', SettingType::BOOLEAN->value);
    }

    /**
     * Scope: только числовые настройки
     */
    public function scopeIntegers($query)
    {
        return $query->where('type', SettingType::INTEGER->value);
    }

    /**
     * Scope: поиск по ключу
     */
    public function scopeByKey($query, string $key)
    {
        return $query->where('key', $key);
    }

    /*
    |--------------------------------------------------------------------------
    | Business Logic Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Получить значение настройки по ключу
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = self::where('key', $key)->first();

        if (! $setting) {
            return $default;
        }

        return $setting->typed_value;
    }

    /**
     * Установить значение настройки
     */
    public static function set(string $key, mixed $value, ?SettingType $type = null, ?SettingGroup $group = null, ?string $description = null): self
    {
        $setting = self::firstOrNew(['key' => $key]);

        // Определяем тип, если не указан
        if ($type === null) {
            $type = self::detectType($value);
        }

        $setting->type = $type;
        $setting->typed_value = $value;

        if ($group !== null) {
            $setting->group = $group;
        }

        if ($description !== null) {
            $setting->description = $description;
        }

        $setting->save();

        return $setting;
    }

    /**
     * Получить все настройки с кэшированием
     */
    public static function getAllCached(): \Illuminate\Database\Eloquent\Collection
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return self::all();
        });
    }

    /**
     * Получить настройки группы
     */
    public static function getGroup(SettingGroup|string $group): array
    {
        $groupValue = $group instanceof SettingGroup ? $group->value : $group;

        return self::where('group', $groupValue)
            ->get()
            ->mapWithKeys(function ($setting) {
                return [$setting->key => $setting->typed_value];
            })
            ->toArray();
    }

    /**
     * Проверить, существует ли настройка
     */
    public static function has(string $key): bool
    {
        return self::where('key', $key)->exists();
    }

    /**
     * Удалить настройку по ключу
     */
    public static function remove(string $key): bool
    {
        return self::where('key', $key)->delete();
    }

    /**
     * Определить тип значения автоматически
     */
    protected static function detectType(mixed $value): SettingType
    {
        if (is_bool($value)) {
            return SettingType::BOOLEAN;
        }

        if (is_int($value)) {
            return SettingType::INTEGER;
        }

        if (is_array($value) || is_object($value)) {
            return SettingType::JSON;
        }

        if (strlen($value) > 65535) {
            return SettingType::TEXT;
        }

        return SettingType::STRING;
    }

    /**
     * Импортировать настройки из массива
     */
    public static function import(array $settings, ?SettingGroup $defaultGroup = null): int
    {
        $count = 0;

        foreach ($settings as $key => $value) {
            $group = $defaultGroup ?? SettingGroup::GENERAL;

            // Если значение само является массивом с мета-информацией
            if (is_array($value) && isset($value['value'])) {
                $type = null;
                if (isset($value['type'])) {
                    $type = $value['type'] instanceof SettingType
                        ? $value['type']
                        : SettingType::tryFrom($value['type']);
                }

                $groupEnum = $group;
                if (isset($value['group'])) {
                    $groupEnum = $value['group'] instanceof SettingGroup
                        ? $value['group']
                        : SettingGroup::tryFrom($value['group']);
                }

                self::set(
                    $key,
                    $value['value'],
                    $type,
                    $groupEnum,
                    $value['description'] ?? null
                );

            } else {
                self::set($key, $value, null, $group);
            }

            $count++;
        }

        return $count;
    }

    /**
     * Экспортировать настройки в массив
     */
    public static function export(?SettingGroup $group = null): array
    {
        $query = self::query();

        if ($group !== null) {
            $query->where('group', $group->value);
        }

        return $query->get()
            ->mapWithKeys(function ($setting) {
                return [$setting->key => [
                    'value' => $setting->typed_value,
                    'type' => $setting->type->value,
                    'group' => $setting->group->value,
                    'description' => $setting->description,
                ]];
            })
            ->toArray();
    }

    /**
     * Получить статистику по настройкам
     */
    public static function getStats(): array
    {
        return [
            'total' => self::count(),
            'by_group' => self::selectRaw('group, count(*) as count')
                ->groupBy('group')
                ->get()
                ->mapWithKeys(function ($item) {
                    $group = SettingGroup::tryFrom($item->group);

                    return [
                        $item->group => [
                            'label' => $group?->label() ?? $item->group,
                            'count' => $item->count,
                        ],
                    ];
                })
                ->toArray(),
            'by_type' => self::selectRaw('type, count(*) as count')
                ->groupBy('type')
                ->get()
                ->mapWithKeys(function ($item) {
                    $type = SettingType::tryFrom($item->type);

                    return [
                        $item->type => [
                            'label' => $type?->label() ?? $item->type,
                            'count' => $item->count,
                        ],
                    ];
                })
                ->toArray(),
        ];
    }
}
