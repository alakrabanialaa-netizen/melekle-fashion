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

// 1. المسار الرئيسي: الإصلاح التلقائي الشامل وعرض الصفحة الرئيسية
Route::get('/', function () {
    try {
        // --- [إصلاح مشكلة ظهور الصور] ---
        // هذا السطر يربط مجلد الصور المخفي بمجلد الموقع العام ليراها الزوار
        if (!file_exists(public_path('storage'))) {
            Artisan::call('storage:link');
        }

        // أ. صيانة جدول المنتجات (التأكد من وجود كافة الأعمدة المطلوبة)
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

        // ب. إنشاء جدول صور المنتجات إذا لم يكن موجوداً
        if (!Schema::hasTable('product_images')) {
            Schema::create('product_images', function (Blueprint $table) {
                $table->id();
                $table->string('image');
                $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
                $table->timestamps();
            });
        }

        // ج. التأكد من وجود الجداول الأساسية الأخرى
        $requiredTables = ['users', 'orders', 'categories'];
        foreach ($requiredTables as $table) {
            if (!Schema::hasTable($table)) {
                Artisan::call('migrate', ['--force' => true]);
                break;
            }
        }

        // د. جلب البيانات وعرض الصفحة
        $products = Schema::hasTable('products') ? \App\Models\Product::all() : collect();
        return view('welcome', compact('products'));

    } catch (\Exception $e) {
        return "جاري تهيئة الملفات وقاعدة البيانات، يرجى تحديث الصفحة (F5). <br> التفاصيل: " . $e->getMessage();
    }
})->name('welcome');

// 2. مسارات الأقسام والصفحات العامة
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
Route::get('/orders/history', function() { return "سجل الطلبات"; })->name('orders.history');

// سياسات الموقع
Route::get('/refund-policy', function() { return "سياسة الاسترجاع"; })->name('refund.policy');
Route::get('/privacy-policy', function() { return "سياسة الخصوصية"; })->name('privacy.policy');
Route::get('/terms-conditions', function() { return "الشروط والأحكام"; })->name('terms.conditions');
Route::get('/shipping-policy', function() { return "سياسة الشحن"; })->name('shipping.policy');

// 3. لوحة تحكم المسؤول (الأدمن)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/', function () { return redirect()->route('admin.dashboard'); });

    Route::get('/dashboard', function () {
        $productsCount = Schema::hasTable('products') ? DB::table('products')->count() : 0;
        $categoriesCount = Schema::hasTable('categories') ? DB::table('categories')->count() : 0;
        $ordersCount = Schema::hasTable('orders') ? DB::table('orders')->count() : 0;
        $usersCount = Schema::hasTable('users') ? DB::table('users')->count() : 0;
        
        return view('admin.dashboard', compact('productsCount', 'categoriesCount', 'ordersCount', 'usersCount'));
    })->name('dashboard');

    // مسارات المنتجات
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // باقي مسارات الإدارة
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
