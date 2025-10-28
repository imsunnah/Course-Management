<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;




class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('category.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create([
            'name' => $request->name,
            'status' => $request->status ?? 1,
        ]);

        return redirect()->back()->with('success', 'Category created successfully!');
    }

    public function edit(Category $category)
    {
        return response()->json($category);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update([
            'name' => $request->name,
            'status' => $request->status ?? 1,
        ]);

        return redirect()->back()->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully!');
    }

    public function toggleStatus(Category $category)
    {
        $category->status = !$category->status;
        $category->save();
        return redirect()->back()->with('success', 'Category status updated!');
    }
}
