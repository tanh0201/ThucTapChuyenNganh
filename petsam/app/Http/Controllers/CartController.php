<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display cart contents
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $totalPrice = 0;

        if (!empty($cart)) {
            foreach ($cart as $productId => $item) {
                $product = Product::find($productId);
                if ($product) {
                    $cartItems[] = [
                        'product' => $product,
                        'quantity' => $item['quantity'],
                        'total' => $product->price * $item['quantity'],
                    ];
                    $totalPrice += $product->price * $item['quantity'];
                }
            }
        }

        return view('home.cart', [
            'cartItems' => $cartItems,
            'totalPrice' => $totalPrice,
            'cartCount' => count($cart),
        ]);
    }

    /**
     * Add product to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        $productId = $request->product_id;
        $quantity = $request->quantity;

        $product = Product::find($productId);

        // Check stock
        if ($product->stock < $quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Số lượng sản phẩm không đủ trong kho',
            ], 422);
        }

        $cart = session()->get('cart', []);

        // If product already in cart, increase quantity
        if (isset($cart[$productId])) {
            if ($product->stock < $cart[$productId]['quantity'] + $quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Số lượng sản phẩm không đủ trong kho',
                ], 422);
            }
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Thêm vào giỏ hàng thành công',
            'cartCount' => count($cart),
        ]);
    }

    /**
     * Update product quantity in cart
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        $productId = $request->product_id;
        $quantity = $request->quantity;

        $product = Product::find($productId);

        // Check stock
        if ($product->stock < $quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Số lượng sản phẩm không đủ trong kho',
            ], 422);
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật giỏ hàng thành công',
        ]);
    }

    /**
     * Remove product from cart
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $cart = session()->get('cart', []);
        $productId = $request->product_id;

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'message' => 'Xóa khỏi giỏ hàng thành công',
            'cartCount' => count($cart),
        ]);
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        session()->forget('cart');

        return response()->json([
            'success' => true,
            'message' => 'Giỏ hàng đã được xóa',
            'cartCount' => 0,
        ]);
    }

    /**
     * Get cart count for header
     */
    public function getCount()
    {
        $cart = session()->get('cart', []);
        return response()->json([
            'count' => count($cart),
        ]);
    }
}
