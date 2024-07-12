<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $articles = Article::count();
        $products = Product::count();
        $categories = Category::count();
        $colors = Color::count();

        return view('dashboard.index', compact('articles', 'products', 'categories', 'colors'));
    }
}
