<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\Admin\DashboardController;

// 1. المسار الرئيسي مع إصلاح الجداول وتوجيه المسؤول
Route::get('/', function () {
    try {
        if (!Schema::hasTable('users')) {
            \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
            \Illuminate\Support\Facades\Artisan::call('db:seed', ['--class' => 'UsersTableSeeder', '--force' => true]);
        }
        
        if (auth()->check()) {
            return redirect('/admin/dashboard');
        }

        return view('welcome', ['products' => collect()]);
    } catch (\Exception $e) {
        return view('welcome', ['products' => collect()]);
    }
})->name('welcome');

// 2. تعريف المسارات الأساسية لتجنب أخطاء القالب
Route::get('/category/boys', function() { return "قسم الأولاد"; })->name('category.boys');
Route::get('/category/girls', function() { return "قسم البنات"; })->name('category.girls');
Route::get('/category/babies', function() { return "قسم المواليد"; })->name('category.babies');
Route::get('/category/mothers', function() { return "قسم الأمهات"; })->name('category.mothers');
Route::get('/category/accessories', function() { return "قسم الإكسسوارات"; })->name('category.accessories');
Route::get('/offers', function() { return "العروض"; })->name('offers');
Route::get('/search', function() { return "البحث"; })->name('search');
Route::get('/contact', function() { return "اتصل بنا"; })->name('contact');
Route::get('/about', function() { return "من نحن"; })->name('about');
Route::get('/cart', function() { return "السلة"; })->name('cart.index');
Route::get('/checkout', function() { return "الدفع"; })->name('checkout');
Route::get('/orders/history', function() { return "سجل الطلبات"; })->name('orders.history');
Route::get('/refund-policy', function() { return "سياسة الاسترجاع"; })->name('refund.policy');
Route::get('/privacy-policy', function() { return "سياسة الخصوصية"; })->name('privacy.policy');
Route::get('/terms-conditions', function() { return "الشروط والأحكام"; })->name('terms.conditions');
Route::get('/shipping-policy', function() { return "سياسة الشحن"; })->name('shipping.policy');
Route::get('/products', function() { return "المنتجات"; })->name('products.index');

// 3. لوحة تحكم المسؤول (بدون Middleware 'admin' مؤقتاً للتأكد من الدخول)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

require __DIR__.'/auth.php';
