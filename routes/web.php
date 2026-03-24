<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

// Главная страница
Route::get('/', [MainController::class, 'index'])->name('home');

// Страницы
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contacts', [PageController::class, 'contacts'])->name('contacts');
Route::get('/equipment', [PageController::class, 'equipment'])->name('equipment');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/request', [PageController::class, 'request'])->name('request');
Route::get('/search', [PageController::class, 'search'])->name('search');

// Блог
Route::get('/blog', [PageController::class, 'blogIndex'])->name('blog.index');
Route::get('/blog/{post:slug}', [PageController::class, 'blogShow'])->name('blog.show');

// Каталог
Route::get('/catalog', [PageController::class, 'catalogIndex'])->name('catalog.index');
Route::get('/catalog/{category:slug}', [PageController::class, 'catalogCategory'])->name('catalog.category');
Route::get('/catalog/{category:slug}/{product:slug}', [PageController::class, 'catalogShow'])->name('catalog.show');

// Портфолио
Route::get('/portfolio', [PageController::class, 'portfolioIndex'])->name('portfolio.index');
Route::get('/portfolio/{project:slug}', [PageController::class, 'portfolioShow'])->name('portfolio.show');

// Услуги
Route::get('/services', [PageController::class, 'servicesIndex'])->name('services.index');
Route::get('/services/{service:slug}', [PageController::class, 'servicesShow'])->name('services.show');

// Лендинги
Route::get('/laser-cutting', [PageController::class, 'landingLaser'])->name('landing.laser');
