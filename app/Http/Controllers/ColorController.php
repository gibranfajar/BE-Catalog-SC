<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Product;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $colors = Color::all();
        return view('colors.index', compact('colors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:colors',
        ]);

        $color = new Color();
        $color->name = $request->name;
        $color->save();

        return redirect()->route('colors')->with('success', 'Color created successfully.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:colors,name,' . $request->id,
        ]);

        $color = Color::find($request->id);
        $color->name = $request->name;
        $color->save();

        return redirect()->route('colors')->with('success', 'Color updated successfully.');
    }

    public function destroy($id)
    {
        $color = Color::findOrFail($id);

        // Check if there are products associated with this color
        $productsCount = Product::where('color_id', $color->id)->count();

        if ($productsCount > 0) {
            return redirect()->route('colors')->with('error', 'Cannot delete color. There are products associated with this color.');
        }

        // Delete the color if no products are associated with it
        $color->delete();

        return redirect()->route('colors')->with('success', 'Color deleted successfully.');
    }
}
