<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Mail\OrderStatusUpdatedMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of orders
     */
    public function index(Request $request)
    {
        $query = Order::with('user', 'orderItems');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Search by order number or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('order_number', 'like', "%{$search}%")
                  ->orWhere('shipping_address', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('email', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%");
                  });
        }

        $orders = $query->latest()->paginate(15);

        return view('admin.orders.index', [
            'orders' => $orders,
            'statuses' => [
                'pending' => 'Chờ xử lý',
                'confirmed' => 'Đã xác nhận',
                'processing' => 'Đang xử lý',
                'shipped' => 'Đã gửi',
                'delivered' => 'Đã giao',
                'cancelled' => 'Đã hủy',
            ],
            'paymentStatuses' => [
                'pending' => 'Chờ thanh toán',
                'paid' => 'Đã thanh toán',
                'failed' => 'Thất bại',
                'refunded' => 'Đã hoàn tiền',
            ],
        ]);
    }

    /**
     * Show order details
     */
    public function show(Order $order)
    {
        $order->load('user', 'orderItems.product');

        return view('admin.orders.show', [
            'order' => $order,
            'statuses' => [
                'pending' => 'Chờ xử lý',
                'confirmed' => 'Đã xác nhận',
                'processing' => 'Đang xử lý',
                'shipped' => 'Đã gửi',
                'delivered' => 'Đã giao',
                'cancelled' => 'Đã hủy',
            ],
            'paymentStatuses' => [
                'pending' => 'Chờ thanh toán',
                'paid' => 'Đã thanh toán',
                'failed' => 'Thất bại',
                'refunded' => 'Đã hoàn tiền',
            ],
        ]);
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled',
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        // Restore stock if cancelled
        if ($request->status === 'cancelled' && $oldStatus !== 'cancelled') {
            foreach ($order->orderItems as $item) {
                $item->product->increment('stock', $item->quantity);
            }
        }

        // Send email notification
        try {
            Mail::to($order->user->email)->send(new OrderStatusUpdatedMail($order));
        } catch (\Exception $e) {
            \Log::error('Failed to send order status email: ' . $e->getMessage());
        }

        return back()->with('success', 'Cập nhật trạng thái đơn hàng thành công');
    }

    /**
     * Update payment status
     */
    public function updatePaymentStatus(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,failed,refunded',
        ]);

        $order->update(['payment_status' => $request->payment_status]);

        return back()->with('success', 'Cập nhật trạng thái thanh toán thành công');
    }

    /**
     * Delete order
     */
    public function destroy(Order $order)
    {
        if ($order->status !== 'cancelled' && $order->status !== 'delivered') {
            return back()->with('error', 'Chỉ có thể xóa đơn hàng đã hủy hoặc đã giao');
        }

        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Xóa đơn hàng thành công');
    }
}
