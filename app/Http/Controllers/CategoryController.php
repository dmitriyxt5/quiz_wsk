<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('categories.index', ['categories' => Category::all()]);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required|string|min:3|max:255']);
        Category::create($request->only('title'));
        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', ['category' => $category]);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate(['title' => 'required|string|min:3|max:255']);
        $category->update($request->only('title'));
        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }
}
