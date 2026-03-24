<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Blade;

class SettingsDirective
{
    public static function register()
    {
        // @setting('site_name')
        Blade::directive('setting', function ($expression) {
            return "<?php echo app(\App\Services\SettingsService::class)->get($expression); ?>";
        });

        // @image('site_logo', 'default.jpg')
        Blade::directive('image', function ($expression) {
            $params = explode(',', $expression);
            $key = trim($params[0]);
            $default = isset($params[1]) ? trim($params[1]) : 'null';

            return "<?php echo app(\App\Services\SettingsService::class)->getImageUrl($key, $default); ?>";
        });
    }
}
