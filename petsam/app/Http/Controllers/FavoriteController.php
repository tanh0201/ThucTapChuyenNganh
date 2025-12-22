<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get user's favorites
     */
    public function index()
    {
        $favorites = Auth::user()->favorites()->with('product')->get();
        return view('home.favorites', compact('favorites'));
    }

    /**
     * Toggle favorite (Add/Remove)
     */
    public function toggle(Product $product)
    {
        $favorite = Favorite::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($favorite) {
            // Remove from favorites
            $favorite->delete();
            return response()->json([
                'success' => true,
                'message' => 'Đã xóa khỏi yêu thích',
                'isFavorited' => false
            ]);
        } else {
            // Add to favorites
            Favorite::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Đã thêm vào yêu thích',
                'isFavorited' => true
            ]);
        }
    }

    /**
     * Check if product is favorited
     */
    public function check(Product $product)
    {
        if (!Auth::check()) {
            return response()->json(['isFavorited' => false]);
        }

        $isFavorited = Favorite::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->exists();

        return response()->json(['isFavorited' => $isFavorited]);
    }

    /**
     * Remove favorite
     */
    public function destroy(Product $product)
    {
        Favorite::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->delete();

        return response()->json(['success' => true, 'message' => 'Đã xóa khỏi yêu thích']);
    }
}
