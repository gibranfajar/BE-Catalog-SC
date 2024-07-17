<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:categories',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->save();

        return redirect()->route('categories')->with('success', 'Category created successfully.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $request->id,
        ]);

        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->save();

        return redirect()->route('categories')->with('success', 'Category updated successfully.');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Check if there are products associated with this category
        $productsCount = Product::where('category_id', $category->id)->count();

        if ($productsCount > 0) {
            return redirect()->route('categories')->with('error', 'Cannot delete category. There are products associated with this category.');
        }

        // Delete the category if no products are associated with it
        $category->delete();

        return redirect()->route('categories')->with('success', 'Category deleted successfully.');
    }
}
