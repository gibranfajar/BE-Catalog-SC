<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index()
    {
        $sizes = Size::all();
        $products = Product::all();
        return view('sizes.index', compact('sizes', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'size' => ['required'],
            'stock' => ['required']
        ]);

        $size = new Size();
        $size->product_id = $request->product;
        $size->size = $request->size;
        $size->stock = $request->stock;
        $size->save();

        return redirect()->route('sizes')->with('success', 'Size added successfully');
    }

    public function update(Request $request)
    {
        $request->validate([
            'size' => ['required'],
            'stock' => ['required']
        ]);

        $size = Size::find($request->id);
        $size->product_id = $request->product;
        $size->size = $request->size;
        $size->stock = $request->stock;
        $size->save();

        return redirect()->route('sizes')->with('success', 'Size updated successfully');
    }
}
