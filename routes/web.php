<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

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

// توجيه من /admin إلى /admin/dashboard
Route::get('/admin', function () {
    return redirect('/admin/dashboard');
})->middleware(['auth']);

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

// 3. لوحة تحكم المسؤول (كود مرن يتجاوز أخطاء الموديلات المفقودة)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        // سنقوم بجلب البيانات بطريقة يدوية تتجنب خطأ "Class not found"
        $productsCount = Schema::hasTable('products') ? \Illuminate\Support\Facades\DB::table('products')->count() : 0;
        $categoriesCount = Schema::hasTable('categories') ? \Illuminate\Support\Facades\DB::table('categories')->count() : 0;
        $ordersCount = Schema::hasTable('orders') ? \Illuminate\Support\Facades\DB::table('orders')->count() : 0;
        $usersCount = Schema::hasTable('users') ? \Illuminate\Support\Facades\DB::table('users')->count() : 0;
        $recentOrders = collect(); // سنتركها فارغة مؤقتاً لضمان الدخول
        
        return view('admin.dashboard', compact(
            'productsCount', 
            'categoriesCount', 
            'ordersCount', 
            'usersCount', 
            'recentOrders'
        ));
    })->name('dashboard');
});

require __DIR__.'/auth.php';
