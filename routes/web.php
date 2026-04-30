<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Admin\{
    ProductController, OrderController, UserController, ClientController,
    CouponController, ReviewController, SettingController, ReportController, AccountingController
};
use Illuminate\Database\Schema\Blueprint;

/*
|--------------------------------------------------------------------------
| 1. المسارات العامة (متاحة للزوار والزبائن)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    try {
        // (اختياري) ابقِ هذا الكود فقط في مرحلة التطوير، واحذفه عند رفع الموقع للإنتاج
        if (!file_exists(public_path('storage'))) Artisan::call('storage:link');
        
        // جلب المنتجات للرئيسية
        $products = Schema::hasTable('products') ? \App\Models\Product::with('images')->get() : collect();
        return view('welcome', compact('products'));
    } catch (\Exception $e) {
        return "جاري تهيئة النظام... الخطأ: " . $e->getMessage();
    }
})->name('welcome');

// صفحات السلة والطلب (للزوار)
Route::get('/cart', function () { return view('cart'); })->name('cart.index');
Route::delete('/cart/remove/{id}', function ($id) {
    $cart = session()->get('cart');
    if(isset($cart[$id])) {
        unset($cart[$id]);
        session()->put('cart', $cart);
    }
    return back()->with('success', 'تم إزالة المنتج من السلة');
})->name('cart.remove');

Route::post('/cart/add/{id}', function ($id) {
    return back()->with('success', 'تم إضافة المنتج للسلة!');
})->name('cart.add');

// الصفحات القانونية والمعلومات (للزوار)
Route::get('/refund-policy', function () { return view('pages.refund'); })->name('refund.policy');
Route::get('/contact', function() { return "اتصل بنا"; })->name('contact');
Route::get('/about', function() { return "من نحن"; })->name('about');
Route::get('/checkout', function() { return "الدفع"; })->name('checkout');

// عرض المنتجات والأقسام
Route::get('/product/{slug}', function ($slug) {
    $product = \App\Models\Product::where('slug', $slug)->with('images')->firstOrFail();
    return "صفحة المنتج: " . $product->name; 
})->name('product.show');

Route::name('category.')->prefix('category')->group(function () {
    Route::get('/boys', function() { return "قسم الأولاد"; })->name('boys');
    Route::get('/girls', function() { return "قسم البنات"; })->name('girls');
    Route::get('/babies', function() { return "قسم المواليد"; })->name('babies');
});

/*
|--------------------------------------------------------------------------
| 2. لوحة تحكم المسؤول (تحتاج تسجيل دخول)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', function () {
        return view('admin.dashboard'); // ضع هنا الإحصائيات التي تريد
    })->name('dashboard');

    // الإدارات الكاملة
    Route::resource('products', ProductController::class);
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    // ... باقي المسارات
});

require __DIR__.'/auth.php';
