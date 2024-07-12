<?php

namespace App\Http\Controllers;

use App\Models\Color;
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
            'name' => 'required|max:255',
        ]);

        $color = new Color();
        $color->name = $request->name;
        $color->save();

        return redirect()->route('colors')->with('success', 'Color created successfully.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $color = Color::find($request->id);
        $color->name = $request->name;
        $color->save();

        return redirect()->route('colors')->with('success', 'Color updated successfully.');
    }
}
