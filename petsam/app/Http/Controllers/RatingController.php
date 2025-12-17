<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Product;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * Store a new rating - POST /ratings
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|min:10',
        ]);

        // Check if user already rated this product
        $existingRating = Rating::where('user_id', auth()->user()->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingRating) {
            return back()->with('error', 'Bạn đã đánh giá sản phẩm này rồi!');
        }

        // Create rating
        Rating::create([
            'user_id' => auth()->user()->id,
            'product_id' => $request->product_id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'status' => 'pending', // Need admin approval
        ]);

        return back()->with('success', 'Cảm ơn bạn đã đánh giá! Admin sẽ kiểm duyệt trong thời gian sớm.');
    }
}
