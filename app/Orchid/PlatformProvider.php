<?php

declare(strict_types=1);

namespace App\Orchid;

use App\Models\ProductCategory;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);

        // ...
    }

    /**
     * Register the application menu.
     *
     * @return Menu[]
     */
    public function menu(): array
    {
        // Получаем категории для динамического меню
        $categoryMenuItems = $this->getProductCategoryMenuItems();

        return [
            Menu::make('CRM')
                ->icon('bs.people')
                ->title('Управление клиентами')
                ->list([
                    Menu::make('Все заявки')
                        ->icon('bs.ticket')
                        ->route('platform.leads.list')
                        ->badge(function () {
                            $newCount = \App\Models\Lead::where('status', 'new')->count();

                            return $newCount > 0 ? $newCount : null;
                        }),

                    Menu::make('Новые заявки')
                        ->icon('bs.bell')
                        ->route('platform.leads.list', ['filter[status]' => 'new'])
                        ->badge(function () {
                            return \App\Models\Lead::where('status', 'new')->count();
                        }),

                    Menu::make('Требуют внимания')
                        ->icon('bs.exclamation-triangle')
                        ->route('platform.leads.list', ['filter[status]' => 'waiting,assigned'])
                        ->badge(function () {
                            return \App\Models\Lead::requiringAttention()->count();
                        }),
                ]),

            Menu::make('Услуги')
                ->icon('bs.briefcase')
                ->route('platform.services.list')
                ->title('Контент'),
            Menu::make('Продукция')
                ->slug('product-categories')
                ->icon('bs.cart')
                ->route('platform.product-categories.list')
                ->permission('platform.product-categories.view')
                ->list($categoryMenuItems),

            Menu::make('Портфолио')
                ->icon('bs.images')
                ->route('platform.portfolio.list')
                ->permission('platform.portfolio.view'),

            Menu::make('Блог')
                ->icon('bs.book')
                ->route('platform.blogs.list')
                ->permission('platform.blogs.view'),

            Menu::make('Оборудование')
                ->icon('bs.tools')
                ->route('platform.equipment.list')
                ->permission('platform.equipment.view'),

            Menu::make('Настройки')
                ->icon('bs.gear')
                ->route('platform.settings')
                ->title('Настройки')
                ->permission('platform.settings.manage'),
            Menu::make('SEO')
                ->icon('bs.globe')
                ->route('platform.seo.list')
                ->permission('platform.settings.manage'),

            // Menu::make('Очистить кэш')
            //     ->icon('bs.trash')
            //     ->route('platform.clear.cache')
            //     ->permission('platform.settings.manage'),
            Menu::make('Клиенты')
                ->icon('bs.people')
                ->route('platform.clients.list')
                ->permission('platform.clients.view'),
        ];
    }

    private function getProductCategoryMenuItems(): array
    {
        try {
            // Используем withCount для эффективного подсчета связанных моделей
            $categories = ProductCategory::query()
                ->orderBy('sort')
                ->orderBy('title')
                ->withCount('products')
                ->get();

            $menuItems = [];

            foreach ($categories as $category) {
                $menuItems[] = Menu::make($category->title)
                    ->route('platform.products.list', ['filter[category_id]' => $category->id])
                    ->permission('platform.products.view')
                    ->badge(fn () => $category->products_count > 0 ? $category->products_count : null);
            }

            return $menuItems;
        } catch (\Exception $e) {
            // Если произошла ошибка (например, таблица не существует), возвращаем пустой массив
            return [];
        }
    }

    /**
     * Register permissions for the application.
     *
     * @return ItemPermission[]
     */
    public function permissions(): array
    {
        return [
            ItemPermission::group('Контент')
                ->addPermission('platform.services.view', 'Просмотр услуг')
                ->addPermission('platform.services.edit', 'Редактирование услуг')
                ->addPermission('platform.services.delete', 'Удаление услуг')
                ->addPermission('platform.products.view', 'Просмотр товаров')
                ->addPermission('platform.products.edit', 'Редактирование товаров')
                ->addPermission('platform.product-categories.view', 'Просмотр категорий товаров')
                ->addPermission('platform.product-categories.edit', 'Редактирование категорий товаров')
                ->addPermission('platform.portfolio.view', 'Просмотр портфолио')
                ->addPermission('platform.portfolio.edit', 'Редактирование портфолио')
                ->addPermission('platform.posts.view', 'Просмотр новостей')
                ->addPermission('platform.posts.edit', 'Редактирование новостей')
                ->addPermission('platform.equipment.view', 'Просмотр оборудования')
                ->addPermission('platform.equipment.edit', 'Редактирование оборудования')
                ->addPermission('platform.clients.view', 'Просмотр клиентов')
                ->addPermission('platform.clients.edit', 'Редактирование клиентов')
                ->addPermission('platform.pages.view', 'Просмотр страниц')
                ->addPermission('platform.pages.edit', 'Редактирование страниц'),

            ItemPermission::group('Заявки')
                ->addPermission('platform.leads.view', 'Просмотр заявок')
                ->addPermission('platform.leads.edit', 'Редактирование заявок')
                ->addPermission('platform.leads.export', 'Экспорт заявок'),

            ItemPermission::group('Аналитика')
                ->addPermission('platform.analytics', 'Доступ к аналитике'),

            ItemPermission::group('Настройки')
                ->addPermission('platform.settings.manage', 'Управление настройки'),
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
            ItemPermission::group('CRM')
                ->addPermission('platform.leads.list', 'Просмотр списка заявок')
                ->addPermission('platform.leads.edit', 'Создание и редактирование заявок')
                ->addPermission('platform.leads.export', 'Экспорт заявок')
                ->addPermission('platform.leads.delete', 'Удаление заявок'),
        ];
    }
}
