<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard
     */
    public function index()
    {
        // Get statistics
        $stats = $this->getStatistics();
        
        // Get financial data
        $financialData = $this->getFinancialData();
        
        // Get recent products
        $recentProducts = $this->getRecentProducts();
        
        // Get chart data
        $revenueData = $this->getRevenueChartData();
        $orderData = $this->getOrderChartData();

        return view('admin.admin', array_merge(
            $stats,
            $financialData,
            [
                'recentProducts' => $recentProducts,
                'revenueData' => $revenueData,
                'orderData' => $orderData,
            ]
        ));
    }

    /**
     * Get main statistics
     */
    private function getStatistics(): array
    {
        return [
            'stats' => [
                'total_products' => Product::count(),
                'total_categories' => Category::count(),
                'total_orders' => Order::count(),
                'total_users' => User::count(),
                'pending_orders' => Order::where('status', 'pending')->count(),
            ]
        ];
    }

    /**
     * Get financial data for the current year
     */
    private function getFinancialData(): array
    {
        $currentYear = Carbon::now()->year;
        
        // YTD Revenue (từ các đơn hàng completed)
        $ytdRevenue = Order::where('status', 'completed')
            ->whereYear('created_at', $currentYear)
            ->sum('total_amount');
        
        // YTD Expenses (giả định 30% của revenue là chi phí)
        $ytdExpenses = intval($ytdRevenue * 0.3);
        
        // YTD Margin (lợi nhuận)
        $ytdMargin = $ytdRevenue - $ytdExpenses;

        return [
            'ytdRevenue' => $ytdRevenue,
            'ytdExpenses' => $ytdExpenses,
            'ytdMargin' => $ytdMargin,
        ];
    }

    /**
     * Get recent products (10 sản phẩm gần nhất)
     */
    private function getRecentProducts(): array
    {
        return Product::with('category')
            ->latest('created_at')
            ->take(10)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'stock' => $product->stock,
                    'image' => $product->image,
                ];
            })
            ->toArray();
    }

    /**
     * Get revenue chart data (12 tháng gần nhất)
     */
    private function getRevenueChartData(): array
    {
        $months = [];
        $revenues = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M Y'); // Jan 2025, Feb 2025, etc.
            
            $revenue = Order::where('status', 'completed')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('total_amount');
            
            $revenues[] = intval($revenue);
        }

        return [
            'labels' => $months,
            'data' => $revenues,
        ];
    }

    /**
     * Get order chart data (12 tháng gần nhất)
     */
    private function getOrderChartData(): array
    {
        $months = [];
        $orderCounts = [];
        $monthlyRevenues = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M Y');
            
            // Count orders
            $count = Order::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $orderCounts[] = intval($count);
            
            // Sum revenue
            $revenue = Order::where('status', 'completed')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('total_amount');
            $monthlyRevenues[] = intval($revenue);
        }

        return [
            'labels' => $months,
            'orderCounts' => $orderCounts,
            'revenue' => $monthlyRevenues,
        ];
    }
}
