<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\AccountingController;
use Illuminate\Database\Schema\Blueprint;

/*
|--------------------------------------------------------------------------
| المسارات العامة وإصلاحات النظام التلقائية
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    try {
        // 1. إصلاح رابط التخزين للصور
        if (!file_exists(public_path('storage'))) {
            Artisan::call('storage:link');
        }

        // 2. صيانة جدول المنتجات (إضافة الأعمدة المفقودة)
        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                if (!Schema::hasColumn('products', 'slug')) $table->string('slug')->unique()->nullable();
                if (!Schema::hasColumn('products', 'category')) $table->string('category')->nullable();
                if (!Schema::hasColumn('products', 'name')) $table->string('name')->nullable();
                if (!Schema::hasColumn('products', 'price')) $table->decimal('price', 10, 2)->default(0);
                if (!Schema::hasColumn('products', 'stock')) $table->integer('stock')->default(0);
                if (!Schema::hasColumn('products', 'description')) $table->text('description')->nullable();
                if (!Schema::hasColumn('products', 'video')) $table->string('video')->nullable();
            });
        }

        // 3. إنشاء جدول الصور إذا لم يكن موجوداً
        if (!Schema::hasTable('product_images')) {
            Schema::create('product_images', function (Blueprint $table) {
                $table->id();
                $table->string('image');
                $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
                $table->timestamps();
            });
        }

        // 4. عرض الصفحة الرئيسية مع المنتجات وصورها
        $products = Schema::hasTable('products') ? \App\Models\Product::with('images')->get() : collect();
        return view('welcome', compact('products'));

    } catch (\Exception $e) {
        return "جاري تهيئة النظام، يرجى التحديث (F5). الخطأ: " . $e->getMessage();
    }
})->name('welcome');

/*
|--------------------------------------------------------------------------
| مسارات معالجة أخطاء الـ Route Not Found (المسارات المفقودة)
|--------------------------------------------------------------------------
*/

// مسار عرض المنتج
Route::get('/product/{slug}', function ($slug) {
    $product = \App\Models\Product::where('slug', $slug)->with('images')->firstOrFail();
    return "صفحة المنتج: " . $product->name; 
})->name('product.show');

// مسار إضافة المنتج للسلة
Route::post('/cart/add/{id}', function ($id) {
    return back()->with('success', 'تم إضافة المنتج رقم ' . $id . ' إلى السلة!');
})->name('cart.add');

// مسار قائمة الرغبات (احتياطاً)
Route::post('/wishlist/add/{id}', function ($id) {
    return back();
})->name('wishlist.add');


/*
|--------------------------------------------------------------------------
| الأقسام والصفحات العامة
|--------------------------------------------------------------------------
*/

Route::name('category.')->prefix('category')->group(function () {
    Route::get('/boys', function() { return "قسم الأولاد"; })->name('boys');
    Route::get('/girls', function() { return "قسم البنات"; })->name('girls');
    Route::get('/babies', function() { return "قسم المواليد"; })->name('babies');
    Route::get('/mothers', function() { return "قسم الأمهات"; })->name('mothers');
    Route::get('/accessories', function() { return "قسم الإكسسوارات"; })->name('accessories');
});

Route::get('/offers', function() { return "العروض"; })->name('offers');
Route::get('/search', function() { return "البحث"; })->name('search');
Route::get('/contact', function() { return "اتصل بنا"; })->name('contact');
Route::get('/about', function() { return "من نحن"; })->name('about');
Route::get('/cart', function() { return "السلة"; })->name('cart.index');
Route::get('/checkout', function() { return "الدفع"; })->name('checkout');

/*
|--------------------------------------------------------------------------
| لوحة تحكم المسؤول (الأدمن)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', function () {
        $productsCount = Schema::hasTable('products') ? DB::table('products')->count() : 0;
        $categoriesCount = Schema::hasTable('categories') ? DB::table('categories')->count() : 0;
        $ordersCount = Schema::hasTable('orders') ? DB::table('orders')->count() : 0;
        $usersCount = Schema::hasTable('users') ? DB::table('users')->count() : 0;
        return view('admin.dashboard', compact('productsCount', 'categoriesCount', 'ordersCount', 'usersCount'));
    })->name('dashboard');

    // إدارة المنتجات
    Route::resource('products', ProductController::class);
    
    // باقي الإدارات
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/coupons', [CouponController::class, 'index'])->name('coupons.index');
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/accounting', [AccountingController::class, 'index'])->name('accounting.index');
});

require __DIR__.'/auth.php';
