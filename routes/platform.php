<?php

declare(strict_types=1);

use App\Orchid\Screens\Blog\BlogEditScreen;
use App\Orchid\Screens\Blog\BlogListScreen;
use App\Orchid\Screens\Client\ClientEditScreen;
use App\Orchid\Screens\Client\ClientListScreen;
use App\Orchid\Screens\Equipment\EquipmentEditScreen;
use App\Orchid\Screens\Equipment\EquipmentListScreen;
use App\Orchid\Screens\Examples\ExampleActionsScreen;
use App\Orchid\Screens\Examples\ExampleCardsScreen;
use App\Orchid\Screens\Examples\ExampleChartsScreen;
use App\Orchid\Screens\Examples\ExampleFieldsAdvancedScreen;
use App\Orchid\Screens\Examples\ExampleFieldsScreen;
use App\Orchid\Screens\Examples\ExampleGridScreen;
use App\Orchid\Screens\Examples\ExampleLayoutsScreen;
use App\Orchid\Screens\Examples\ExampleScreen;
use App\Orchid\Screens\Examples\ExampleTextEditorsScreen;
use App\Orchid\Screens\Lead\LeadEditScreen;
use App\Orchid\Screens\Lead\LeadListScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Portfolio\PortfolioEditScreen;
use App\Orchid\Screens\Portfolio\PortfolioListScreen;
use App\Orchid\Screens\Product\ProductEditScreen;
use App\Orchid\Screens\Product\ProductListScreen;
use App\Orchid\Screens\ProductCategory\ProductCategoryEditScreen;
use App\Orchid\Screens\ProductCategory\ProductCategoryListScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\Seo\SeoEditScreen;
use App\Orchid\Screens\Seo\SeoListScreen;
use App\Orchid\Screens\Service\ServiceEditScreen;
use App\Orchid\Screens\Service\ServiceListScreen;
use App\Orchid\Screens\Settings\SettingsScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use App\Orchid\Screens\User\UserProfileScreen;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/

// Leads CRM
Route::screen('leads', LeadListScreen::class)
    ->name('platform.leads.list')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.index')
            ->push('Заявки');
    });

Route::screen('leads/create', LeadEditScreen::class)
    ->name('platform.leads.create')
    ->breadcrumbs(function (Trail $trail) {
        return $trail
            ->parent('platform.leads.list')
            ->push('Создание заявки');
    });

Route::screen('leads/{lead}/edit', LeadEditScreen::class)
    ->name('platform.leads.edit')
    ->breadcrumbs(function (Trail $trail, $lead) {
        return $trail
            ->parent('platform.leads.list')
            ->push('Редактирование заявки #'.$lead->lead_number);
    });
// Роут для экспорта (обычный GET роут, не screen)
Route::get('leads/export', [LeadListScreen::class, 'export'])
    ->name('platform.leads.export');
// Settings
Route::screen('settings', SettingsScreen::class)
    ->name('platform.settings')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Настройки', route('platform.settings')));

// Services
Route::screen('services', ServiceListScreen::class)
    ->name('platform.services.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Услуги', route('platform.services.list')));

Route::screen('services/create', ServiceEditScreen::class)
    ->name('platform.services.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.services.list')
        ->push('Создать услугу', route('platform.services.create')));

Route::screen('services/{service}/edit', ServiceEditScreen::class)
    ->name('platform.services.edit')
    ->breadcrumbs(fn (Trail $trail, $service) => $trail
        ->parent('platform.services.list')
        ->push($service->title, route('platform.services.edit', $service)));

// Product Categories
Route::screen('product-categories', ProductCategoryListScreen::class)
    ->name('platform.product-categories.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Категории товаров', route('platform.product-categories.list')));

Route::screen('product-categories/create', ProductCategoryEditScreen::class)
    ->name('platform.product-categories.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.product-categories.list')
        ->push('Создать категорию', route('platform.product-categories.create')));

Route::screen('product-categories/{category}/edit', ProductCategoryEditScreen::class)
    ->name('platform.product-categories.edit')
    ->breadcrumbs(fn (Trail $trail, $category) => $trail
        ->parent('platform.product-categories.list')
        ->push($category->title, route('platform.product-categories.edit', $category)));

// Products
Route::screen('/products', ProductListScreen::class)
    ->name('platform.products.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Товары', route('platform.products.list')));

Route::screen('/products/create', ProductEditScreen::class)
    ->name('platform.products.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.products.list')
        ->push('Создать товар', route('platform.products.create')));

Route::screen('/products/{product}/edit', ProductEditScreen::class)
    ->name('platform.products.edit')
    ->breadcrumbs(fn (Trail $trail, $product) => $trail
        ->parent('platform.products.list')
        ->push($product->title, route('platform.products.edit', $product)));

// Portfolio Works
Route::screen('portfolio', PortfolioListScreen::class)
    ->name('platform.portfolio.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Портфолио', route('platform.portfolio.list')));

Route::screen('portfolio/create', PortfolioEditScreen::class)
    ->name('platform.portfolio.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.portfolio.list')
        ->push('Создать работу', route('platform.portfolio.create')));

Route::screen('portfolio/{work}/edit', PortfolioEditScreen::class)
    ->name('platform.portfolio.edit')
    ->breadcrumbs(fn (Trail $trail, $work) => $trail
        ->parent('platform.portfolio.list')
        ->push($work->title, route('platform.portfolio.edit', $work)));

