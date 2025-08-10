<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Auth\CustomRegisterController;
use App\Http\Controllers\Auth\CustomLoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminVerificationController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Search routes
Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::get('/search/suggestions', [SearchController::class, 'suggestions'])->name('search.suggestions');

// Custom Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('login', [CustomLoginController::class, 'create'])->name('login');
    Route::post('login', [CustomLoginController::class, 'store']);
    Route::get('register', [CustomRegisterController::class, 'create'])->name('register');
    Route::post('register', [CustomRegisterController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [CustomLoginController::class, 'destroy'])->name('logout');
});

// Include the rest of the auth routes (password reset, email verification, etc.)
require __DIR__.'/auth.php';

// Product routes
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/category/{category:slug}', [ProductController::class, 'index'])->name('products.category');
});

// Product detail route (outside prefix to avoid conflicts)
Route::get('/product/{product:slug}', [ProductController::class, 'show'])->name('products.show');

// Protected routes
Route::middleware('auth')->group(function () {
    // Dashboard route
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        // Load necessary relationships
        $user->load(['orders', 'cartItems']);
        
        return view('dashboard');
    })->name('dashboard');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Cart routes
    Route::prefix('cart')->middleware(['auth'])->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::post('/add', [CartController::class, 'add'])->name('cart.add');
        Route::patch('/{cartItem}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
        Route::delete('/', [CartController::class, 'clear'])->name('cart.clear');
        Route::get('/count', [CartController::class, 'count'])->name('cart.count');
        Route::get('/items', [CartController::class, 'items'])->name('cart.items');
    });

    // Orders routes
    Route::prefix('orders')->middleware(['auth'])->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/{order}', [OrderController::class, 'show'])->name('orders.show');
    });

    // Checkout routes
    Route::prefix('checkout')->middleware(['auth'])->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/', [CheckoutController::class, 'store'])->name('checkout.store');
        Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
    });
    
    // Wishlist routes
    Route::prefix('wishlist')->middleware(['auth'])->group(function () {
        Route::get('/', [App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');
        Route::post('/add', [App\Http\Controllers\WishlistController::class, 'add'])->name('wishlist.add');
        Route::post('/remove', [App\Http\Controllers\WishlistController::class, 'remove'])->name('wishlist.remove');
    });
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Product management
    Route::resource('products', AdminProductController::class)->names([
        'index' => 'admin.products.index',
        'create' => 'admin.products.create',
        'store' => 'admin.products.store',
        'show' => 'admin.products.show',
        'edit' => 'admin.products.edit',
        'update' => 'admin.products.update',
        'destroy' => 'admin.products.destroy',
    ]);
    
    // Additional product routes
    Route::delete('/products/images/{image}', [AdminProductController::class, 'deleteImage'])->name('admin.products.images.delete');
    Route::get('/products/stock-alerts', [AdminProductController::class, 'stockAlerts'])->name('admin.products.stock-alerts');
    Route::patch('/products/{product}/toggle-status', [AdminProductController::class, 'toggleStatus'])->name('admin.products.toggle-status');
    Route::post('/products/bulk-update', [AdminProductController::class, 'bulkUpdate'])->name('admin.products.bulk-update');
    Route::get('/products/export', [AdminProductController::class, 'export'])->name('admin.products.export');
    
    // Order management
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show', 'update'])->names([
        'index' => 'admin.orders.index',
        'show' => 'admin.orders.show',
        'update' => 'admin.orders.update',
    ]);
    
    // User verification management
    // User management
    Route::resource('users', AdminUserController::class)->only(['index', 'show', 'edit', 'update'])->names([
        'index' => 'admin.users.index',
        'show' => 'admin.users.show',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
    ]);

    // Notification routes
    Route::get('/notifications/check', [NotificationController::class, 'check'])->name('admin.notifications.check');
});

// User notification routes
Route::middleware('auth')->group(function () {
    Route::get('/notifications/user', [NotificationController::class, 'userNotifications'])->name('notifications.user');
});

// Static pages
Route::view('/about', 'pages.about')->name('about');
Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store']);
Route::view('/privacy', 'pages.privacy')->name('privacy');
Route::view('/terms', 'pages.terms')->name('terms');