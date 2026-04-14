<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

// 1. المسار الرئيسي مع إصلاح الجداول وتوجيه المسؤول تلقائياً
Route::get('/', function () {
    try {
        if (!Schema::hasTable('users')) {
            \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
            \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'UsersTableSeeder', '--force' => true]);
        }
        
        if (auth()->check() && auth()->user()->is_admin) {
            return redirect('/admin/dashboard');
        }

        $products = \App\Models\Product::all() ?? collect();
        return view('welcome', compact('products'));
    } catch (\Exception $e) {
        return view('welcome', ['products' => collect()]);
    }
})->name('welcome');

// 2. تعريف كافة المسارات المطلوبة في القالب (لحل أخطاء Route not defined)
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

// 3. لوحة تحكم المسؤول (استخدام المسار الكامل للـ Controller لحل مشكلة Not Found)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // سنستخدم المسار المباشر للكلاس لضمان عمله
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('coupons', \App\Http\Controllers\Admin\CouponController::class);
    Route::resource('reviews', \App\Http\Controllers\Admin\ReviewController::class);
    
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
});

require __DIR__.'/auth.php';
