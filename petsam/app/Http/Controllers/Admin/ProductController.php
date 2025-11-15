<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products
     */
    public function index()
    {
        $products = Product::with('category')->paginate(15);
        $categories = Category::where('status', 'active')->get();
        return view('admin.products', ['products' => $products, 'categories' => $categories]);
    }

    /**
     * Show the form for creating a new product
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created product
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'status' => 'required|in:active,inactive',
        ]);

        Product::create($validated);
        return redirect('/admin/products')->with('success', 'Sản phẩm được tạo thành công');
    }

    /**
     * Display the specified product
     */
    public function show(Product $product)
    {
        return view('admin.products.show', ['product' => $product]);
    }

    /**
     * Show the form for editing the product
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', ['product' => $product]);
    }

    /**
     * Update the specified product
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'status' => 'required|in:active,inactive',
        ]);

        $product->update($validated);
        return redirect("/admin/products/{$product->id}")->with('success', 'Sản phẩm được cập nhật thành công');
    }

    /**
     * Delete the specified product
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect('/admin/products')->with('success', 'Sản phẩm đã được xóa');
    }
}
