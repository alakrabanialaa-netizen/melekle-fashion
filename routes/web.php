<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Admin\{
    ProductController, OrderController, UserController, ClientController,
    CouponController, ReviewController, SettingController, ReportController, AccountingController
};

/*
|--------------------------------------------------------------------------
| 1. المسارات العامة (واجهة المتجر)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    try {
        if (!file_exists(public_path('storage'))) Artisan::call('storage:link');
        $products = Schema::hasTable('products') ? \App\Models\Product::with('images')->get() : collect();
        return view('welcome', compact('products'));
    } catch (\Exception $e) {
        return "جاري تهيئة النظام... الخطأ: " . $e->getMessage();
    }
})->name('welcome');

Route::get('/product/{id}', function ($id) {
    $product = \App\Models\Product::with('images')->findOrFail($id);
    return "صفحة المنتج: " . $product->name;
})->name('product.show');

Route::name('category.')->prefix('category')->group(function () {
    Route::get('/boys', function() { return "قسم الأولاد"; })->name('boys');
    Route::get('/girls', function() { return "قسم البنات"; })->name('girls');
    Route::get('/babies', function() { return "قسم المواليد"; })->name('babies');
    Route::get('/mothers', function() { return "قسم الأمهات"; })->name('mothers');
});

Route::get('/cart', function () { return view('cart'); })->name('cart.index');
Route::post('/cart/add/{id}', function ($id) { return back(); })->name('cart.add');
Route::delete('/cart/remove/{id}', function ($id) { return back(); })->name('cart.remove');

Route::get('/refund-policy', function () { return view('pages.refund'); })->name('refund.policy');
Route::get('/privacy-policy', function () { return "سياسة الخصوصية"; })->name('privacy.policy');
Route::get('/contact', function() { return "اتصل بنا"; })->name('contact');

Route::get('/fix-my-site', function () {
    Artisan::call('optimize:clear');
    return "✅ تم تنظيف الكاش بنجاح!";
});

// هذا المسار لحل مشكلة الخطأ في صفحة welcome
Route::get('/products', function() { return redirect('/'); })->name('products.index');

/*
|--------------------------------------------------------------------------
| 2. لوحة تحكم المسؤول (الأدمن)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // الداشبورد
    Route::get('/', function () { return view('admin.dashboard'); })->name('dashboard');
    Route::get('/dashboard', function () { return view('admin.dashboard'); });

    // المسارات التي يطلبها التصميم (المنتجات، الطلبات، المستخدمين، إلخ)
    Route::resource('products', ProductController::class);
    Route::resource('orders', OrderController::class); // هذا هو السطر الذي كان ينقصك!
    Route::resource('users', UserController::class);
    Route::resource('clients', ClientController::class);
    Route::resource('coupons', CouponController::class);
    Route::resource('reviews', ReviewController::class);
    
    // الإعدادات والتقارير
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/accounting', [AccountingController::class, 'index'])->name('accounting.index');
});

require __DIR__.'/auth.php';
