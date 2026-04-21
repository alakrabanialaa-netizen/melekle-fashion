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
return view('welcome', ['products' => collect()]);
    } catch (\Exception $e) {
return view('welcome', ['products' => \App\Models\Product::all()]);
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
// 3. لوحة تحكم المسؤول وكافة مسارات الإدارة
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

    // تعريف كافة المسارات التي قد يطلبها القالب لتجنب أخطاء Route not defined
    // استبدل السطر القديم بهذا:
// مسارات إدارة المنتجات
Route::get('/products-list', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [App\Http\Controllers\Admin\ProductController::class, 'create'])->name('products.create');
Route::post('/products/store', [App\Http\Controllers\Admin\ProductController::class, 'store'])->name('products.store'); // هذا هو السطر المفقود الذي يسبب الخطأ
    // 1. الطلبات
    Route::get('/orders-list', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');

    // 2. المستخدمين / العملاء
    Route::get('/users-list', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/clients-list', [App\Http\Controllers\Admin\ClientController::class, 'index'])->name('clients.index');

    // 3. الكوبونات والتقييمات
    Route::get('/coupons-list', [App\Http\Controllers\Admin\CouponController::class, 'index'])->name('coupons.index');
    Route::get('/reviews-list', [App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('reviews.index');

    // 4. الإعدادات والتقارير والمحاسبة
    Route::get('/settings-page', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::get('/reports-page', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    Route::get('/accounting-page', [App\Http\Controllers\Admin\AccountingController::class, 'index'])->name('accounting.index');




require __DIR__.'/auth.php';
