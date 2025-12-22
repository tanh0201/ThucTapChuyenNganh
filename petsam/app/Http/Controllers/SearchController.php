<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Display search results for products and categories
     */
    public function index(Request $request)
    {
        $query = $request->get('q', '');
        
        if (empty($query)) {
            return redirect()->route('shop');
        }

        // Search products with filters
        $products = Product::with('category')
            ->where('status', 'active')
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                  ->orWhere('description', 'like', '%' . $query . '%');
            });

        // Filter by category
        if ($request->has('category') && $request->category) {
            $products->where('category_id', $request->category);
        }

        // Filter by price range
        if ($request->has('min_price') && $request->min_price) {
            $products->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price) {
            $products->where('price', '<=', $request->max_price);
        }

        // Sort
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $products->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $products->orderBy('price', 'desc');
                break;
            case 'popular':
                $products->orderBy('views', 'desc');
                break;
            case 'rating':
                $products->orderBy('rating', 'desc');
                break;
            default:
                $products->latest();
        }

        $products = $products->paginate(12);

        // Search categories
        $categories = Category::where('status', 'active')
            ->where('name', 'like', '%' . $query . '%')
            ->get();

        // Get all categories for filter sidebar
        $allCategories = Category::where('status', 'active')->get();

        return view('home.search-results', compact('products', 'categories', 'allCategories', 'query'));
    }
}
