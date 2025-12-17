<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\Product;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * Display list of all ratings - GET /admin/ratings
     */
    public function index(Request $request)
    {
        $query = Rating::with('user', 'product');

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by rating
        if ($request->has('rating') && $request->rating) {
            $query->where('rating', $request->rating);
        }

        // Filter by product
        if ($request->has('product') && $request->product) {
            $query->where('product_id', $request->product);
        }

        // Search by user name or comment
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($u) use ($search) {
                    $u->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
                })
                ->orWhere('comment', 'like', '%' . $search . '%');
            });
        }

        // Sort
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'rating_high':
                $query->orderBy('rating', 'desc');
                break;
            case 'rating_low':
                $query->orderBy('rating', 'asc');
                break;
            case 'latest':
            default:
                $query->latest();
                break;
        }

        $ratings = $query->paginate(15);
        $products = Product::where('status', 'active')->get();
        $stats = [
            'total' => Rating::count(),
            'pending' => Rating::where('status', 'pending')->count(),
            'approved' => Rating::where('status', 'approved')->count(),
            'rejected' => Rating::where('status', 'rejected')->count(),
        ];

        return view('admin.ratings.index', compact('ratings', 'products', 'stats'));
    }

    /**
     * Show the form for creating a new rating (not used)
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created rating (not used)
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Display the specified rating - GET /admin/ratings/{rating}
     */
    public function show(Rating $rating)
    {
        $rating->load('user', 'product');
        return view('admin.ratings.show', compact('rating'));
    }

    /**
     * Show the form for editing the specified rating
     */
    public function edit(Rating $rating)
    {
        $rating->load('user', 'product');
        return view('admin.ratings.edit', compact('rating'));
    }

    /**
     * Update the specified rating - PUT /admin/ratings/{rating}
     */
    public function update(Request $request, Rating $rating)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:5000',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $rating->update($validated);

        return redirect()->route('admin.ratings.show', $rating->id)->with('success', 'Cập nhật đánh giá thành công');
    }

    /**
     * Remove the specified rating - DELETE /admin/ratings/{rating}
     */
    public function destroy(Rating $rating)
    {
        $rating->delete();
        return redirect()->route('admin.ratings.index')->with('success', 'Xóa đánh giá thành công');
    }

    /**
     * Approve rating - Custom action
     */
    public function approve(Rating $rating)
    {
        $rating->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Duyệt đánh giá thành công');
    }

    /**
     * Reject rating - Custom action
     */
    public function reject(Rating $rating)
    {
        $rating->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Từ chối đánh giá thành công');
    }
}
