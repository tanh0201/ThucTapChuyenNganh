<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of orders
     */
    public function index()
    {
        $orders = Order::with('user')
            ->latest('created_at')
            ->paginate(15);
        return view('admin.orders', ['orders' => $orders]);
    }

    /**
     * Display the specified order
     */
    public function show(Order $order)
    {
        $order->load('user', 'items.product');
        return view('admin.orders.show', ['order' => $order]);
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order->update($validated);
        return redirect("/admin/orders/{$order->id}")->with('success', 'Trạng thái đơn hàng được cập nhật');
    }

    /**
     * Delete the specified order
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect('/admin/orders')->with('success', 'Đơn hàng đã được xóa');
    }
}
