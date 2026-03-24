<?php

// app/Helpers/SettingsHelper.php

namespace App\Helpers;

use App\Enums\SettingType;
use App\Models\Setting;
use Orchid\Attachment\Models\Attachment;

class SettingsHelper
{
    /**
     * Получить URL изображения из настроек
     */
    public static function getImageUrl(string $key, ?string $default = null): ?string
    {
        $setting = Setting::where('key', $key)->first();

        if (! $setting || ! $setting->value) {
            return $default;
        }

        $attachment = Attachment::find((int) $setting->value);

        return $attachment ? $attachment->url() : $default;
    }

    /**
     * Получить объект Attachment из настроек
     */
    public static function getAttachment(string $key): ?Attachment
    {
        $setting = Setting::where('key', $key)->first();

        if (! $setting || ! $setting->value) {
            return null;
        }

        return Attachment::find((int) $setting->value);
    }

    /**
     * Получить все изображения из настроек
     */
    public static function getAllImages(): array
    {
        $settings = Setting::where('type', SettingType::IMAGE)
            ->whereNotNull('value')
            ->get();

        $images = [];
        foreach ($settings as $setting) {
            $attachment = Attachment::find((int) $setting->value);
            if ($attachment) {
                $images[$setting->key] = $attachment;
            }
        }

        return $images;
    }
}
