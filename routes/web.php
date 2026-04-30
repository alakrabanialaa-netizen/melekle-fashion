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

// مسار عرض المنتج (مهم جداً لزر "عرض")
Route::get('/product/{id}', function ($id) {
    $product = \App\Models\Product::with('images')->findOrFail($id);
    return "صفحة المنتج: " . $product->name;
})->name('product.show');

// مسارات الأقسام (التي تظهر في الفوتر والكتالوج)
Route::name('category.')->prefix('category')->group(function () {
    Route::get('/boys', function() { return "قسم الأولاد"; })->name('boys');
    Route::get('/girls', function() { return "قسم البنات"; })->name('girls');
    Route::get('/babies', function() { return "قسم المواليد"; })->name('babies');
    Route::get('/mothers', function() { return "قسم الأمهات (نساء)"; })->name('mothers');
});

// مسارات السلة
Route::get('/cart', function () { return view('cart'); })->name('cart.index');
Route::post('/cart/add/{id}', function ($id) {
    return back()->with('success', 'تمت الإضافة للسلة');
})->name('cart.add');
Route::delete('/cart/remove/{id}', function ($id) {
    return back();
})->name('cart.remove');

// الصفحات القانونية
Route::get('/refund-policy', function () { return view('pages.refund'); })->name('refund.policy');
Route::get('/privacy-policy', function () { return "سياسة الخصوصية"; })->name('privacy.policy');
Route::get('/contact', function() { return "اتصل بنا"; })->name('contact');

// مسار الإصلاح السريع
Route::get('/fix-my-site', function () {
    Artisan::call('optimize:clear');
    return "✅ تم تنظيف الكاش بنجاح!";
});

/*
|--------------------------------------------------------------------------
| 2. لوحة تحكم المسؤول (الأدمن)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // هذا السطر سيجعل رابط /admin يعمل
    Route::get('/', function () { return view('admin.dashboard'); })->name('dashboard');
    
    // إذا كنت تريد الرابطين يعملان (/admin و /admin/dashboard)
    Route::get('/dashboard', function () { return view('admin.dashboard'); });

    Route::resource('products', ProductController::class);
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
});
});
Route::get('/products', function() { return redirect('/'); })->name('products.index');
require __DIR__.'/auth.php';
