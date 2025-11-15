<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AIController extends Controller
{
    /**
     * Trang chủ AI - Hiển thị dashboard gợi ý
     */
    public function index()
    {
        // Lấy thống kê AI
        $aiStats = [
            'total_recommendations' => 0,
            'active_users' => 0,
            'conversion_rate' => 0,
            'avg_recommendation_accuracy' => 0,
        ];

        // Tính toán thống kê từ dữ liệu
        $totalOrders = Order::count();
        $totalUsers = User::count();
        
        if ($totalOrders > 0) {
            $aiStats['conversion_rate'] = 85; // % giả định, có thể tính từ analytics
        }
        $aiStats['active_users'] = $totalUsers;
        $aiStats['total_recommendations'] = $totalOrders * 3; // Trung bình 3 gợi ý per order
        $aiStats['avg_recommendation_accuracy'] = 92; // % giả định

        // Top sản phẩm được gợi ý
        $recommendedProducts = $this->getTopRecommendedProducts();

        // Phân tích hành vi người dùng
        $userBehaviorAnalysis = $this->getUserBehaviorAnalysis();

        // Trend gợi ý
        $recommendationTrends = $this->getRecommendationTrends();

        // Danh sách sản phẩm để gợi ý
        $allProducts = Product::where('status', 'active')
            ->with('category')
            ->get();

        // Danh sách người dùng
        $users = User::limit(20)->get();

        return view('admin.ai', [
            'aiStats' => $aiStats,
            'recommendedProducts' => $recommendedProducts,
            'userBehaviorAnalysis' => $userBehaviorAnalysis,
            'recommendationTrends' => $recommendationTrends,
            'allProducts' => $allProducts,
            'users' => $users,
        ]);
    }

    /**
     * Lấy top sản phẩm được gợi ý
     */
    private function getTopRecommendedProducts()
    {
        return DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select(
                'products.id',
                'products.name',
                'products.price',
                DB::raw('COUNT(order_items.id) as total_recommendations'),
                DB::raw('SUM(order_items.quantity) as total_quantity'),
                DB::raw('AVG(products.price) as avg_price')
            )
            ->groupBy('products.id', 'products.name', 'products.price')
            ->orderByDesc('total_recommendations')
            ->limit(10)
            ->get();
    }

    /**
     * Phân tích hành vi người dùng
     */
    private function getUserBehaviorAnalysis()
    {
        $categories = DB::table('categories')
            ->leftJoin('products', 'categories.id', '=', 'products.category_id')
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->select(
                'categories.id',
                'categories.name',
                DB::raw('COUNT(DISTINCT order_items.id) as purchase_count'),
                DB::raw('COUNT(DISTINCT products.id) as product_count')
            )
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('purchase_count')
            ->get();

        return $categories;
    }

    /**
     * Lấy trend gợi ý trong 7 ngày
     */
    private function getRecommendationTrends()
    {
        $startDate = now()->subDays(7);
        
        $trends = DB::table('orders')
            ->where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as recommendations')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = [];
        $data = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $labels[] = now()->subDays($i)->format('d/m');
            
            $trend = $trends->firstWhere('date', $date);
            $data[] = $trend ? $trend->recommendations : 0;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    /**
     * Lấy gợi ý cho người dùng cụ thể
     */
    public function getRecommendations(Request $request)
    {
        $userId = $request->get('user_id');
        $limit = $request->get('limit', 5);

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'User ID is required'
            ]);
        }

        // Lấy lịch sử mua hàng của người dùng
        $userPurchaseHistory = Order::where('user_id', $userId)
            ->with('items.product.category')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Lấy danh mục yêu thích
        $favoriteCategories = OrderItem::join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.user_id', $userId)
            ->select('products.category_id')
            ->groupBy('products.category_id')
            ->pluck('category_id')
            ->toArray();

        // Gợi ý sản phẩm từ danh mục yêu thích
        $recommendations = Product::whereIn('category_id', $favoriteCategories)
            ->where('status', 'active')
            ->with('category')
            ->inRandomOrder()
            ->limit($limit)
            ->get();

        // Nếu chưa đủ gợi ý, thêm từ sản phẩm phổ biến
        if ($recommendations->count() < $limit) {
            $additionalRecs = Product::whereNotIn('category_id', $favoriteCategories)
                ->where('status', 'active')
                ->inRandomOrder()
                ->limit($limit - $recommendations->count())
                ->get();
            $recommendations = $recommendations->merge($additionalRecs);
        }

        return response()->json([
            'success' => true,
            'recommendations' => $recommendations,
            'purchase_history' => $userPurchaseHistory,
            'favorite_categories' => $favoriteCategories,
        ]);
    }

    /**
     * Análisis de productos similares
     */
    public function getSimilarProducts(Request $request)
    {
        $productId = $request->get('product_id');
        $limit = $request->get('limit', 5);

        if (!$productId) {
            return response()->json([
                'success' => false,
                'message' => 'Product ID is required'
            ]);
        }

        $product = Product::find($productId);
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ]);
        }

        // Tìm sản phẩm trong cùng danh mục
        $similarProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $productId)
            ->where('status', 'active')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'product' => $product,
            'similar_products' => $similarProducts,
        ]);
    }

    /**
     * Thống kê gợi ý cho trang admin
     */
    public function getAIStats()
    {
        $stats = [
            'total_recommendations_today' => Order::whereDate('created_at', today())->count(),
            'total_recommendations_week' => Order::where('created_at', '>=', now()->subWeek())->count(),
            'total_recommendations_month' => Order::where('created_at', '>=', now()->subMonth())->count(),
            'avg_conversion_rate' => 85,
            'most_recommended_category' => $this->getMostRecommendedCategory(),
            'top_converting_product' => $this->getTopConvertingProduct(),
        ];

        return response()->json([
            'success' => true,
            'stats' => $stats,
        ]);
    }

    /**
     * Danh mục được gợi ý nhiều nhất
     */
    private function getMostRecommendedCategory()
    {
        return DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('COUNT(*) as count'))
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('count')
            ->first();
    }

    /**
     * Sản phẩm chuyển đổi tốt nhất
     */
    private function getTopConvertingProduct()
    {
        return DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('COUNT(*) as conversions'))
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('conversions')
            ->first();
    }
}
