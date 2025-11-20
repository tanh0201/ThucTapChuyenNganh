<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\StatsController;
use App\Http\Controllers\Admin\AIController;
use App\Http\Controllers\Admin\ThemeController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\NotificationController;


Route::get('/', function () {
    $products = \App\Models\Product::with('category')->where('status', 'active')->latest()->limit(8)->get();
    $categories = \App\Models\Category::where('status', 'active')->get();
    return view('home.home', compact('products', 'categories'));
});

Route::get('/shop', function () {
    $products = \App\Models\Product::with('category')->where('status', 'active')->paginate(12);
    $categories = \App\Models\Category::where('status', 'active')->get();
    return view('home.shop', compact('products', 'categories'));
});


Route::prefix('/admin')->middleware(['auth', 'is_admin'])->group(function () {
    
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/stats', [StatsController::class, 'index'])->name('admin.stats.index');
    Route::get('/ai', [AIController::class, 'index'])->name('admin.ai.index');
    Route::get('/api/ai/recommendations', [AIController::class, 'getRecommendations'])->name('admin.ai.recommendations');
    Route::get('/api/ai/similar-products', [AIController::class, 'getSimilarProducts'])->name('admin.ai.similar');
    Route::get('/api/ai/stats', [AIController::class, 'getAIStats'])->name('admin.ai.stats');

    // Theme Management
    Route::post('/api/theme/toggle', [ThemeController::class, 'toggleTheme'])->name('admin.theme.toggle');
    Route::get('/api/theme', [ThemeController::class, 'getTheme'])->name('admin.theme.get');
    Route::post('/api/theme/set', [ThemeController::class, 'setTheme'])->name('admin.theme.set');

    // Messages
    Route::get('/api/messages/recent', [MessageController::class, 'getRecent'])->name('admin.messages.recent');
    Route::post('/api/messages', [MessageController::class, 'store'])->name('admin.messages.store');
    Route::get('/api/messages/{message}', [MessageController::class, 'show'])->name('admin.messages.show');
    Route::post('/api/messages/{message}/read', [MessageController::class, 'markAsRead'])->name('admin.messages.mark-read');
    Route::delete('/api/messages/{message}', [MessageController::class, 'destroy'])->name('admin.messages.destroy');
    Route::post('/api/messages/mark-all-read', [MessageController::class, 'markAllAsRead'])->name('admin.messages.mark-all-read');

    // Notifications
    Route::get('/api/notifications/recent', [NotificationController::class, 'getRecent'])->name('admin.notifications.recent');
    Route::get('/api/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('admin.notifications.unread-count');
    Route::post('/api/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('admin.notifications.mark-read');
    Route::post('/api/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('admin.notifications.mark-all-read');
    Route::delete('/api/notifications/{notification}', [NotificationController::class, 'destroy'])->name('admin.notifications.destroy');
    Route::get('/api/notifications/type/{type}', [NotificationController::class, 'getByType'])->name('admin.notifications.by-type');

    
    Route::resource('products', ProductController::class, [
        'names' => [
            'index' => 'admin.products.index',
            'create' => 'admin.products.create',
            'store' => 'admin.products.store',
            'show' => 'admin.products.show',
            'edit' => 'admin.products.edit',
            'update' => 'admin.products.update',
            'destroy' => 'admin.products.destroy',
        ]
    ]);

    
    Route::resource('categories', CategoryController::class, [
        'names' => [
            'index' => 'admin.categories.index',
            'create' => 'admin.categories.create',
            'store' => 'admin.categories.store',
            'show' => 'admin.categories.show',
            'edit' => 'admin.categories.edit',
            'update' => 'admin.categories.update',
            'destroy' => 'admin.categories.destroy',
        ]
    ]);

    // Orders
    Route::resource('orders', OrderController::class, [
        'names' => [
            'index' => 'admin.orders.index',
            'show' => 'admin.orders.show',
            'destroy' => 'admin.orders.destroy',
        ],
        'only' => ['index', 'show', 'destroy']
    ]);
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.update-status');

    // Users
    Route::resource('users', UserController::class, [
        'names' => [
            'index' => 'admin.users.index',
            'create' => 'admin.users.create',
            'store' => 'admin.users.store',
            'show' => 'admin.users.show',
            'edit' => 'admin.users.edit',
            'update' => 'admin.users.update',
            'destroy' => 'admin.users.destroy',
        ]
    ]);
    // User Permissions Management
    Route::get('users/{user}/permissions', [UserController::class, 'getPermissions'])->name('admin.users.get-permissions');
    Route::patch('users/{user}/permissions', [UserController::class, 'updatePermissions'])->name('admin.users.update-permissions');

    // Roles & Permissions
    Route::resource('roles', RoleController::class, [
        'names' => [
            'index' => 'admin.roles.index',
            'store' => 'admin.roles.store',
            'update' => 'admin.roles.update',
            'destroy' => 'admin.roles.destroy',
        ],
        'only' => ['index', 'store', 'update', 'destroy']
    ]);

    Route::get('permissions', [RoleController::class, 'managePermissions'])->name('admin.permissions.index');
    Route::post('permissions', [RoleController::class, 'storePermission'])->name('admin.permissions.store');
    Route::delete('permissions/{permission}', [RoleController::class, 'destroyPermission'])->name('admin.permissions.destroy');
});





Auth::routes();

// GET /logout redirect to home to prevent direct link access
Route::get('/logout', function () {
    return redirect('/');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