// Blogs
Route::screen('blogs', BlogListScreen::class)
    ->name('platform.blogs.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Блог', route('platform.blogs.list')));

Route::screen('blogs/create', BlogEditScreen::class)
    ->name('platform.blogs.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.blogs.list')
        ->push('Создать статью', route('platform.blogs.create')));

Route::screen('blogs/{blog}/edit', BlogEditScreen::class)
    ->name('platform.blogs.edit')
    ->breadcrumbs(fn (Trail $trail, $blog) => $trail
        ->parent('platform.blogs.list')
        ->push($blog->title, route('platform.blogs.edit', $blog)));

// Equipment
Route::screen('equipment', EquipmentListScreen::class)
    ->name('platform.equipment.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Оборудование', route('platform.equipment.list')));

Route::screen('equipment/create', EquipmentEditScreen::class)
    ->name('platform.equipment.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.equipment.list')
        ->push('Добавить оборудование', route('platform.equipment.create')));

Route::screen('equipment/{equipment}/edit', EquipmentEditScreen::class)
    ->name('platform.equipment.edit')
    ->breadcrumbs(fn (Trail $trail, $equipment) => $trail
        ->parent('platform.equipment.list')
        ->push($equipment->title, route('platform.equipment.edit', $equipment)));

// Clients
Route::screen('clients', ClientListScreen::class)
    ->name('platform.clients.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Клиенты', route('platform.clients.list')));

Route::screen('clients/create', ClientEditScreen::class)
    ->name('platform.clients.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.clients.list')
        ->push('Добавить клиента', route('platform.clients.create')));

Route::screen('clients/{client}/edit', ClientEditScreen::class)
    ->name('platform.clients.edit')
    ->breadcrumbs(fn (Trail $trail, $client) => $trail
        ->parent('platform.clients.list')
        ->push($client->name, route('platform.clients.edit', $client)));

// SEO Settings
Route::screen('seo', SeoListScreen::class)
    ->name('platform.seo.list')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('SEO настройки', route('platform.seo.list')));

Route::screen('seo/create', SeoEditScreen::class)
    ->name('platform.seo.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.seo.list')
        ->push('Добавить SEO настройки', route('platform.seo.create')));

Route::screen('seo/{seo}/edit', SeoEditScreen::class)
    ->name('platform.seo.edit')
    ->breadcrumbs(fn (Trail $trail, $seo) => $trail
        ->parent('platform.seo.list')
        ->push($seo->seoable->title, route('platform.seo.edit', $seo)));
// Main
Route::screen('/main', PlatformScreen::class)
    ->name('platform.main');

// Platform > Profile
Route::screen('profile', UserProfileScreen::class)
    ->name('platform.profile')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Profile', route('platform.profile')));

// Platform > System > Users > User
Route::screen('users/{user}/edit', UserEditScreen::class)
    ->name('platform.systems.users.edit')
    ->breadcrumbs(fn (Trail $trail, $user) => $trail
        ->parent('platform.systems.users')
        ->push($user->name, route('platform.systems.users.edit', $user)));

// Platform > System > Users > Create
Route::screen('users/create', UserEditScreen::class)
    ->name('platform.systems.users.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.users')
        ->push('Создать пользователя', route('platform.systems.users.create')));

// Platform > System > Users
Route::screen('users', UserListScreen::class)
    ->name('platform.systems.users')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Пользователи', route('platform.systems.users')));

// Platform > System > Roles > Role
Route::screen('roles/{role}/edit', RoleEditScreen::class)
    ->name('platform.systems.roles.edit')
    ->breadcrumbs(fn (Trail $trail, $role) => $trail
        ->parent('platform.systems.roles')
        ->push($role->name, route('platform.systems.roles.edit', $role)));

// Platform > System > Roles > Create
Route::screen('roles/create', RoleEditScreen::class)
    ->name('platform.systems.roles.create')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.systems.roles')
        ->push('Создать роль', route('platform.systems.roles.create')));

// Platform > System > Roles
Route::screen('roles', RoleListScreen::class)
    ->name('platform.systems.roles')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Роли', route('platform.systems.roles')));

// Example...
Route::screen('example', ExampleScreen::class)
    ->name('platform.example')
    ->breadcrumbs(fn (Trail $trail) => $trail
        ->parent('platform.index')
        ->push('Example Screen'));

Route::screen('/examples/form/fields', ExampleFieldsScreen::class)->name('platform.example.fields');
Route::screen('/examples/form/advanced', ExampleFieldsAdvancedScreen::class)->name('platform.example.advanced');
Route::screen('/examples/form/editors', ExampleTextEditorsScreen::class)->name('platform.example.editors');
Route::screen('/examples/form/actions', ExampleActionsScreen::class)->name('platform.example.actions');

Route::screen('/examples/layouts', ExampleLayoutsScreen::class)->name('platform.example.layouts');
Route::screen('/examples/grid', ExampleGridScreen::class)->name('platform.example.grid');
Route::screen('/examples/charts', ExampleChartsScreen::class)->name('platform.example.charts');
Route::screen('/examples/cards', ExampleCardsScreen::class)->name('platform.example.cards');

// Route::screen('idea', Idea::class, 'platform.screens.idea');
