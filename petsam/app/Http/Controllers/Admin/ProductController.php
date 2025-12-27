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
    public function index(Request $request)
    {
        $query = Product::with('category');
        
        // Filter by category if provided
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        
        $products = $query->paginate(15);
        $categories = Category::where('status', 'active')->get();
        
        return view('admin.products.index', [
            'products' => $products, 
            'categories' => $categories,
            'selectedCategory' => $request->category_id ?? null
        ]);
    }

    /**
     * Show the form for creating a new product
     */
    public function create()
    {
        $categories = Category::where('status', 'active')->get();
        return view('admin.products.create', ['categories' => $categories]);
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . \Illuminate\Support\Str::slug($validated['name']) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/products'), $imageName);
            $validated['image'] = 'img/products/' . $imageName;
        }

        Product::create($validated);
        return redirect('/admin/products')->with('success', 'Sản phẩm được tạo thành công');
    }

    /**
     * Display the specified product
     */
    public function show(Product $product)
    {
        return redirect('/admin/products');
    }

    /**
     * Show the form for editing the product
     */
    public function edit(Product $product)
    {
        $categories = Category::where('status', 'active')->get();
        return view('admin.products.edit', ['product' => $product, 'categories' => $categories]);
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . \Illuminate\Support\Str::slug($validated['name']) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('img/products'), $imageName);
            $validated['image'] = 'img/products/' . $imageName;
        }

        $product->update($validated);
        return redirect('/admin/products')->with('success', 'Sản phẩm được cập nhật thành công');
    }

    /**
     * Delete the specified product
     */
    public function destroy(Product $product)
    {
        // Delete image if exists
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }
        
        $product->delete();
        return redirect('/admin/products')->with('success', 'Sản phẩm đã được xóa');
    }

    /**
     * Toggle product status (hide/show when out of stock)
     */
    public function toggleStatus(Product $product)
    {
        $newStatus = $product->status === 'active' ? 'inactive' : 'active';
        $product->update(['status' => $newStatus]);

        $message = $newStatus === 'active' ? 'Sản phẩm đã được hiển thị' : 'Sản phẩm đã được ẩn';
        return back()->with('success', $message);
    }
}
