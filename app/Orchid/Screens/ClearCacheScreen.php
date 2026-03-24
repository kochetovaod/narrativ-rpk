<?php

namespace App\Orchid\Screens;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ClearCacheScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     */
    public function query(): array
    {
        $cacheStats = $this->getCacheStatistics();

        return [
            'cache_stats' => $cacheStats,
            'cache_types' => $cacheStats['by_type'] ?? [], // Добавьте эту строку
            'opcache_info' => $this->getOpcacheInfo(),
            'cache_history' => $this->getCacheHistory(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Управление кэшем';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Мониторинг и очистка всех типов кэша приложения';
    }

    /**
     * The screen's action buttons.
     */
    public function commandBar(): array
    {
        return [
            DropDown::make('Быстрая очистка')
                ->icon('bs.lightning')
                ->list([
                    Button::make('Очистить весь кэш')
                        ->method('clearAll')
                        ->icon('bs.trash3')
                        ->confirm('Вы уверены, что хотите очистить ВЕСЬ кэш? Это может временно замедлить работу приложения.')
                        ->class('dropdown-item'),

                    Button::make('Очистить только файловый кэш')
                        ->method('clearCache')
                        ->icon('bs.database')
                        ->class('dropdown-item'),

                    Button::make('Очистить только opcache')
                        ->method('clearOpcache')
                        ->icon('bs.cpu')
                        ->class('dropdown-item'),
                ]),

            Button::make('Прогреть кэш')
                ->method('warmupCache')
                ->icon('bs.fire')
                ->confirm('Это может занять некоторое время. Продолжить?'),

            Button::make('Оптимизировать')
                ->method('optimize')
                ->icon('bs.gear-wide-connected'),

            DropDown::make('Дополнительно')
                ->icon('bs.three-dots')
                ->list([
                    Button::make('Сбросить статистику')
                        ->method('resetStats')
                        ->icon('bs.arrow-counterclockwise')
                        ->confirm('Сбросить статистику использования кэша?')
                        ->class('dropdown-item'),

                    Button::make('Проверить целостность')
                        ->method('verifyCache')
                        ->icon('bs.check-circle')
                        ->class('dropdown-item'),
                ]),
        ];
    }

    /**
     * The screen's layout elements.
     */
    public function layout(): array
    {
        return [
            Layout::tabs([
                '📊 Обзор' => [
                    Layout::columns([
                        Layout::rows([
                            Label::make('cache_total_size')
                                ->title('Общий размер кэша')
                                ->value(function ($query) {
                                    return $this->formatBytes($query['cache_stats']['total_size'] ?? 0);
                                }),

                            Label::make('cache_total_files')
                                ->title('Всего файлов/записей')
                                ->value(function ($query) {
                                    return number_format($query['cache_stats']['total_count'] ?? 0);
                                }),
                        ])->title('Статистика кэша'),
                        Layout::rows([
                            Label::make('cache_usage_label')
                                ->title('Использование файлового кэша')
                                ->value(function ($query) {
                                    $stats = $query['cache_stats']['file_cache'] ?? [];
                                    $percent = $stats['percent'] ?? 0;

                                    return round($percent, 1).'% ('.$this->formatBytes($stats['size'] ?? 0).')';
                                }),

                            Label::make('opcache_usage_label')
                                ->title('Использование OPcache')
                                ->value(function ($query) {
                                    $info = $query['opcache_info']['memory_usage'] ?? [];
                                    $percent = $info['percent'] ?? 0;

                                    return $percent.'% ('.($info['used'] ?? '0 B').' / '.($info['total'] ?? '0 B').')';
                                })
                                ->canSee(function_exists('opcache_get_status')),
                        ])->title('Текущая загрузка'),
                    ]),
                    Layout::table('cache_types', [
                        TD::make('type', 'Тип кэша')
                            ->width('200px')
                            ->render(function ($item) {
                                return sprintf(
                                    '<div><strong>%s</strong><br><small class="text-muted">%s</small></div>',
                                    $item['type'],
                                    $item['description'] ?? ''
                                );
                            }),

                        TD::make('size', 'Размер')
                            ->width('150px')
                            ->alignRight()
                            ->render(function ($item) {
                                return $this->formatBytes($item['size'] ?? 0);
                            }),

                        TD::make('count', 'Файлов/записей')
                            ->width('120px')
                            ->alignRight()
                            ->render(function ($item) {
                                return number_format($item['count'] ?? 0);
                            }),

                        TD::make('percent', '%')
                            ->width('80px')
                            ->alignRight()
                            ->render(function ($item) {
                                return round($item['percent'] ?? 0, 1).'%';
                            }),

                        TD::make('status', 'Статус')
                            ->width('120px')
                            ->alignCenter()
                            ->render(function ($item) {
                                $isWarmed = $item['is_warmed'] ?? false;
                                $color = $isWarmed ? 'success' : 'warning';
                                $text = $isWarmed ? 'Прогрет' : 'Не прогрет';

                                return "<span class='badge bg-{$color}'>{$text}</span>";
                            }),

                        TD::make('actions', 'Действия')
                            ->width('150px')
                            ->alignRight()
                            ->render(function ($item) {
                                return DropDown::make()
                                    ->icon('bs.three-dots-vertical')
                                    ->list([
                                        Button::make('Очистить')
                                            ->method('clearSpecific')
                                            ->icon('bs.trash')
                                            ->parameters([
                                                'type' => $item['key'],
                                            ])
                                            ->class('dropdown-item'),

                                        Button::make('Прогреть')
                                            ->method('warmSpecific')
                                            ->icon('bs.fire')
                                            ->parameters([
                                                'type' => $item['key'],
                                            ])
                                            ->class('dropdown-item')
                                            ->canSee(! ($item['is_warmed'] ?? false)),
                                    ])
                                    ->render(); // 🔥 ВАЖНО
                            }),
                    ]),
                ],

                '📈 История очисток' => [
                    Layout::table('cache_history', [
                        TD::make('date', 'Дата')
                            ->width('200px')
                            ->render(function ($item) {
                                if ($item['date'] instanceof \Carbon\Carbon) {
                                    return $item['date']->format('d.m.Y H:i:s');
                                }

                                return $item['date'];
                            }),
                        TD::make('action', 'Действие')
                            ->width('250px')
                            ->render(function ($item) {
                                return e($item['action']);
                            }),
                        TD::make('user', 'Пользователь')
                            ->width('200px')
                            ->render(function ($item) {
                                return e($item['user']);
                            }),

                        TD::make('size_before', 'Размер до')
                            ->width('120px')
                            ->alignRight()
                            ->render(function ($item) {
                                return $this->formatBytes($item['_size_before'] ?? 0);
                            }),
                        TD::make('size_after', 'Размер после')
                            ->width('120px')
                            ->alignRight()
                            ->render(function ($item) {
                                return $this->formatBytes($item['_size_after'] ?? 0);
                            }),
                        TD::make('freed', 'Освобождено')
                            ->width('120px')
                            ->alignRight()
                            ->render(function ($item) {
                                $freed = ($item['_size_before'] ?? 0) - ($item['_size_after'] ?? 0);

                                return $this->formatBytes(max(0, $freed));
                            }),
                    ]),
                ],
            ]),
        ];
    }

    /**
     * Получить детальную статистику по типам кэша
     */
    protected function getCacheStatistics(): array
    {
        $totalSize = 0;
        $totalCount = 0;
        $byType = [];

        // Файловый кэш приложения
        $appCache = $this->getCacheStats(storage_path('framework/cache/data'), 'app');
        $totalSize += $appCache['size'];
        $totalCount += $appCache['count'];
        $byType[] = array_merge($appCache, [
            'key' => 'app',
            'type' => 'Кэш приложения',
            'description' => 'Сгенерированные данные приложения',
            'percent' => 0,
            'is_warmed' => false,
        ]);

        // Кэш представлений
        $viewCache = $this->getCacheStats(storage_path('framework/views'), 'views');
        $totalSize += $viewCache['size'];
        $totalCount += $viewCache['count'];
        $byType[] = array_merge($viewCache, [
            'key' => 'views',
            'type' => 'Шаблоны Blade',
            'description' => 'Скомпилированные шаблоны',
            'percent' => 0,
            'is_warmed' => Cache::has('cache_warmed_views'),
        ]);

        // Кэш конфигурации
        $configCache = base_path('bootstrap/cache/config.php');
        $configSize = file_exists($configCache) ? filesize($configCache) : 0;
        $totalSize += $configSize;
        $totalCount += file_exists($configCache) ? 1 : 0;
        $byType[] = [
            'key' => 'config',
            'type' => 'Конфигурация',
            'description' => 'Кэш файлов конфигурации',
            'size' => $configSize,
            'count' => file_exists($configCache) ? 1 : 0,
            'percent' => 0,
            'is_warmed' => file_exists($configCache),
        ];

        // Кэш маршрутов
        $routeCache = base_path('bootstrap/cache/routes-v7.php');
        $routeSize = file_exists($routeCache) ? filesize($routeCache) : 0;
        $totalSize += $routeSize;
        $totalCount += file_exists($routeCache) ? 1 : 0;
        $byType[] = [
            'key' => 'routes',
            'type' => 'Маршруты',
            'description' => 'Кэш маршрутов приложения',
            'size' => $routeSize,
            'count' => file_exists($routeCache) ? 1 : 0,
            'percent' => 0,
            'is_warmed' => file_exists($routeCache),
        ];

        // Кэш событий
        $eventCache = base_path('bootstrap/cache/packages.php');
        $eventSize = file_exists($eventCache) ? filesize($eventCache) : 0;
        $totalSize += $eventSize;
        $totalCount += file_exists($eventCache) ? 1 : 0;
        $byType[] = [
            'key' => 'events',
            'type' => 'События',
            'description' => 'Кэш событий и пакетов',
            'size' => $eventSize,
            'count' => file_exists($eventCache) ? 1 : 0,
            'percent' => 0,
            'is_warmed' => file_exists($eventCache),
        ];

        // Рассчитываем проценты
        foreach ($byType as &$type) {
            $type['percent'] = $totalSize > 0 ? ($type['size'] / $totalSize) * 100 : 0;
        }

        return [
            'total_size' => $totalSize,
            'total_count' => $totalCount,
            'by_type' => $byType,
            'file_cache' => [
                'size' => $appCache['size'] + $viewCache['size'],
                'count' => $appCache['count'] + $viewCache['count'],
                'percent' => $totalSize > 0 ? (($appCache['size'] + $viewCache['size']) / $totalSize) * 100 : 0,
            ],
        ];
    }

    /**
     * Получить информацию о OPcache
     */
    protected function getOpcacheInfo(): array
    {
        if (! function_exists('opcache_get_status')) {
            return ['enabled' => false];
        }

        $status = opcache_get_status(false);

        if (! $status) {
            return ['enabled' => false];
        }

        $memory = $status['memory_usage'] ?? [];
        $stats = $status['opcache_statistics'] ?? [];

        $usedMemory = $memory['used_memory'] ?? 0;
        $freeMemory = $memory['free_memory'] ?? 0;
        $totalMemory = $usedMemory + $freeMemory;
        $percent = $totalMemory > 0 ? ($usedMemory / $totalMemory) * 100 : 0;

        return [
            'enabled' => true,
            'memory_usage' => [
                'used' => $this->formatBytes($usedMemory),
                'free' => $this->formatBytes($freeMemory),
                'total' => $this->formatBytes($totalMemory),
                'percent' => round($percent, 1),
                'wasted' => $this->formatBytes($memory['wasted_memory'] ?? 0),
            ],
            'stats' => [
                'hits' => number_format($stats['hits'] ?? 0),
                'misses' => number_format($stats['misses'] ?? 0),
                'hit_rate' => round($stats['opcache_hit_rate'] ?? 0, 1).'%',
                'cached_scripts' => number_format($stats['num_cached_scripts'] ?? 0),
                'cached_keys' => number_format($stats['num_cached_keys'] ?? 0),
            ],
        ];
    }

    /**
     * Логировать очистку кэша
     */
    protected function logCacheClear(string $action, int $beforeSize, int $afterSize): void
    {
        $history = Cache::get('cache_clear_history', []);

        $history[] = [
            'date' => now(),
            'action' => $action,
            'user' => Auth::user()?->name ?? 'System',
            'size_before' => $beforeSize, // Сохраняем как число, а не строку
            'size_after' => $afterSize,   // Сохраняем как число, а не строку
        ];

        // Оставляем только последние 100 записей
        if (count($history) > 100) {
            $history = array_slice($history, -100);
        }

        Cache::put('cache_clear_history', $history, now()->addMonth());
    }

    /**
     * Получить историю очисток кэша
     */
    protected function getCacheHistory(): array
    {
        $history = Cache::get('cache_clear_history', []);

        // Форматируем данные для отображения
        $formattedHistory = [];
        foreach (array_slice($history, -20) as $item) {
            $formattedHistory[] = [
                'date' => $item['date'],
                'action' => $item['action'],
                'user' => $item['user'],
                'size_before' => $this->formatBytes($item['size_before'] ?? 0),
                'size_after' => $this->formatBytes($item['size_after'] ?? 0),
                // Добавляем исходные значения для вычислений
                '_size_before' => $item['size_before'] ?? 0,
                '_size_after' => $item['size_after'] ?? 0,
            ];
        }

        return $formattedHistory;
    }

    /**
     * Получить статистику кэша для директории
     */
    protected function getCacheStats(string $path, string $type): array
    {
        $size = 0;
        $count = 0;

        if (! is_dir($path)) {
            return ['size' => 0, 'count' => 0];
        }

        try {
            $files = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::SKIP_DOTS)
            );

            foreach ($files as $file) {
                if ($file->isFile()) {
                    $size += $file->getSize();
                    $count++;
                }
            }
        } catch (\Exception $e) {
            // Логируем ошибку
            report($e);
        }

        return [
            'size' => $size,
            'count' => $count,
        ];
    }

    /**
     * Очистить весь кэш
     */
    public function clearAll(): void
    {
        $beforeStats = $this->getCacheStatistics();
        $beforeSize = $beforeStats['total_size'] ?? 0;

        try {
            Artisan::call('optimize:clear');
            Artisan::call('cache:clear');

            // Очищаем OPcache если доступен
            if (function_exists('opcache_reset')) {
                opcache_reset();
            }

            $afterStats = $this->getCacheStatistics();
            $afterSize = $afterStats['total_size'] ?? 0;

            $this->logCacheClear('Полная очистка кэша', $beforeSize, $afterSize);

            Toast::success('✅ Весь кэш успешно очищен! Освобождено: '.
                $this->formatBytes($beforeSize - $afterSize));
        } catch (\Exception $e) {
            Alert::error('Ошибка при очистке кэша: '.$e->getMessage());
        }
    }

    /**
     * Очистить конкретный тип кэша
     */
    public function clearSpecific(Request $request): void
    {
        $type = $request->input('type');
        $beforeStats = $this->getCacheStatistics();
        $beforeSize = $beforeStats['total_size'] ?? 0;

        try {
            switch ($type) {
                case 'app':
                    Cache::flush();
                    Toast::info('Кэш приложения очищен');
                    break;
                case 'views':
                    Artisan::call('view:clear');
                    Toast::info('Кэш представлений очищен');
                    break;
                case 'config':
                    Artisan::call('config:clear');
                    Toast::info('Кэш конфигурации очищен');
                    break;
                case 'routes':
                    Artisan::call('route:clear');
                    Toast::info('Кэш маршрутов очищен');
                    break;
                case 'events':
                    Artisan::call('event:clear');
                    Toast::info('Кэш событий очищен');
                    break;
                default:
                    Toast::warning('Неизвестный тип кэша');
            }

            $afterStats = $this->getCacheStatistics();
            $afterSize = $afterStats['total_size'] ?? 0;

            $this->logCacheClear("Очистка: {$type}", $beforeSize, $afterSize);

        } catch (\Exception $e) {
            Alert::error('Ошибка: '.$e->getMessage());
        }
    }

    /**
     * Прогреть конкретный тип кэша
     */
    public function warmSpecific(Request $request): void
    {
        $type = $request->input('type');

        try {
            switch ($type) {
                case 'config':
                    Artisan::call('config:cache');
                    Toast::info('Кэш конфигурации создан');
                    break;
                case 'routes':
                    Artisan::call('route:cache');
                    Toast::info('Кэш маршрутов создан');
                    break;
                case 'events':
                    Artisan::call('event:cache');
                    Toast::info('Кэш событий создан');
                    break;
                case 'views':
                    // Предварительная компиляция шаблонов
                    Artisan::call('view:cache');
                    Toast::info('Кэш представлений создан');
                    break;
                default:
                    Toast::warning('Прогрев для данного типа не поддерживается');
            }

            Cache::put('cache_warmed_'.$type, true, now()->addDay());

        } catch (\Exception $e) {
            Alert::error('Ошибка при прогреве: '.$e->getMessage());
        }
    }

    /**
     * Прогреть кэш
     */
    public function warmupCache(): void
    {
        try {
            Artisan::call('config:cache');
            Artisan::call('route:cache');
            Artisan::call('view:cache');
            Artisan::call('event:cache');

            Cache::put('cache_warmed_views', true, now()->addDay());
            Cache::put('cache_last_warmup', now(), now()->addDay());

            Toast::success('🔥 Кэш успешно прогрет!');
        } catch (\Exception $e) {
            Alert::error('Ошибка при прогреве кэша: '.$e->getMessage());
        }
    }

    /**
     * Оптимизировать приложение
     */
    public function optimize(): void
    {
        try {
            Artisan::call('optimize');
            Toast::success('⚡ Приложение оптимизировано!');
        } catch (\Exception $e) {
            Alert::error('Ошибка оптимизации: '.$e->getMessage());
        }
    }

    /**
     * Очистить OPcache
     */
    public function clearOpcache(): void
    {
        if (! function_exists('opcache_reset')) {
            Toast::warning('OPcache не доступен');

            return;
        }

        try {
            opcache_reset();
            Toast::success('OPcache успешно очищен');
        } catch (\Exception $e) {
            Alert::error('Ошибка: '.$e->getMessage());
        }
    }

    /**
     * Сбросить статистику
     */
    public function resetStats(): void
    {
        Cache::forget('cache_clear_history');
        Cache::forget('cache_last_warmup');
        Toast::success('Статистика сброшена');
    }

    /**
     * Проверить целостность кэша
     */
    public function verifyCache(): void
    {
        $issues = [];

        // Проверяем права на запись
        $cacheDir = storage_path('framework/cache');
        if (! is_writable($cacheDir)) {
            $issues[] = 'Нет прав на запись в директорию кэша';
        }

        // Проверяем целостность файлов конфигурации
        if (file_exists(base_path('bootstrap/cache/config.php'))) {
            try {
                require base_path('bootstrap/cache/config.php');
            } catch (\Throwable $e) {
                $issues[] = 'Поврежден файл кэша конфигурации';
            }
        }

        if (empty($issues)) {
            Toast::success('✅ Проверка прошла успешно. Ошибок не обнаружено.');
        } else {
            Toast::warning('⚠️ Обнаружены проблемы: '.implode(', ', $issues));
        }
    }

    /**
     * Форматирование байтов в читаемый вид
     */
    protected function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $unitIndex = 0;
        $size = (float) $bytes;

        while ($size >= 1024 && $unitIndex < count($units) - 1) {
            $size /= 1024;
            $unitIndex++;
        }

        return round($size, 2).' '.$units[$unitIndex];
    }

    /**
     * Права доступа
     */
    public function permission(): ?array
    {
        return [];
    }
}
