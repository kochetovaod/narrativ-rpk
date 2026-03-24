<?php

if (! function_exists('setting')) {
    function setting(string $key, $default = null): mixed
    {
        // Используем модель Setting с кэшированием
        return app(\App\Models\Setting::class)->get($key, $default);
    }
}
