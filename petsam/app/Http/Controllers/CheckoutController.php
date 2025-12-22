<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Mail\OrderConfirmationMail;
use App\Mail\NewOrderNotificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show checkout form
     */
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('warning', 'Giỏ hàng của bạn trống');
        }

        $cartItems = [];
        $totalPrice = 0;

        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                $itemTotal = $product->price * $item['quantity'];
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'total' => $itemTotal,
                ];
                $totalPrice += $itemTotal;
            }
        }

        $user = Auth::user();

        return view('home.checkout', [
            'cartItems' => $cartItems,
            'totalPrice' => $totalPrice,
            'user' => $user,
        ]);
    }

    /**
     * Process checkout and create order
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:500',
            'payment_method' => 'required|in:cod,bank_transfer',
            'notes' => 'nullable|string|max:500',
        ], [
            'name.required' => 'Vui lòng nhập tên',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'shipping_address.required' => 'Vui lòng nhập địa chỉ giao hàng',
            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn trống');
        }

        try {
            DB::beginTransaction();

            $totalPrice = 0;
            $orderItems = [];

            // Validate and prepare order items
            foreach ($cart as $productId => $item) {
                $product = Product::find($productId);

                if (!$product || $product->status !== 'active') {
                    throw new \Exception('Sản phẩm không còn khả dụng');
                }

                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Sản phẩm {$product->name} không đủ số lượng trong kho");
                }

                $itemTotal = $product->price * $item['quantity'];
                $totalPrice += $itemTotal;

                $orderItems[$productId] = [
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'total' => $itemTotal,
                ];

                // Reduce stock
                $product->decrement('stock', $item['quantity']);
                $product->updateStockStatus();
            }

            // Determine initial payment status
            $paymentStatus = 'pending';
            if ($request->payment_method === 'cod') {
                $paymentStatus = 'pending'; // COD: pending until user pays
            } elseif ($request->payment_method === 'bank_transfer') {
                $paymentStatus = 'pending'; // Bank: pending until admin confirms
            }

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => Order::generateOrderNumber(),
                'total_price' => $totalPrice,
                'shipping_address' => $request->shipping_address,
                'phone' => $request->phone,
                'notes' => $request->notes,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'payment_status' => $paymentStatus,
                'payment_ip' => $request->ip(),
            ]);

            // Create order items
            foreach ($orderItems as $productId => $itemData) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $itemData['quantity'],
                    'price' => $itemData['price'],
                    'total' => $itemData['total'],
                ]);
            }

            DB::commit();

            // Clear cart
            session()->forget('cart');

            // Send confirmation email to customer
            try {
                Mail::to($order->user->email)->send(new OrderConfirmationMail($order));
            } catch (\Exception $e) {
                Log::error('Failed to send order confirmation email: ' . $e->getMessage());
            }

            // Send notification email to admin
            try {
                $adminEmail = config('mail.from.address') ?? env('ADMIN_EMAIL', 'admin@petsam.local');
                Mail::to($adminEmail)->send(new NewOrderNotificationMail($order));
            } catch (\Exception $e) {
                Log::error('Failed to send new order notification to admin: ' . $e->getMessage());
            }

            // Handle payment method
            if ($request->payment_method === 'bank_transfer') {
                // Show bank transfer details
                return redirect()->route('checkout.bank-transfer', $order->id);
            } else {
                // COD - show success
                return redirect()->route('checkout.success', $order->id)->with('success', 'Đặt hàng thành công');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Show bank transfer details
     */
    public function bankTransferInfo(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $bankInfo = config('payment.bank');

        return view('home.bank-transfer', compact('order', 'bankInfo'));
    }

    /**
     * Show order success page
     */
    public function success($orderId)
    {
        $order = Order::with('orderItems.product', 'user')->find($orderId);

        if (!$order || $order->user_id !== Auth::id()) {
            abort(404);
        }

        return view('home.order-success', compact('order'));
    }

    /**
     * Show order details (user's own orders only)
     */
    public function show($orderId)
    {
        $order = Order::with('orderItems.product', 'user')->find($orderId);

        if (!$order || $order->user_id !== Auth::id()) {
            abort(404);
        }

        return view('home.order-detail', compact('order'));
    }

    /**
     * List user's orders
     */
    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('home.my-orders', compact('orders'));
    }

    /**
     * Cancel order
     */
    public function cancel(Request $request, $orderId)
    {
        $order = Order::find($orderId);

        if (!$order || $order->user_id !== Auth::id()) {
            abort(404);
        }

        if (in_array($order->status, ['shipped', 'delivered', 'cancelled'])) {
            return back()->with('error', 'Không thể hủy đơn hàng này');
        }

        try {
            DB::beginTransaction();

            // Restore stock
            foreach ($order->orderItems as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                    $item->product->updateStockStatus();
                }
            }

            $order->update(['status' => 'cancelled']);

            DB::commit();

            return back()->with('success', 'Đơn hàng đã được hủy thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Có lỗi xảy ra');
        }
    }
}
