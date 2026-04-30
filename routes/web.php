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
| 1. المسارات العامة (متاحة للجميع - الكتالوج، الرئيسية، الفوتر)
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

// --- أهم تعديل: مسارات الأقسام العامة ---
Route::name('category.')->prefix('category')->group(function () {
    Route::get('/boys', function() { return "قسم الأولاد"; })->name('boys');
    Route::get('/girls', function() { return "قسم البنات"; })->name('girls');
    Route::get('/babies', function() { return "قسم المواليد"; })->name('babies');
    Route::get('/mothers', function() { return "قسم الأمهات"; })->name('mothers'); // سيصلح خطأ الكتالوج
});

// الصفحات القانونية والمعلومات
Route::get('/refund-policy', function () { return view('pages.refund'); })->name('refund.policy');
Route::get('/contact', function() { return "اتصل بنا"; })->name('contact');
Route::get('/about', function() { return "من نحن"; })->name('about');

// السلة وعرض المنتجات
Route::get('/cart', function () { return view('cart'); })->name('cart.index');
Route::get('/product/{slug}', function ($slug) {
    $product = \App\Models\Product::where('slug', $slug)->with('images')->firstOrFail();
    return "صفحة المنتج: " . $product->name; 
})->name('product.show');

// مسار الإصلاح السريع (شغله من المتصفح بعد الرفع)
Route::get('/fix-my-site', function () {
    Artisan::call('optimize:clear');
    return "✅ تم تنظيف الكاش بنجاح! جرب الكتالوج الآن.";
});

/*
|--------------------------------------------------------------------------
| 2. لوحة تحكم المسؤول (محمية بكلمة مرور)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('dashboard');
    Route::resource('products', ProductController::class);
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
});

require __DIR__.'/auth.php';
