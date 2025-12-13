<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories
     */
    public function index()
    {
        $categories = Category::paginate(15);
        return view('admin.categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new category
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created category
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        $validated['slug'] = \Illuminate\Support\Str::slug($validated['name']);
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . \Illuminate\Support\Str::slug($validated['name']) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/categories'), $imageName);
            $validated['image'] = 'img/categories/' . $imageName;
        }

        Category::create($validated);
        
        return redirect('/admin/categories')->with('success', 'Danh mục được tạo thành công');
    }

    /**
     * Display the specified category
     */
    public function show(Category $category)
    {
        return redirect('/admin/categories');
    }

    /**
     * Show the form for editing the category
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', ['category' => $category]);
    }

    /**
     * Update the specified category
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . \Illuminate\Support\Str::slug($validated['name']) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/categories'), $imageName);
            $validated['image'] = 'img/categories/' . $imageName;
        }

        $category->update($validated);
        return redirect('/admin/categories')->with('success', 'Danh mục được cập nhật thành công');
    }

    /**
     * Delete the specified category
     */
    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return redirect('/admin/categories')->with('error', 'Không thể xóa danh mục có sản phẩm');
        }
        
        // Delete image if exists
        if ($category->image && file_exists(public_path($category->image))) {
            unlink(public_path($category->image));
        }
        
        $category->delete();
        return redirect('/admin/categories')->with('success', 'Danh mục đã được xóa');
    }
}
