<?php

// app/Providers/AppServiceProvider.php

namespace App\Providers;

use App\Contracts\SettingsRepositoryInterface;
use App\Helpers\SettingsDirective;
use App\Repositories\SettingsRepository;
use App\Services\SettingsService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Регистрируем репозиторий
        $this->app->bind(SettingsRepositoryInterface::class, SettingsRepository::class);

        // Регистрируем сервис как синглтон
        $this->app->singleton(SettingsService::class, function ($app) {
            return new SettingsService(
                $app->make(SettingsRepositoryInterface::class)
            );
        });
    }

    public function boot(): void
    {
        Carbon::setLocale('ru');
        // Делаем сервис доступным во всех шаблонах
        view()->composer('*', function ($view) {
            $view->with('settings', app(SettingsService::class));
        });
        SettingsDirective::register();
        Blade::directive('iconsprite', function () {
            return "<?php echo file_get_contents(public_path('images/icons.svg')); ?>";
        });
    }
}
