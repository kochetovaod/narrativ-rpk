<?php

namespace App\Repositories;

use App\Contracts\SettingsRepositoryInterface;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class SettingsRepository implements SettingsRepositoryInterface
{
    private const CACHE_KEY = 'site_settings';

    private const CACHE_TTL = 86400;

    public function all(): Collection
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return Setting::all();
        });
    }

    public function findByKey(string $key): ?array
    {
        $setting = $this->all()->firstWhere('key', $key);

        if (! $setting) {
            return null;
        }

        return [
            'value' => $setting->typed_value,
            'type' => $setting->type,
            'group' => $setting->group,
        ];
    }

    public function getGroup(string $group): array
    {
        return $this->all()
            ->where('group', $group)
            ->mapWithKeys(fn ($setting) => [$setting->key => $setting->typed_value])
            ->toArray();
    }

    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
