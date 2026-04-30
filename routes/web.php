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
| 1. المسارات العامة (متاحة للجميع: زوار وزبائن)
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

// مسار الإصلاح السريع (متاح للعامة لتتمكن من تشغيله من المتصفح مباشرة)
Route::get('/fix-my-site', function () {
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    return "✅ تم تنظيف الكاش بنجاح! جرب الموقع الآن.";
});

// صفحات السلة
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

// الصفحات القانونية والمعلومات
Route::get('/refund-policy', function () { return view('pages.refund'); })->name('refund.policy');
Route::get('/contact', function() { return "اتصل بنا"; })->name('contact');
Route::get('/about', function() { return "من نحن"; })->name('about');
Route::get('/checkout', function() { return "الدفع"; })->name('checkout');

// عرض المنتجات والأقسام (مهم جداً أن تكون خارج الـ Admin)
Route::get('/product/{slug}', function ($slug) {
    $product = \App\Models\Product::where('slug', $slug)->with('images')->firstOrFail();
    return "صفحة المنتج: " . $product->name; 
})->name('product.show');

Route::name('category.')->prefix('category')->group(function () {
    Route::get('/boys', function() { return "قسم الأولاد"; })->name('boys');
    Route::get('/girls', function() { return "قسم البنات"; })->name('girls');
    Route::get('/babies', function() { return "قسم المواليد"; })->name('babies');
    Route::get('/mothers', function() { return "قسم الأمهات (ملابس نساء)"; })->name('mothers'); // الآن سيعمل في الـ Footer
});

/*
|--------------------------------------------------------------------------
| 2. لوحة تحكم المسؤول (تحتاج تسجيل دخول Admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // الإدارات الكاملة
    Route::resource('products', ProductController::class);
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
});

require __DIR__.'/auth.php';
