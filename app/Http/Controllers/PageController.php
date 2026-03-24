<?php

namespace App\Http\Controllers;

use App\Models\Advantage;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Client;
use App\Models\Equipment;
use App\Models\FaqCategory;
use App\Models\Material;
use App\Models\Page;
use App\Models\Portfolio;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Service;
use App\Models\Slider;
use App\Models\Tag;
use App\Models\Technology;

class PageController extends Controller
{
    // Страницы
    public function about()
    {
        $page = Page::where('slug', 'about')->first();
        if ($page) {
            $page->applySEO(url()->current());
        }
        $works = Portfolio::with('preview')->limit(5)->orderBy('sort')->get();
        $advantages = Advantage::orderBy('sort')->get();
        $stats = Slider::get();
        $clients = Client::with('preview')->get();
        $equipment = Equipment::with('preview')->limit(3)->get();

        return view('pages.about', compact('page', 'clients', 'equipment', 'stats', 'advantages', 'works'));
    }

    public function contacts()
    {
        $page = Page::where('slug', 'contacts')->first();
        if ($page) {
            $page->applySEO(url()->current());
        }

        return view('pages.contacts', compact('page'));
    }

    public function equipment()
    {
        $page = Page::where('slug', 'equipment')->first();
        if ($page) {
            $page->applySEO(url()->current());
        }
        $equipment = Equipment::with('preview')->get();
        $materials = Material::get();
        $technologies = Technology::get();

        return view('pages.equipment', compact('page', 'equipment', 'materials', 'technologies'));
    }

    public function faq()
    {
        $page = Page::where('slug', 'faq')->first();
        $categories = FaqCategory::with('questions')->orderBy('sort')->get();

        return view('pages.faq', compact('page', 'categories'));
    }

    public function privacy()
    {
        return view('pages.privacy-policy');
    }

    public function request()
    {
        return view('pages.request');
    }

    public function search()
    {
        return view('pages.search');
    }

    // Блог
    public function blogIndex()
    {
        $tags = Tag::all();
        $categories = BlogCategory::all();
        $articles = Blog::with('preview')->published()->orderBy('published_at')->get();
        $article = Blog::with('preview')->orderBy('sort')->first();
        $page = Page::where('slug', 'blog')->first();
        if ($page) {
            $page->applySEO(url()->current());
        }

        return view('pages.blog.index', compact('categories', 'tags', 'page', 'article', 'articles'));
    }

    // app/Http/Controllers/PageController.php
    public function blogShow($slug)
    {
        // Загружаем статью со всеми необходимыми связями
        $article = Blog::where('slug', $slug)
            ->with(['category', 'tags', 'employee', 'preview', 'detail'])
            ->firstOrFail();

        // Увеличиваем счетчик просмотров
        $article->increment('views');

        // Похожие статьи (из той же категории, исключая текущую)
        $relatedArticles = Blog::published()
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->with(['category', 'preview'])
            ->limit(3)
            ->orderBy('published_at', 'desc')
            ->get();

        // Если похожих статей меньше 3, добираем последние
        if ($relatedArticles->count() < 3) {
            $latestArticles = Blog::published()
                ->where('id', '!=', $article->id)
                ->with(['category', 'preview'])
                ->limit(3 - $relatedArticles->count())
                ->orderBy('published_at', 'desc')
                ->get();

            $relatedArticles = $relatedArticles->concat($latestArticles);
        }

        return view('pages.blog.show', compact('article', 'relatedArticles'));
    }

    // Каталог
    public function catalogIndex()
    {
        $categories = ProductCategory::with('preview')->get();
        $portfolios = Portfolio::all();

        return view('pages.catalog.index', compact('categories', 'portfolios'));
    }

    public function catalogCategory(ProductCategory $category)
    {
        $category->load('filters');
        $products = Product::where('category_id', $category->id)->get();
        $portfolios = Portfolio::all();

        return view('pages.catalog.category', compact('category', 'products', 'portfolios'));
    }

    public function catalogShow(ProductCategory $category, Product $product)
    {
        $portfolios = Portfolio::all();

        return view('pages.catalog.show', ['category' => $category, 'product' => $product]);
    }

    // Портфолио
    public function portfolioIndex()
    {

        $page = Page::where('slug', 'portfolio')->first();
        if ($page) {
            $page->applySEO(url()->current());
        }
        $works = Portfolio::with('services', 'products')->get();
        $allServices = $works->flatMap(function ($work) {
            return $work->services;
        })->unique('id');

        // Собираем все уникальные продукты из всех работ
        $allProducts = $works->flatMap(function ($work) {
            return $work->products;
        })->unique('id');

        return view('pages.portfolio.index', compact('page', 'works', 'allServices', 'allProducts'));
    }

    public function portfolioShow(Portfolio $project)
    {
        $relatedProjects = Portfolio::with(['services', 'preview'])
            ->where('id', '!=', $project->id)
            ->where(function ($query) use ($project) {
                // Ищем по тем же услугам
                if ($project->services->isNotEmpty()) {
                    $query->whereHas('services', function ($q) use ($project) {
                        $q->whereIn('services.id', $project->services->pluck('id'));
                    });
                }
                // Или по тем же продуктам
                if ($project->products->isNotEmpty()) {
                    $query->orWhereHas('products', function ($q) use ($project) {
                        $q->whereIn('products.id', $project->products->pluck('id'));
                    });
                }
            })
            ->limit(3)
            ->get();

        return view('pages.portfolio.show', compact('project', 'relatedProjects'));
    }

    // Услуги
    public function servicesIndex()
    {
        $page = Page::where('slug', 'services')->first();
        if ($page) {
            $page->applySEO(url()->current());
        }
        $services = Service::with('preview')->get();

        return view('pages.services.index', compact('page', 'services'));
    }

    public function servicesShow(Service $service)
    {
        $services = Service::with('preview')->get();

        return view('pages.services.show', compact('service', 'services'));
    }

    // Лендинги
    public function landingLaser()
    {
        return view('pages.landing.laser-cutting');
    }
}
