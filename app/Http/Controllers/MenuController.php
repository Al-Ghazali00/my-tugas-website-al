<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::latest()->paginate(10);
        return view('menus.index', compact('menus'));
    }

    public function create() { return view('menus.create'); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=>'required|string|max:100',
            'category'=>'required|in:makanan,minuman',
            'price'=>'required|numeric|min:0',
            'description'=>'nullable|string'
        ]);
        Menu::create($data);
        return redirect()->route('menus.index')->with('ok','Menu ditambahkan.');
    }

    public function edit(Menu $menu) { return view('menus.edit', compact('menu')); }

    public function update(Request $request, Menu $menu)
    {
        $data = $request->validate([
            'name'=>'required|string|max:100',
            'category'=>'required|in:makanan,minuman',
            'price'=>'required|numeric|min:0',
            'description'=>'nullable|string'
        ]);
        $menu->update($data);
        return redirect()->route('menus.index')->with('ok','Menu diperbarui.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return back()->with('ok','Menu dihapus.');
    }
}
