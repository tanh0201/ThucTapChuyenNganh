<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CustomerCareController;
use App\Http\Controllers\Admin\CustomerCareController as AdminCustomerCareController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\Admin\RatingController as AdminRatingController;


Route::get('/', function () {
    $products = \App\Models\Product::with('category')->where('status', 'active')->latest()->limit(8)->get();
    $categories = \App\Models\Category::where('status', 'active')->get();
    $totalProducts = \App\Models\Product::where('status', 'active')->count();
    $totalCategories = $categories->count();
    return view('home.home', compact('products', 'categories', 'totalProducts', 'totalCategories'));
});

// Frontend Routes
Route::group([], function () {
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('/categories/{category}/products', [CategoryController::class, 'getProducts'])->name('categories.products');
    
    Route::get('/shop', [ProductController::class, 'index'])->name('shop');
    Route::get('/api/products/filter', [ProductController::class, 'filter'])->name('products.filter');
    
    Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');
    
    Route::resource('customer-care', CustomerCareController::class, ['parameters' => ['customer-care' => 'customerCare']]);
    Route::get('/customer-care/my-tickets', [CustomerCareController::class, 'myTickets'])->name('customer-care.my-tickets');
    
    Route::middleware('auth')->post('/ratings', [RatingController::class, 'store'])->name('ratings.store');
});

// Admin Routes
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', AdminCategoryController::class);
    
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::post('users/{user}/toggle-status', [\App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status');
    
    Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);
    Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class);
    Route::get('permissions/search', [\App\Http\Controllers\Admin\PermissionController::class, 'search'])->name('permissions.search');
    
    Route::resource('customer-care', AdminCustomerCareController::class, ['parameters' => ['customer-care' => 'customerCare']]);
    Route::post('customer-care/{customerCare}/status', [AdminCustomerCareController::class, 'updateStatus'])->name('customer-care.update-status');
    Route::post('customer-care/{customerCare}/respond', [AdminCustomerCareController::class, 'respond'])->name('customer-care.respond');
    
    Route::resource('ratings', AdminRatingController::class);
    Route::post('ratings/{rating}/approve', [AdminRatingController::class, 'approve'])->name('ratings.approve');
    Route::post('ratings/{rating}/reject', [AdminRatingController::class, 'reject'])->name('ratings.reject');
});




Auth::routes(['verify' => false, 'reset' => false, 'confirm' => false, 'email' => false]);

// GET /logout redirect to home to prevent direct link access
Route::get('/logout', function () {
    return redirect('/');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
