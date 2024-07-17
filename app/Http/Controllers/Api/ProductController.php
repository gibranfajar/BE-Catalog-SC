<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Size;

class ProductController extends Controller
{
    public function product()
    {
        $product_data = Product::all();

        if ($product_data) {
            $i = 0;
            foreach ($product_data as $product) {
                if ($product->productImages->count() > 0) {
                    $image1 = $product->productImages[3]->image;
                    $image2 = $product->productImages[2]->image;
                }
                $productitems[$i] = [
                    'id' => $product->id,
                    'product_name' => $product->name,
                    'product_slug' => $product->slug,
                    'article_name' => $product->article->name,
                    'category_name' => $product->category->name,
                    'color' => $product->color->name,
                    'price' => $product->price,
                    'price_disc' => $product->price_discount,
                    'image1' => $image1,
                    'image2' => $image2,
                ];

                $i++;
            }

            return response()->json([
                'status' => 200,
                'product_data' => $productitems,
            ])->setEncodingOptions(JSON_NUMERIC_CHECK);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Tidak Ada product',
            ]);
        }
    }

    public function productDetail($slug, $sku)
    {
        $article = Article::where('name', $sku)->first();
        $product = Product::where('slug', $slug)->where('article_id', $article->id)->first();
        $productitems = [
            'id' => $product->id,
            'product_name' => $product->name,
            'product_slug' => $product->slug,
            'article_name' => $product->article->name,
            'category_name' => $product->category->name,
            'color' => $product->color->name,
            'price' => $product->price,
            'price_disc' => $product->price_discount,
            'article_desc' => $product->article->description,
            'size_chart' => $product->article->size_chart,
        ];

        $productrelated = Product::where('category_id', $product->category_id)->get();
        $r = 0;
        foreach ($productrelated as $prore) {
            if ($prore->productImages->count() > 0) {
                $image1 = $prore->productImages[3]->image;
                $image2 = $prore->productImages[2]->image;
            }
            $related[$r] = [
                'id' => $prore->id,
                'product_name' => $prore->name,
                'product_slug' => $prore->slug,
                'category_name' => $prore->category->name,
                'price' => $prore->price,
                'price_disc' => $prore->price_discount,
                'image1' => $image1,
                'image2' => $image2,
            ];

            $r++;
        }

        $images = ProductImage::where('product_id', $product->id)->get();
        $a = 0;
        foreach ($images as $item) {
            $imageitems[$a] = [
                'id' => $item->id,
                'image' => $item->image,
            ];

            $a++;
        }

        $sizes = Size::where('product_id', $product->id)->get();
        $b = 0;
        foreach ($sizes as $item) {
            $sizeitems[$b] = [
                'id' => $item->id,
                'size' => $item->name,
                'stock' => $item->stock,
            ];
            $b++;
        }

        if ($product and $sizes) {
            return response()->json([
                'status' => 200,
                'productDetail' => $productitems,
                'productRelated' => $related,
                'data_sizes' => $sizeitems,
                'data_images' => $imageitems,

            ])->setEncodingOptions(JSON_NUMERIC_CHECK);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Product Tidak ditemukan',
            ]);
        }
    }
}
