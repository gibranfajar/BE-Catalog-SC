<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $articles = Article::all();
        $categories = Category::all();
        $colors = Color::all();
        return view('products.index', compact('products', 'articles', 'colors', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'sku' => ['required'],
            'price' => ['required'],
            'price_disc' => ['required']
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->article_id = $request->article;
        $product->category_id = $request->category;
        $product->color_id = $request->color;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->price_discount = $request->price_disc;
        $product->save();

        return redirect()->route('products')->with('success', 'Product created successfully');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'sku' => ['required'],
            'price' => ['required'],
            'price_disc' => ['required']
        ]);

        $product = Product::find($request->id);
        $product->name = $request->name;
        $product->slug = Str::slug($request->name);
        $product->article_id = $request->article;
        $product->category_id = $request->category;
        $product->color_id = $request->color;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->price_discount = $request->price_disc;
        $product->save();

        return redirect()->route('products')->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return redirect()->route('products')->with('success', 'Product deleted successfully');
    }
}
