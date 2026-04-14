<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ReportController;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- إضافة إصلاحات الأونلاين (قاعدة البيانات وتوجيه المسؤول) ---
Route::get('/', function () {
    try {
        // 1. إنشاء الجداول تلقائياً إذا كانت مفقودة
        if (!Schema::hasTable('users')) {
            \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
            \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'UsersTableSeeder', '--force' => true]);
        }
        
        // 2. توجيه المسؤول تلقائياً للوحة التحكم إذا كان مسجلاً للدخول
        if (auth()->check() && auth()->user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        $products = \App\Models\Product::all() ?? collect();
        return view('welcome', compact('products'));
    } catch (\Exception $e) {
        return view('welcome', ['products' => collect()]);
    }
})->name('welcome');

// --- مساراتك الأصلية كما هي تماماً ---

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// مسارات المسؤول (Admin Routes) - مع التأكد من المسار الصحيح
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('users', UserController::class);
    Route::resource('coupons', CouponController::class);
    Route::resource('reviews', ReviewController::class);
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});

// مسارات الأقسام (لحماية الموقع من خطأ Route not defined)
Route::get('/category/boys', function() { return view('categories.boys'); })->name('category.boys');
Route::get('/category/girls', function() { return view('categories.girls'); })->name('category.girls');
Route::get('/category/babies', function() { return view('categories.babies'); })->name('category.babies');
Route::get('/category/mothers', function() { return view('categories.mothers'); })->name('category.mothers');
Route::get('/category/accessories', function() { return view('categories.accessories'); })->name('category.accessories');
Route::get('/offers', function() { return view('offers'); })->name('offers');
Route::get('/search', function() { return view('search'); })->name('search');
Route::get('/contact', function() { return view('contact'); })->name('contact');
Route::get('/about', function() { return view('about'); })->name('about');
Route::get('/cart', function() { return view('cart'); })->name('cart.index');
Route::get('/checkout', function() { return view('checkout'); })->name('checkout');
Route::get('/orders/history', function() { return view('orders.history'); })->name('orders.history');
Route::get('/refund-policy', function() { return view('policies.refund'); })->name('refund.policy');
Route::get('/privacy-policy', function() { return view('policies.privacy'); })->name('privacy.policy');
Route::get('/terms-conditions', function() { return view('policies.terms'); })->name('terms.conditions');
Route::get('/shipping-policy', function() { return view('policies.shipping'); })->name('shipping.policy');
Route::get('/products', function() { return view('products.index'); })->name('products.index');

require __DIR__.'/auth.php';
