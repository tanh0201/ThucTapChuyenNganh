<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display categories page with optional filtering
     */
    public function index(Request $request)
    {
        $query = Category::where('status', 'active');

        // Search by category name
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by category ID to show products in that category
        $selectedCategory = null;
        if ($request->has('cat') && $request->cat) {
            $selectedCategory = Category::find($request->cat);
            $products = Product::where('category_id', $request->cat)
                ->where('status', 'active')
                ->paginate(12);
        } else {
            $products = null;
        }

        $categories = $query->orderBy('name')->get();
        $totalCategories = $categories->count();

        // Add product count to each category
        $categories->each(function ($category) {
            $category->products_count = Product::where('category_id', $category->id)
                ->where('status', 'active')
                ->count();
        });

        return view('home.categories', compact('categories', 'products', 'selectedCategory', 'totalCategories'));
    }

    /**
     * Get category with its products
     */
    public function getProducts(Category $category, Request $request)
    {
        if ($category->status !== 'active') {
            return abort(404);
        }

        $query = Product::where('category_id', $category->id)
            ->where('status', 'active');

        // Price filter
        if ($request->has('min_price') && $request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sort
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12);
        $categories = Category::where('status', 'active')->orderBy('name')->get();
        
        // Add product count to each category
        $categories->each(function ($cat) {
            $cat->products_count = Product::where('category_id', $cat->id)
                ->where('status', 'active')
                ->count();
        });

        return view('home.categories', [
            'selectedCategory' => $category,
            'products' => $products,
            'categories' => $categories,
            'totalCategories' => $categories->count()
        ]);
    }
}
