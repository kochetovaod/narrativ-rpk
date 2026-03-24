<?php

namespace App\Services;

use App\Contracts\SettingsRepositoryInterface;
use App\Enums\SettingGroup;
use Orchid\Attachment\Models\Attachment;

class SettingsService
{
    private ?array $allSettings = null;

    private ?array $attachmentsCache = [];

    public function __construct(
        private SettingsRepositoryInterface $repository
    ) {}

    /**
     * Получить значение настройки
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $settings = $this->getAllSettings();

        return $settings[$key]['value'] ?? $default;
    }

    /**
     * Получить несколько настроек
     */
    public function getMultiple(array $keys): array
    {
        $settings = $this->getAllSettings();
        $result = [];

        foreach ($keys as $key) {
            $result[$key] = $settings[$key]['value'] ?? null;
        }

        return $result;
    }

    /**
     * Получить группу настроек
     */
    public function getGroup(SettingGroup|string $group): array
    {
        $groupValue = $group instanceof SettingGroup ? $group->value : $group;

        return $this->repository->getGroup($groupValue);
    }

    /**
     * Получить URL изображения
     */
    public function getImageUrl(string $key, ?string $default = null): ?string
    {
        $value = $this->get($key);

        if (! $value) {
            return $default;
        }

        // Если ID аттачмента
        if (is_numeric($value)) {
            if (! isset($this->attachmentsCache[$value])) {
                $this->attachmentsCache[$value] = Attachment::find((int) $value);
            }

            $attachment = $this->attachmentsCache[$value];

            return $attachment ? $attachment->url() : $default;
        }

        // Если прямой путь
        return asset($value);
    }

    /**
     * Получить все настройки в удобном формате
     */
    private function getAllSettings(): array
    {
        if ($this->allSettings === null) {
            $collection = $this->repository->all();
            $this->allSettings = [];

            foreach ($collection as $setting) {
                $this->allSettings[$setting->key] = [
                    'value' => $setting->typed_value,
                    'type' => $setting->type,
                    'group' => $setting->group,
                ];
            }
        }

        return $this->allSettings;
    }

    /**
     * Очистить кэш
     */
    public function clearCache(): void
    {
        $this->repository->clearCache();
        $this->allSettings = null;
        $this->attachmentsCache = [];
    }

    /**
     * Получить логотипы
     */
    public function getLogos(): array
    {
        return [
            'default' => $this->getImageUrl('site_logo'),
            'dark' => $this->getImageUrl('site_logo_dark'),
            'mobile' => $this->getImageUrl('site_logo_mobile'),
        ];
    }

    /**
     * Получить контакты
     */
    public function getContacts(): array
    {
        return $this->getGroup(SettingGroup::CONTACTS);
    }

    /**
     * Получить соцсети
     */
    public function getSocials(): array
    {
        return $this->getGroup(SettingGroup::SOCIAL);
    }
}
