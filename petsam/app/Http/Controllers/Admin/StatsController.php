<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatsController extends Controller
{
    public function index()
    {
        $startDate = now()->subDays(30);
        $endDate = now();

        // Tổng thống kê
        $stats = [
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'total_orders' => Order::count(),
            'total_users' => User::count(),
            'total_revenue' => Order::sum('total_amount'),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'completed_orders' => Order::where('status', 'completed')->count(),
        ];

        // Doanh thu theo ngày trong 30 ngày
        $dailyRevenue = Order::where('created_at', '>=', $startDate)
            ->where('created_at', '<=', $endDate)
            ->selectRaw('DATE(created_at) as date, SUM(total_amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $revenueChart = [
            'labels' => $dailyRevenue->map(fn($item) => Carbon::parse($item->date)->format('d/m')),
            'data' => $dailyRevenue->map(fn($item) => $item->total / 1000000),
        ];

        // Doanh thu theo danh mục
        $categoryRevenue = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->selectRaw('categories.name, COUNT(order_items.id) as total_sold, SUM(order_items.price * order_items.quantity) as revenue')
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('revenue')
            ->limit(10)
            ->get();

        $categoryChart = [
            'labels' => $categoryRevenue->pluck('name'),
            'data' => $categoryRevenue->map(fn($item) => $item->revenue / 1000000),
        ];

        // Sản phẩm bán chạy
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->selectRaw('products.id, products.name, COUNT(order_items.id) as total_sold, SUM(order_items.price * order_items.quantity) as revenue')
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();

        // Trạng thái đơn hàng
        $orderStatus = Order::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->mapWithKeys(fn($item) => [
                $item->status => $item->count
            ])
            ->toArray();

        // Đơn hàng theo ngày
        $dailyOrders = Order::where('created_at', '>=', $startDate)
            ->where('created_at', '<=', $endDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $ordersChart = [
            'labels' => $dailyOrders->map(fn($item) => Carbon::parse($item->date)->format('d/m')),
            'data' => $dailyOrders->map(fn($item) => $item->count),
        ];

        // Tăng trưởng doanh thu (so sánh với tháng trước)
        $prevMonthStart = now()->subMonth()->startOfMonth();
        $prevMonthEnd = now()->subMonth()->endOfMonth();
        $currentMonthStart = now()->startOfMonth();
        $currentMonthEnd = now()->endOfMonth();

        $prevMonthRevenue = Order::whereBetween('created_at', [$prevMonthStart, $prevMonthEnd])
            ->sum('total_amount');
        $currentMonthRevenue = Order::whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->sum('total_amount');

        $revenueGrowth = $prevMonthRevenue > 0
            ? (($currentMonthRevenue - $prevMonthRevenue) / $prevMonthRevenue) * 100
            : 0;

        // Người dùng mới
        $newUsers = User::where('created_at', '>=', now()->subDays(30))->count();

        // Doanh thu theo phương thức thanh toán
        $paymentMethods = Order::selectRaw('payment_method, COUNT(*) as count, SUM(total_amount) as revenue')
            ->groupBy('payment_method')
            ->get();

        // Doanh thu theo trạng thái đơn hàng
        $revenueByStatus = Order::selectRaw('status, SUM(total_amount) as revenue')
            ->groupBy('status')
            ->get()
            ->mapWithKeys(fn($item) => [
                $item->status => $item->revenue
            ])
            ->toArray();

        return view('admin.stats', [
            'stats' => $stats,
            'revenueChart' => $revenueChart,
            'categoryChart' => $categoryChart,
            'topProducts' => $topProducts,
            'orderStatus' => $orderStatus,
            'ordersChart' => $ordersChart,
            'revenueGrowth' => $revenueGrowth,
            'currentMonthRevenue' => $currentMonthRevenue,
            'prevMonthRevenue' => $prevMonthRevenue,
            'newUsers' => $newUsers,
            'paymentMethods' => $paymentMethods,
            'revenueByStatus' => $revenueByStatus,
        ]);
    }
}
