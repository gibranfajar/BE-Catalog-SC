<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $productImages = ProductImage::all();
        return view('productImages.index', compact('products', 'productImages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image.*' => 'required|image|mimes:png,jpg,jpeg,webp,svg'
        ]);

        $product = Product::findOrFail($request->product);

        $imageData = [];
        if ($files = $request->file('image')) {
            foreach ($files as $file) {
                $extension = $file->getClientOriginalName();
                $filename = rand() . '.' . $extension;
                $path = $file->storeAs('public/products', $filename);

                $imageData[] = [
                    'product_id' => $product->id,
                    'image' => $filename,
                ];
            }
        }

        ProductImage::insert($imageData);
        return redirect()->route('product-images')->with('success', 'Product Image Added Successfully');
    }

    public function destroy($id)
    {
        $productImage = ProductImage::findOrFail($id);

        $imagePath = storage_path('app/public/products/' . basename($productImage->image));
        if (file_exists($imagePath)) {
            @unlink($imagePath);
        }

        $productImage->delete();

        return redirect()->route('product-images')->with('success', 'Product Image Deleted Successfully');
    }
}
