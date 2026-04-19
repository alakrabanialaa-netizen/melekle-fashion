<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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

// 3. لوحة تحكم المسؤول وكافة مسارات الإدارة (Resources)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // لوحة التحكم
    Route::get('/dashboard', function () {
        $productsCount = Schema::hasTable('products') ? DB::table('products')->count() : 0;
        $categoriesCount = Schema::hasTable('categories') ? DB::table('categories')->count() : 0;
        $ordersCount = Schema::hasTable('orders') ? DB::table('orders')->count() : 0;
        $usersCount = Schema::hasTable('users') ? DB::table('users')->count() : 0;
        
        $recentOrders = collect();
        $recentActivities = collect();
        $totalRevenue = 0;
        $monthlyRevenue = collect();
        
        return view('admin.dashboard', compact(
            'productsCount', 'categoriesCount', 'ordersCount', 'usersCount', 
            'recentOrders', 'recentActivities', 'totalRevenue', 'monthlyRevenue'
        ));
    })->name('dashboard');

    // تعريف مسارات الإدارة (Resources) لضمان عدم حدوث خطأ Route not defined
    Route::get('/products-list', function() { return "قائمة المنتجات"; })->name('products.index');
    Route::get('/categories-list', function() { return "قائمة الأقسام"; })->name('categories.index');
    Route::get('/orders-list', function() { return "قائمة الطلبات"; })->name('orders.index');
    Route::get('/users-list', function() { return "قائمة المستخدمين"; })->name('users.index');
    Route::get('/clients-list', function() { return "قائمة العملاء"; })->name('clients.index');
    Route::get('/coupons-list', function() { return "قائمة الكوبونات"; })->name('coupons.index');
    Route::get('/reviews-list', function() { return "قائمة التقييمات"; })->name('reviews.index');
    Route::get('/settings-page', function() { return "الإعدادات"; })->name('settings.index');
    Route::get('/reports-page', function() { return "التقارير"; })->name('reports.index');
});

require __DIR__.'/auth.php';
