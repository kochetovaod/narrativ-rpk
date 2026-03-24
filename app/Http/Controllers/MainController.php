<?php

namespace App\Http\Controllers;

use App\Models\Advantage;
use App\Models\Blog;
use App\Models\Equipment;
use App\Models\FAQ;
use App\Models\Portfolio;
use App\Models\ProductCategory;
use App\Models\Service;

class MainController extends Controller
{
    public function index()
    {
        $services = Service::all();
        $products = ProductCategory::all();
        $faqs = FAQ::limit(9)->get();
        $portfolio = Portfolio::limit(9)->get();
        $articles = Blog::limit(3)->get();
        $advantages = Advantage::all();
        $equipment = Equipment::limit(5)->get();

        return view('pages.home1', compact('services', 'products', 'equipment', 'faqs', 'portfolio', 'articles', 'advantages'));
    }
}
