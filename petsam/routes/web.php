<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;


Route::get('/', function () {
    $products = \App\Models\Product::with('category')->where('status', 'active')->latest()->limit(8)->get();
    $categories = \App\Models\Category::where('status', 'active')->get();
    $totalProducts = \App\Models\Product::where('status', 'active')->count();
    $totalCategories = $categories->count();
    return view('home.home', compact('products', 'categories', 'totalProducts', 'totalCategories'));
});

// Frontend Routes
Route::prefix('')->name('')->group(function () {
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('/api/categories/{category}/products', [CategoryController::class, 'getProducts'])->name('categories.products');
    Route::get('/shop', [ProductController::class, 'index'])->name('shop');
    Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');
    Route::get('/api/products/filter', [ProductController::class, 'filter'])->name('products.filter');
});

// Admin Routes
Route::prefix('/admin')->name('admin.')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::post('users/{user}/toggle-status', [\App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class);
    Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class);
    
    // API endpoints for search
    Route::get('api/permissions/search', [\App\Http\Controllers\Admin\PermissionController::class, 'search'])->name('permissions.search');
});




Auth::routes();

// GET /logout redirect to home to prevent direct link access
Route::get('/logout', function () {
    return redirect('/');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
