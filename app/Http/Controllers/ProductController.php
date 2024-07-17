<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        $productsData = [];
        foreach ($products as $product) {
            $image = $product->productImages->count() > 0 ? $product->productImages->last()->image : 'default.jpg';
            $sizes = $product->sizes->map(function ($size) {
                return [
                    'name' => $size->name,
                    'stock' => $size->stock,
                ];
            });

            $productsData[] = [
                'id' => $product->id,
                'name' => $product->name,
                'article' => $product->article->name,
                'category' => $product->category->name,
                'color' => $product->color->name,
                'sizes' => $sizes,
                'price' => $product->price,
                'price_disc' => $product->price_discount,
                'image' => $image,
            ];
        }

        return view('products.index', compact('productsData'));
    }


    public function add()
    {
        $categories = Category::all();
        $colors = Color::all();
        return view('products.addProduct', compact('categories', 'colors'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required',
            'article' => 'required',
            'description' => 'required',
            'size_chart' => 'required',
            'category' => 'required',
            'color' => 'required',
            'size.*' => 'required',
            'stock.*' => 'required|numeric',
            'image.*' => 'required|image|mimes:png,jpg,jpeg,webp,svg',
            'price' => 'required|numeric',
            'price_disc' => 'required|numeric'
        ]);

        // Check if the article already exists
        $existingArticle = Article::where(
            'name',
            $request->article
        )->first();

        if (!$existingArticle) {
            // Create a new article if it doesn't exist
            $article = Article::create([
                'name' => $request->article,
                'description' => $request->description,
                'size_chart' => $request->size_chart,
            ]);
        } else {
            // Use the existing article
            $article = $existingArticle;
        }


        // Create a new product
        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'article_id' => $article->id,
            'category_id' => $request->category,
            'color_id' => $request->color,
            'price' => $request->price,
            'price_discount' => $request->price_disc,
        ]);

        // Create sizes
        $sizes = [];
        foreach ($request->size as $index => $size) {
            $sizes[] = [
                'product_id' => $product->id,
                'name' => $size,
                'stock' => $request->stock[$index],
            ];
        }
        Size::insert($sizes);

        // Save images
        if ($files = $request->file('image')) {
            $imageData = [];

            foreach ($files as $file) {
                $extension = $file->getClientOriginalName();
                $filename = rand() . '.' . $extension;
                $file->storeAs('public/products', $filename);

                $imageData[] = [
                    'product_id' => $product->id,
                    'image' => 'storage/products/' . $filename,
                ];
            }

            ProductImage::insert($imageData);
        }

        // Redirect with success message
        return redirect()->route('products')->with('success', 'Product created successfully');
    }


    public function edit($id)
    {
        $product = Product::with('article', 'category', 'color', 'sizes', 'productImages')->find($id);
        $categories = Category::all();
        $colors = Color::all();

        return view('products.editProduct', compact('product', 'categories', 'colors'));
    }



    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required',
            'article' => 'required',
            'description' => 'required',
            'size_chart' => 'required',
            'category' => 'required',
            'color' => 'required',
            'size.*' => 'required',
            'stock.*' => 'required|numeric',
            'image.*' => 'image|mimes:png,jpg,jpeg,webp,svg', // 'image.*' tidak wajib karena bisa tidak mengganti gambar
            'price' => 'required|numeric',
            'price_disc' => 'required|numeric'
        ]);

        // Check if the article already exists
        $existingArticle = Article::where('name', $request->article)->first();

        if (!$existingArticle) {
            // Create a new article if it doesn't exist
            $article = Article::create([
                'name' => $request->article,
                'description' => $request->description,
                'size_chart' => $request->size_chart,
            ]);
        } else {
            // Update the existing article
            $existingArticle->update([
                'description' => $request->description,
                'size_chart' => $request->size_chart,
            ]);
            $article = $existingArticle;
        }

        // Find the existing product
        $product = Product::findOrFail($id);

        // Update product details
        $product->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'article_id' => $article->id,
            'category_id' => $request->category,
            'color_id' => $request->color,
            'price' => $request->price,
            'price_discount' => $request->price_disc,
        ]);

        // Update sizes
        // First, delete the existing sizes
        $product->sizes()->delete();

        // Then, insert the new sizes
        $sizes = [];
        foreach ($request->size as $index => $size) {
            $sizes[] = [
                'product_id' => $product->id,
                'name' => $size,
                'stock' => $request->stock[$index],
            ];
        }
        Size::insert($sizes);

        // Save new images if there are any
        if ($files = $request->file('image')) {
            $imageData = [];

            // Delete the old images from storage and database
            $oldImages = $product->productImages;
            foreach ($oldImages as $oldImage) {
                // Delete from storage
                $imagePath = str_replace('storage', 'public', $oldImage->image);
                if (Storage::exists($imagePath)) {
                    Storage::delete($imagePath);
                }
                // Delete from database
                $oldImage->delete();
            }

            // Save the new images
            foreach ($files as $file) {
                $extension = $file->getClientOriginalName();
                $filename = rand() . '.' . $extension;
                $file->storeAs('public/products', $filename);

                $imageData[] = [
                    'product_id' => $product->id,
                    'image' => 'storage/products/' . $filename,
                ];
            }

            ProductImage::insert($imageData);
        }

        // Redirect with success message
        return redirect()->route('products')->with('success', 'Product updated successfully');
    }


    public function destroy($id)
    {
        // Find the product
        $product = Product::with('productImages', 'sizes', 'article')->findOrFail($id);

        // Delete images from storage and database
        $oldImages = $product->productImages;
        foreach ($oldImages as $oldImage) {
            // Delete from storage
            $imagePath = str_replace('storage', 'public', $oldImage->image);
            if (Storage::exists($imagePath)) {
                Storage::delete($imagePath);
            }
            // Delete from database
            $oldImage->delete();
        }

        // Delete sizes from database
        $product->sizes()->delete();

        // Check if the article is associated with other products
        $article = $product->article;
        if ($article->products()->count() == 1) {
            // If the article is only associated with this product, delete it
            $article->delete();
        }

        // Delete the product
        $product->delete();

        // Redirect with success message
        return redirect()->route('products')->with('success', 'Product deleted successfully');
    }
}
