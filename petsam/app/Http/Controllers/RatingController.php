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
            'comment' => 'nullable|string',
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
            'status' => 'approved', // Display immediately without admin approval
        ]);

        return back()->with('success', 'Cảm ơn bạn đã đánh giá! Đánh giá của bạn đã được hiển thị.');
    }
}
