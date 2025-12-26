<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\EmailLogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CustomerCareController;
use App\Http\Controllers\Admin\CustomerCareController as AdminCustomerCareController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\Admin\RatingController as AdminRatingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;


Route::get('/', function () {
    $products = \App\Models\Product::with('category')->where('status', 'active')->latest()->limit(8)->get();
    $categories = \App\Models\Category::where('status', 'active')->get();
    $totalProducts = \App\Models\Product::where('status', 'active')->count();
    $totalCategories = $categories->count();
    
    // Get customer stats
    $totalCustomers = \App\Models\User::where('role_id', '!=', 1)->count();
    $avgRating = \App\Models\Rating::where('status', 'approved')->avg('rating') ?? 0;
    $ratings = \App\Models\Rating::with('user', 'product')
        ->where('status', 'approved')
        ->latest()
        ->limit(6)
        ->get();
    
    return view('home.home', compact('products', 'categories', 'totalProducts', 'totalCategories', 'totalCustomers', 'avgRating', 'ratings'));
});

// Frontend Routes
Route::group([], function () {
    Route::get('/search', [\App\Http\Controllers\SearchController::class, 'index'])->name('search');
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('/categories/{category}/products', [CategoryController::class, 'getProducts'])->name('categories.products');
    Route::get('/shop', [ProductController::class, 'index'])->name('shop');
    Route::get('/api/products/filter', [ProductController::class, 'filter'])->name('products.filter');
    Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');
    Route::resource('customer-care', CustomerCareController::class, ['parameters' => ['customer-care' => 'customerCare']]);
    Route::get('/customer-care/my-tickets', [CustomerCareController::class, 'myTickets'])->name('customer-care.my-tickets');
    Route::resource('contact', ContactController::class, ['only' => ['index', 'store']]);
    Route::post('/ratings', [RatingController::class, 'store'])->name('ratings.store')->middleware('auth');
    Route::middleware('auth')->resource('favorites', \App\Http\Controllers\FavoriteController::class, ['only' => ['index']]);
    Route::middleware('auth')->post('/favorites/{product}/toggle', [\App\Http\Controllers\FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::middleware('auth')->get('/favorites/{product}/check', [\App\Http\Controllers\FavoriteController::class, 'check'])->name('favorites.check');
    Route::middleware('auth')->delete('/favorites/{product}', [\App\Http\Controllers\FavoriteController::class, 'destroy'])->name('favorites.destroy');

    // Cart Routes
    Route::resource('cart', CartController::class, ['only' => ['index']]);
    Route::post('cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('cart/count', [CartController::class, 'getCount'])->name('cart.count');

    // Checkout & Settings (Auth Required)
    Route::middleware('auth')->group(function () {
        Route::resource('checkout', CheckoutController::class, ['only' => ['index', 'store']]);
        Route::get('checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
        Route::get('checkout/{order}', [CheckoutController::class, 'show'])->name('checkout.show');
        Route::post('checkout/{order}/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');
        Route::get('my-orders', [CheckoutController::class, 'myOrders'])->name('checkout.myOrders');
        Route::get('checkout/payment/bank-transfer/{order}', [CheckoutController::class, 'bankTransferInfo'])->name('checkout.bank-transfer');

        Route::resource('settings', \App\Http\Controllers\SettingsController::class, ['only' => ['index']]);
        Route::post('settings/profile', [\App\Http\Controllers\SettingsController::class, 'updateProfile'])->name('settings.updateProfile');
        Route::post('settings/password', [\App\Http\Controllers\SettingsController::class, 'updatePassword'])->name('settings.updatePassword');
        Route::post('settings/delete', [\App\Http\Controllers\SettingsController::class, 'deleteAccount'])->name('settings.deleteAccount');
    });
});

// Admin Routes
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);
    Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class);
    Route::resource('customer-care', AdminCustomerCareController::class, ['parameters' => ['customer-care' => 'customerCare']]);
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class, ['only' => ['index', 'show', 'destroy']]);
    Route::resource('ratings', AdminRatingController::class);
    Route::resource('contacts', AdminContactController::class);
    Route::resource('email-logs', EmailLogController::class, ['only' => ['index', 'destroy']]);
    
    // Custom Actions
    Route::post('users/{user}/toggle-status', [\App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::get('permissions/search', [\App\Http\Controllers\Admin\PermissionController::class, 'search'])->name('permissions.search');
    Route::post('customer-care/{customerCare}/status', [AdminCustomerCareController::class, 'updateStatus'])->name('customer-care.update-status');
    Route::post('customer-care/{customerCare}/respond', [AdminCustomerCareController::class, 'respond'])->name('customer-care.respond');
    Route::post('orders/{order}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::post('orders/{order}/payment-status', [\App\Http\Controllers\Admin\OrderController::class, 'updatePaymentStatus'])->name('orders.updatePaymentStatus');
    Route::post('contacts/{contact}/mark-responded', [AdminContactController::class, 'markResponded'])->name('contacts.mark-responded');
    Route::post('email-logs/delete-failed', [EmailLogController::class, 'deleteFailed'])->name('email-logs.delete-failed');
    Route::post('email-logs/clear-old', [EmailLogController::class, 'clearOldLogs'])->name('email-logs.clear-old');
});




Auth::routes(['verify' => false, 'reset' => false, 'confirm' => false, 'email' => false]);


Route::get('/logout', function () {
    return redirect('/');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
