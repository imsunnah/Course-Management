<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::latest()->paginate(10);
            return view('category.index', compact('categories'));
        } catch (\Throwable $e) {
            \Log::error('Category Index Error: ' . $e->getMessage());
            return redirect()->route('error.page');
        }
    }

public function store(Request $request)
{
    try {
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        // Create category with default status active
        Category::create([
            'name' => $request->name,
            'status' => $request->status ?? 1, // default to Active
        ]);

        return redirect()->back()->with('success', 'Category created successfully!');

    } catch (ValidationException $e) {
        // Handle duplicate name or other validation errors
        return redirect()->back()
            ->withErrors($e->errors())
            ->withInput();

    } catch (\Throwable $e) {
        \Log::error('Category Store Error: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Something went wrong while creating the category.');
    }
}


    public function edit(Category $category)
    {
        try {
            return response()->json($category);
        } catch (\Throwable $e) {
            \Log::error('Category Edit Error: ' . $e->getMessage());
            return redirect()->route('error.page');
        }
    }

    public function update(Request $request, Category $category)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            ]);

            $category->update([
                'name' => $request->name,
                'status' => $request->status ?? 1,
            ]);

            return redirect()->back()->with('success', 'Category updated successfully!');
        } catch (\Throwable $e) {
            \Log::error('Category Update Error: ' . $e->getMessage());
            return redirect()->route('error.page');
        }
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();
            return redirect()->back()->with('success', 'Category deleted successfully!');
        } catch (\Throwable $e) {
            \Log::error('Category Delete Error: ' . $e->getMessage());
            return redirect()->route('error.page');
        }
    }

    public function toggleStatus(Category $category)
    {
        try {
            $category->status = !$category->status;
            $category->save();
            return redirect()->back()->with('success', 'Category status updated!');
        } catch (\Throwable $e) {
            \Log::error('Category Toggle Status Error: ' . $e->getMessage());
            return redirect()->route('error.page');
        }
    }
}
